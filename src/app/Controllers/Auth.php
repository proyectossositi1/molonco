<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

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
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout(){
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
            'email' => 'required|valid_email|is_unique[admon_usuarios.email]',
            'pwd' => 'required|min_length[6]',
            'confirm_pwd' => 'required|matches[pwd]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $model = new UserModel();
        $model->insert([
            'nombre' => $this->request->getPost('nombre'),
            'usr'    => $this->request->getPost('email'), 
            'email'  => $this->request->getPost('email'),
            'pwd'    => password_hash($this->request->getPost('pwd'), PASSWORD_DEFAULT)
        ]);
    
        return redirect()->to('/login')->with('success', 'Usuario creado correctamente. Ahora puedes iniciar sesión.');
    }

}