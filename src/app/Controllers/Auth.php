<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\PasswordResetModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Email\Email;

class Auth extends BaseController{
    
    public function login(){
        $data = [
            'title' => 'Iniciar Sesión',
            'body' => view('auth/login')
        ];
        return view('layouts/auth', $data);
    }

    public function process_login(){
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('usr');
        $password = $this->request->getPost('pwd');
        $rememberMe = $this->request->getPost('remember_me');

        // Validar si faltan datos
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Buscar usuario en la base de datos
        $user = $model->where('usr', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'El usuario no existe.');
        }

        // Verificar la contraseña
        if (!password_verify($password, $user['pwd'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        // Iniciar sesión
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['usr'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ]);

        // ✅ Si activó "Remember Me", creamos una cookie
        if ($rememberMe) {
            set_cookie([
                'name'   => 'remember_token',
                'value'  => base64_encode($user['id']),
                'expire' => 86400 * 30, // 30 días
                'secure' => true,
                'httponly' => true,
            ]);
        }

        return redirect()->to('/dashboard');
    }

    public function logout(){
        delete_cookie('remember_token');
        session()->destroy();
        
        return redirect()->to('/login');
    }

    public function register(){
        $data = [
            'title' => 'Iniciar Sesión',
            'body' => view('auth/register')
        ];
        return view('layouts/auth', $data);
    }

    public function process_register(){
        $rules = [
            'nombre' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[xx_usuarios.email]',
            'pwd' => 'required|min_length[6]',
            'confirm_pwd' => 'required|matches[pwd]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $userModel = new UserModel();
        $userId = $userModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'usr'    => $this->request->getPost('email'), 
            'email'  => $this->request->getPost('email'),
            'pwd'    => password_hash($this->request->getPost('pwd'), PASSWORD_DEFAULT)
        ]);

        // Asignar rol por defecto (user)
        $userRoleModel = new UserRoleModel();
        $userRoleModel->insert([
            'user_id' => $userId,
            'role_id' => 3 // user
        ]);
    
        return redirect()->to('/login')->with('success', 'Usuario creado correctamente. Ahora puedes iniciar sesión.');
    }
    
    public function forgot_password(){

        $data = [
            'title' => 'Iniciar Sesión',
            'body' => view('auth/forgot_password')
        ];
        return view('layouts/auth', $data);
    }
    
    public function proccess_forgot_password(){
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
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

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Restablecer Contraseña');
        $emailService->setMessage($message);

        if ($emailService->send()) {
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

        $userModel = new UserModel();
        $userModel->where('email', $reset['email'])
                ->set(['pwd' => password_hash($password, PASSWORD_DEFAULT)])
                ->update();

        // Eliminar el token usado
        $resetModel->where('email', $reset['email'])->delete();

        return redirect()->to('/login')->with('success', 'Contraseña restablecida. Inicia sesión.');
    }
}