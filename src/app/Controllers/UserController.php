<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatUserModel;
use App\Models\CatEmpresaModel;
use App\Models\CatRoleModel;
use App\Models\UserRoleModel;
use App\Models\UserEmpresaModel;

class UserController extends BaseController
{
    public function index(){
        $model = new CatUserModel();        
        $modelRole = new CatRoleModel();        
        $modelEmpresa = new CatEmpresaModel();    
        $data['data'] = $model
            ->where('sys_usuarios_empresas.id_empresa', $this->id_empresa)
            ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id', 'left')
            ->join('cat_empresas', 'cat_empresas.id = sys_usuarios_empresas.id_empresa', 'left')
            ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
            ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
            ->select('cat_usuarios.*, cat_sys_roles.name AS role, cat_empresas.nombre AS empresa')
            ->findAll();
        $data['list_role'] = $modelRole->where(['status_alta' => 1])->findAll();
        $data['list_empresa'] = $modelEmpresa->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'admin/users/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatUserModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['email'],
            'field_name'  => 'usuario',
            'view' => [
                'load' => 'admin/users/ajax/table_data',
                'data'  => function(){
                    return (new CatUserModel())
                        ->where('sys_usuarios_empresas.id_empresa', $this->id_empresa)
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id', 'left')
                        ->join('cat_empresas', 'cat_empresas.id = sys_usuarios_empresas.id_empresa', 'left')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role, cat_empresas.nombre AS empresa')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS EL DATA
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->nombre = limpiar_cadena_texto($return->nombre);
                $return->usr = $return->email;
                if($return->pwd == ""){
                    unset($return->pwd);
                }else{
                    $return->pwd = password_hash($return->pwd, PASSWORD_DEFAULT);
                }                   
                unset($return->confirm_pwd);
                
                return $return;
            },
            'postcallback' => function($id, $data){
                // UNA VEZ QUE SE HAYA INSERTADO, ASIGNAMEROS EL ROLE AL USUARIO Y CREAMOS EL USUARIO EMPRESA
                $modelUsuarioEmpresa = new UserEmpresaModel();
                $modelUsuarioEmpresa->insert([
                    'id_usuario' => $id,
                    'id_empresa' => $data->id_empresa
                ]);

                $userRoleModel = new UserRoleModel();
                $userRoleModel->insert([
                    'id_usuario_empresa' => $modelUsuarioEmpresa->getInsertID(),
                    'id_role' => $data->id_role
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
                    ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id', 'left')
                    ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                    ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                    ->select('cat_usuarios.id, cat_usuarios.nombre, cat_usuarios.usr, cat_usuarios.status_alta, cat_usuarios.email, cat_sys_roles.id AS id_role, cat_sys_roles.name AS role, sys_usuarios_empresas.id_empresa')
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
                        ->where('sys_usuarios_empresas.id_empresa', $this->id_empresa)
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id', 'left')
                        ->join('cat_empresas', 'cat_empresas.id = sys_usuarios_empresas.id_empresa', 'left')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role, cat_empresas.nombre AS empresa')
                        ->findAll();
                }
                
            ],        
            'precallback' => function ($return) {
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->nombre = limpiar_cadena_texto($return->nombre);
                if($return->pwd == ""){
                    unset($return->pwd);
                }else{
                    $return->pwd = password_hash($return->pwd, PASSWORD_DEFAULT);
                } 
                
                return $return;
            },
            'postcallback' => function($id, $data){
                // UNA VEZ QUE SE HAYA ACTUALIZADO, ASIGNAMEROS EL ROLE AL USUARIO PERO ANTES, HAY QUE VALIDAR QUE EXISTA
                // HAY QUE BUSCAR EL ID_USUARIO_EMPRESA ANTES DE REALIZAR LA ACTUALIZACION
                $modelUsuarioEmpresa = new UserEmpresaModel();
                $encontrado = $modelUsuarioEmpresa->where('id_usuario', $id)->first();
                
                if(!empty($encontrado)){
                    $modelUsuarioEmpresa->where('id_usuario', $id)
                        ->set(['id_empresa' => $data->id_empresa])
                        ->update();        
                
                    $userRoleModel = new UserRoleModel();
                    $userRoleModel->where('id_usuario_empresa', $encontrado['id'])
                        ->set(['id_role' => $data->id_role])
                        ->update();                
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
                        ->where('sys_usuarios_empresas.id_empresa', $this->id_empresa)
                        ->join('sys_usuarios_empresas', 'sys_usuarios_empresas.id_usuario = cat_usuarios.id', 'left')
                        ->join('cat_empresas', 'cat_empresas.id = sys_usuarios_empresas.id_empresa', 'left')
                        ->join('sys_user_roles', 'sys_user_roles.id_usuario_empresa = sys_usuarios_empresas.id',' left')
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_user_roles.id_role', 'left')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role, cat_empresas.nombre AS empresa')
                        ->findAll();
                }
            ]         
        ]);
    }
}