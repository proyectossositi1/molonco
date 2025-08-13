<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatRoleModel;
use App\Models\CatPermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    function index(){
        $roleModel = new CatRoleModel();
        $data['data'] = $roleModel
            ->where(['cat_sys_roles.id_instancia' => $this->id_instancia])
            ->join('sys_instancias', 'sys_instancias.id = cat_sys_roles.id_instancia', 'left')
            ->select('sys_instancias.nombre AS instancia, cat_sys_roles.*')
            ->findAll();
        
        return renderPage([
            'view'  => 'admin/roles/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatRoleModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['name'],
            'field_name'  => 'rol',
            'view' => [
                'load' => 'admin/roles/ajax/table_data',
                'data'  => function(){
                    return (new CatRoleModel())
                        ->where(['cat_sys_roles.id_instancia' => $this->id_instancia])
                        ->join('sys_instancias', 'sys_instancias.id = cat_sys_roles.id_instancia', 'left')
                        ->select('sys_instancias.nombre AS instancia, cat_sys_roles.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {                
                $return->name = limpiar_cadena_texto($return->name);                            
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatRoleModel(),
            'field_name' => 'rol'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatRoleModel();
        
        return process_update([
            'data' => $data,
            'model' => $model,
            'field_check' => ['name'],
            'field_name' => 'rol',
            'view' => [
                'load' => 'admin/roles/ajax/table_data',
                'data'  => function(){
                    return (new CatRoleModel())
                        ->where(['cat_sys_roles.id_instancia' => $this->id_instancia])
                        ->join('sys_instancias', 'sys_instancias.id = cat_sys_roles.id_instancia', 'left')
                        ->select('sys_instancias.nombre AS instancia, cat_sys_roles.*')
                        ->findAll();
                }
            ],        
            'precallback' => function ($return) {
                $return->name = limpiar_cadena_texto($return->name);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatRoleModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'rol',
            'view' => [
                'load' => 'admin/roles/ajax/table_data',
                'data'  => function(){
                    return (new CatRoleModel())
                        ->where(['cat_sys_roles.id_instancia' => $this->id_instancia])
                        ->join('sys_instancias', 'sys_instancias.id = cat_sys_roles.id_instancia', 'left')
                        ->select('sys_instancias.nombre AS instancia, cat_sys_roles.*')
                        ->findAll();
                }
            ]         
        ]);
    }

    // ------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------
    // INDEX: ASIGNACION DE ROLES
    public function index_assignRoles(){
        $roleModel = new CatRoleModel();
        $permissionModel = new CatPermissionModel();
        $rolePermissionModel = new RolePermissionModel();
        $data['list_roles'] = $roleModel->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_permissions'] = $permissionModel->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['data'] = $rolePermissionModel
            ->where(['cat_sys_permissions.id_instancia' => $this->id_instancia])
            ->join('cat_sys_roles', 'cat_sys_roles.id = sys_roles_permissions.id_role')
            ->join('cat_sys_permissions', 'cat_sys_permissions.id = sys_roles_permissions.id_permission')
            ->select('sys_roles_permissions.id, cat_sys_roles.name AS role, cat_sys_permissions.name AS permission, sys_roles_permissions.status_alta')
            ->findAll();
        
        return renderPage([
            'view' => 'admin/roles/assign_roles',
            'data' => $data
        ]);
    }

    public function store_roleAssignment(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        $data_permissions = (isset($data->data)) ? $data->data->data : "" ;
        unset($data->data);
        
        if($data->id_role != ""){
            $response['next'] = true;
            $rolePermissionModel = new RolePermissionModel();
            $roleModel = new CatRoleModel();
            // OBTENEMOS EL NOMBRE DEL ROLE
            $role_name = $roleModel->where('id', $data->id_role)->first();
            // Eliminar permisos previos del rol antes de agregar nuevos
            // $rolePermissionModel->where('id_role', $id_role)->delete();
            
            $response['response_message']['message'] = 'ROLE '.$role_name['name'].' CONTIENE LAS SIGUIENTES ACTIVIDADES: <ul>';

            foreach ($data_permissions->permission_ids as $key => $value) {
                $permissionModel = new CatPermissionModel();
                $encontrado_permission = $permissionModel->where('id', $value)->first();
                // ANTES DE INSERTAR, HAY QUE VERIFICAR QUE YA CUENTE CON LOS PERMISOS
                $encontrado_role = $rolePermissionModel->where([
                    'id_role' => $data->id_role, 
                    'id_permission' => $value
                ])->first();
                
                
                if(empty($encontrado_role)){
                    // INSERTAMOS SI NO ENCONTRAMOS ROLES ASIGNANOS A LA RUTA => SOLO MANDAMOS EL INDEX
                    if($rolePermissionModel->insert([
                        'id_role'  => $data->id_role,
                        'id_permission' => $value
                    ])){                         
                        $response['response_message']['type'] = 'success';
                        $response['response_message']['message'] .= '<li>'.$encontrado_permission['name'].' - ASIGNADO EXITOSAMENTE.</li>';
                    }else{
                        // MANDAMOS ALGUN MENSAJE DE ERROR EN CASO DE NO PODER INSERTAR
                        $response['response_message']['type'] = 'error';
                        $response['response_message']['message'] .= '<li>'.$encontrado_permission['name'].' - ERROR AL ASIGNARLO.</li>';
                    }
                }else{
                    // MANDAMOS UN WARNING DEL ROLE QUE YA ESTA ASIGNADO A LA RUTA
                    $response['response_message']['type'] = 'warning';
                    $response['response_message']['message'] .= '<li>'.$encontrado_permission['name'].' - YA ASIGNADO.</li>';                                                           
                }
    
            }

            $response['response_message']['message'] .= '</ul>';
            $data_view['data'] = $rolePermissionModel
                ->where(['cat_sys_permissions.id_instancia' => $this->id_instancia])
                ->join('cat_sys_roles', 'cat_sys_roles.id = sys_roles_permissions.id_role')
                ->join('cat_sys_permissions', 'cat_sys_permissions.id = sys_roles_permissions.id_permission')
                ->select('sys_roles_permissions.id, cat_sys_roles.name AS role, cat_sys_permissions.name AS permission, sys_roles_permissions.status_alta')
                ->findAll();
            $response['view'] =  view('admin/roles/ajax/table_roles_permissions', $data_view);
        }

        return json_encode($response);
    }

    public function destroy_roleAssignment() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];        
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        
        if($id != ""){
            $rolePermissionModel = new RolePermissionModel();
            $encontrado = $rolePermissionModel->where('id', $id)->first();

            if(!empty($encontrado)){
                $nuevoEstado = ($encontrado['status_alta'] == 1) ? 0 : 1;
                $messageEstado = ($encontrado['status_alta'] == 1) ? 'INACTIVO' : 'ACTIVO';
                if($rolePermissionModel->update($id, ['status_alta' => $nuevoEstado])){
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE '.$messageEstado.' EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                    ];
                    $data_view['data'] = $rolePermissionModel
                        ->where(['cat_sys_permissions.id_instancia' => $this->id_instancia])
                        ->join('cat_sys_roles', 'cat_sys_roles.id = sys_roles_permissions.id_role')
                        ->join('cat_sys_permissions', 'cat_sys_permissions.id = sys_roles_permissions.id_permission')
                        ->select('sys_roles_permissions.id, cat_sys_roles.name AS role, cat_sys_permissions.name AS permission, sys_roles_permissions.status_alta')
                        ->findAll();
                    $response['view'] =  view('admin/roles/ajax/table_roles_permissions', $data_view);
                }else{
                    $response['response_message'] = [
                        'type' => 'error',
                        'message' => 'HUBO UN PROBLEMA PARA ACTUALIZAR EL ID <strong>'.$id.'</strong>. VUELVA A INTENTARLO.'
                    ];
                }   
            }

        }
        
        return json_encode($response);
    }

}