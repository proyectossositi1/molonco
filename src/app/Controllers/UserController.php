<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatUserModel;
use App\Models\CatRoleModel;
use App\Models\UserRoleModel;
use App\Models\UserEmpresaModel;

class UserController extends BaseController
{
    public function index(){
        $model = new CatUserModel();        
        $modelRole = new CatRoleModel();        
        $data['data'] = $model
            ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id')
            ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
            ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
            ->select('cat_usuarios.*, cat_sys_roles.name AS role')
            ->findAll();
        $data['list_role'] = $modelRole->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'admin/users/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatUserModel();
        $id_role = ($data->id_role == "") ? "" :  $data->id_role ;

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['email'],
            'field_name'  => 'usuario',
            'view' => [
                'load' => 'admin/users/ajax/table_data',
                'data'  => function(){
                    return (new CatUserModel())
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS EL DATA
                $return->nombre = limpiar_cadena_texto($return->nombre);
                $return->usr = $return->email;
                if($return->pwd == ""){
                    unset($return->pwd);
                }else{
                    $return->pwd = password_hash($return->pwd, PASSWORD_DEFAULT);
                }                   
                unset($return->confirm_pwd, $return->id_role);
                
                return $return;
            },
            'postcallback' => function($id, $data) use ($id_role){
                // UNA VEZ QUE SE HAYA INSERTADO, ASIGNAMEROS EL ROLE AL USUARIO
                $userRoleModel = new UserRoleModel();
                $userRoleModel->insert([
                    'id_usuario_empresa' => $id,
                    'id_role' => $id_role
                ]);
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
    
        return process_edit([
            'data' => $data,
            'model' => new CatUserModel(),
            'field_name' => 'usuario',
            'query' => function($model, $id) {
                return $model->where(['cat_usuarios.id' => $id])
                    ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id')
                    ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                    ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                    ->select('cat_usuarios.id, cat_usuarios.nombre, cat_usuarios.usr, cat_usuarios.status_alta, cat_usuarios.email, cat_sys_roles.id AS id_role, cat_sys_roles.name AS role')
                    ->first();
            }
        ]);
    }

    function update(){
        $data = json_decode($this->request->getPost('data'));
        $model = new CatUserModel();
        $id_role = ($data->id_role == "") ? "" :  $data->id_role ;
        
        return process_update([
            'data' => $data,
            'model' => $model,
            'field_check' => ['name'],
            'field_name' => 'usuario',
            'view' => [
                'load' => 'admin/users/ajax/table_data',
                'data'  => function(){
                    return (new CatUserModel())
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role')
                        ->findAll();
                }
                
            ],        
            'precallback' => function ($return) {
                $return->nombre = limpiar_cadena_texto($return->nombre);
                
                return $return;
            },
            'postcallback' => function($id, $data){
                // UNA VEZ QUE SE HAYA ACTUALIZADO, ASIGNAMEROS EL ROLE AL USUARIO PERO ANTES, HAY QUE VALIDAR QUE EXISTA
                // HAY QUE BUSCAR EL ID_USUARIO_EMPRESA ANTES DE REALIZAR LA ACTUALIZACION
                $modelUsuarioEmpresa = new UserEmpresaModel();
                $encontrado = $modelUsuarioEmpresa->where('id_usuario', $id)->first();

                if(!empty($encontrado)){
                    $userRoleModel = new UserRoleModel();
                    if(!$userRoleModel->where(['id_usuario_empresa' => $encontrado['id']])->first()){
                        $userRoleModel->insert([
                            'id_usuario_empresa' => $encontrado['id'],
                            'id_role' => $data->id_role
                        ]);
                    }else{
                        $userRoleModel->where('id_usuario_empresa', $encontrado['id'])
                            ->set(['id_role' => $data->id_role])
                            ->update();
                    }
                }
                
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatUserModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'usuario',
            'view' => [
                'load' => 'admin/users/ajax/table_data',
                'data'  => function(){
                    return (new CatUserModel())
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role')
                        ->findAll();
                }
            ]         
        ]);
    }
}