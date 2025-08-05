<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatUserModel;
use App\Models\UserRoleModel;
use App\Models\PasswordResetModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Email\Email;
use App\Libraries\EmailService;

class AuthController extends BaseController{
    
    public function login(){
        return renderPage([
            'layout'    => 'auth',
            'view'  => 'auth/login'
        ]);
    }

    public function process_login(){
        $session = session();
        $model = new CatUserModel();

        $username = $this->request->getPost('usr');
        $password = $this->request->getPost('pwd');
        $rememberMe = $this->request->getPost('remember_me');

        // Validar si faltan datos
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Buscar usuario en la base de datos
        $user = $model->select('cat_usuarios.id, cat_usuarios.usr, cat_usuarios.pwd, cat_usuarios.email, cat_usuarios.id_instancia, cat_usuarios.id_role, cat_sys_roles.name AS role, sys_instancias.nombre AS instancia')
            ->join('cat_sys_roles', 'cat_sys_roles.id = cat_usuarios.id_role')   
            ->join('sys_instancias', 'sys_instancias.id = cat_usuarios.id_instancia')   
            ->where(['cat_usuarios.status_alta' => 1, 'cat_usuarios.usr' => $username])
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'El usuario no existe.');
        }

        // Verificar la contraseña
        if (!password_verify($password, $user['pwd'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        // Iniciar sesión
        $data = [
            'id_usuario'    => $user['id'],
            'id_instancia'  => $user['id_instancia'],
            'username'      => $user['usr'],
            'email'         => $user['email'],
            'id_role'       => $user['id_role'],
            'role'          => $user['role'],
            'instancia'     => $user['instancia'],
            'isLoggedIn'    => true,
        ];
        $session->set($data);

        // Si activó "Remember Me", creamos una cookie
        if ($rememberMe) {
            $response = service('response');
             // Elimina la cookie anterior (opcional, pero recomendado)
            $response->deleteCookie('remember_token');
            unset($data['isLoggedIn']);

            $response->setCookie([
                'name'     => 'remember_token',
                'value'    => base64_encode(json_encode($data)),
                'expire'   => 86400 * 30, // 30 días
                'secure'   => false,      // TRUE solo si estás en HTTPS
                'httponly' => true,
                'path'     => '/',
                'samesite' => 'Lax',
            ]);
            
            return $response->redirect('/dashboard');
        }

        return redirect()->to('/dashboard');
    }

    public function logout(){
        $response = service('response');
        $response->deleteCookie('remember_token', '', '/');
        
        session()->destroy();
        
        return $response->redirect('/login');
    }

    public function register(){
        return renderPage([
            'layout'    => 'auth',
            'view'  => 'auth/register'
        ]);
    }

    public function process_register(){
        $rules = [
            'nombre' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[cat_usuarios.email]',
            'pwd' => 'required|min_length[6]',
            'confirm_pwd' => 'required|matches[pwd]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $userModel = new CatUserModel();
        $userId = $userModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'usr'    => $this->request->getPost('email'), 
            'email'  => $this->request->getPost('email'),            
            'pwd'    => password_hash($this->request->getPost('pwd'), PASSWORD_DEFAULT)
        ]);
    
        return redirect()->to('/login')->with('success', 'Usuario creado correctamente. Ahora puedes iniciar sesión.');
    }
    
    public function forgot_password(){
        return renderPage([
            'layout'    => 'auth',
            'view'  => 'auth/forgot_password'
        ]);
    }
    
    public function proccess_forgot_password(){
        $email = $this->request->getPost('email');
        $userModel = new CatUserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'No se encontró ese correo.');
        }

        // Crear token
        $token = bin2hex(random_bytes(32));
        $expiresAt = Time::now()->addMinutes(30); // Expira en 30 minutos

        // Guardar token en DB
        $resetModel = new PasswordResetModel();
        $resetModel->insert([
            'email' => $email,
            'token' => hash('sha256', $token),
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);

        // Enviar correo
        $resetLink = site_url("reset-password?token={$token}");
        $message = "
            <h2>Restablece tu contraseña</h2>
            <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
            <p><a href='{$resetLink}'>Restablecer Contraseña</a></p>
            <p>Este enlace expirará en 30 minutos.</p>
        ";

        $emailService = new EmailService();
        $data = [
            'to'         => $email,
            'subject'    => 'Restablece Contraseña',
            'body'       => $message
        ];

        if ($emailService->sendEmail($data)) {
            return redirect()->back()->with('success', 'Se envió un enlace a tu correo.');
        } else {
            return redirect()->back()->with('error', 'Error al enviar el correo.');
        }
    }

    public function reset_password(){
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm = $this->request->getPost('confirm_password');

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        $resetModel = new PasswordResetModel();
        $reset = $resetModel->where('token', hash('sha256', $token))->first();

        if (!$reset || Time::now()->isAfter($reset['expires_at'])) {
            return redirect()->back()->with('error', 'El enlace es inválido o ha expirado.');
        }

        $userModel = new CatUserModel();
        $userModel->where('email', $reset['email'])
                ->set(['pwd' => password_hash($password, PASSWORD_DEFAULT)])
                ->update();

        // Eliminar el token usado
        $resetModel->where('email', $reset['email'])->delete();

        return redirect()->to('/login')->with('success', 'Contraseña restablecida. Inicia sesión.');
    }

    public function enviar_correo(){
        $emailService = new EmailService();

        $data = [
            'to'         => ['janto_sega5@hotmail.com', 'jorge.arg091@gmail.com'],
            'subject'    => 'Bienvenido a nuestro sistema',
            'body'       => '<h1>Gracias por registrarte</h1><p>Estamos felices de tenerte.</p>',
            // 'attachments'=> [WRITEPATH . 'uploads/manual.pdf'],
            // 'cc'         => 'admin@example.com',
            // 'bcc'        => 'auditoria@example.com',
            // 'reply_to'   => 'soporte@example.com',
        ];

        if ($emailService->sendEmail($data)) {
            echo "✅ Correo enviado correctamente.";
        } else {
            echo "❌ Error al enviar el correo.";
        }
    }
}