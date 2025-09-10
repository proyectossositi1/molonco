<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatUserModel;
use App\Models\CatRoleModel;
// use App\Models\UserRoleModel;

class UserController extends BaseController
{

    function __construct(){
        $this->modelCatUserModel = new CatUserModel();  
        $this->modelCatRoleModel = new CatRoleModel();  
        // $this->modelUserRoleModel = new UserRoleModel();  
    }
    
    public function index(){        
        $data['data'] = $this->modelCatUserModel
            ->where(['cat_usuarios.id_instancia' => $this->id_instancia])
            ->join('cat_sys_roles', 'cat_sys_roles.id = cat_usuarios.id_role')
            ->select('cat_usuarios.*, cat_sys_roles.name AS role')
            ->findAll();
        $data['list_role'] = $this->modelCatRoleModel->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        
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
                    return ($this->modelCatUserModel)
                        ->where(['cat_usuarios.id_instancia' => $this->id_instancia])
                        ->join('cat_sys_roles', 'cat_sys_roles.id = cat_usuarios.id_role')
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
                unset($return->confirm_pwd);
                
                return $return;
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
                    return ($this->modelCatUserModel)
                        ->where(['cat_usuarios.id_instancia' => $this->id_instancia])
                        ->join('cat_sys_roles', 'cat_sys_roles.id = cat_usuarios.id_role')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role')
                        ->findAll();
                }                
            ],        
            'precallback' => function ($return) {
                $return->nombre = limpiar_cadena_texto($return->nombre);
                if($return->pwd == ""){
                    unset($return->pwd);
                }else{
                    $return->pwd = password_hash($return->pwd, PASSWORD_DEFAULT);
                } 
                
                return $return;
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
                    return ($this->modelCatUserModel)
                        ->where(['cat_usuarios.id_instancia' => $this->id_instancia])
                        ->join('cat_sys_roles', 'cat_sys_roles.id = cat_usuarios.id_role')
                        ->select('cat_usuarios.*, cat_sys_roles.name AS role')
                        ->findAll();
                }
            ]         
        ]);
    }
}