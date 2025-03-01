<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\PermissionModel;

class RoleController extends BaseController
{
    public function index(){
        $roleModel = new RoleModel();
        $data['data'] = $roleModel->findAll();
        
        return renderPage([
            'view'  => 'admin/roles/index',
            'data'  => $data
        ]);
    }

    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        unset($data->data);
            
        if($data->name != ""){
            $roleModel = new RoleModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            // $data->name = limpiar_cadena_texto($data->name);
            
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA EL ROLE
            if($roleModel->where('name', $data->name)->first()){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA DEL ROLE
                $response['response_message'] = [
                    'type' => 'warning',
                    'message' => 'EL ROLE '.$data->name.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO ROLE.'
                ];
            }else{
                // VALIDAMOS SI EXISTE EL ID PARA EDITAR O AGREGAR
                if($id != ""){                
                    // ACTUALIZAMOS 
                    if($rutaModel->update($id, (array)($data))){
                        $response['next'] = true;
                        $response['response_message'] = [
                            'type' => 'success',
                            'message' => 'SE ACTUALIZO EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                        ];
                    }else{
                        $response['response_message'] = [
                            'type' => 'error',
                            'message' => 'HUBO UN PROBLEMA PARA ACTUALIZAR EL ID <strong>'.$id.'</strong>. VUELVA A INTENTARLO.'
                        ];
                    } 
                }else{
                    // REALIZAMOS LA CREACION DEL ELEMENTO
                    // PRIMERO VERIFICAMOS EL QUE EL ROLE NO EXISTA
                    if ($roleModel->where('name', $data->name)->countAllResults() > 0) {
                        $response['response_message'] = [
                            'type' => 'error',
                            'message' => 'EL ROLE YA SE ENCUENTRA AGREGADA. INTENTE CON OTRO ROLE.'
                        ];
                    }else{
                        $resultModel = $roleModel->save((array)$data);
                        $response['next'] = true;
                        $response['response_message'] = [
                            'type' => 'success',
                            'message' => 'SE AGREGO CON EXITO EL NUEVO ROLE.'
                        ];  
                    }                                  
                }    
            }
        
            $data_view['data'] = $roleModel->findAll();
            $response['view'] =  view('admin/roles/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $roleModel = new RoleModel();
            $encontrado = $roleModel->where('id', $id)->first();

            if(!empty($encontrado)){
                $response['next'] = true;
                $response['data'] = $encontrado;
            }else{
                $response['response_message'] = [
                    'type' => 'error',
                    'message' => 'NO SE ENCONTRO EL ID <strong>'.$id.'</strong> DENTRO DE NUESTRA BASE DE DATOS.'
                ];
            }
        }
        
        return json_encode($response);
    }

    public function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];        
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        
        if($id != ""){
            $roleModel = new RoleModel();
            $encontrado = $roleModel->where('id', $id)->first();

            if(!empty($encontrado)){
                $nuevoEstado = ($encontrado['status_alta'] == 1) ? 0 : 1;
                $messageEstado = ($encontrado['status_alta'] == 1) ? 'INACTIVO' : 'ACTIVO';
                if($roleModel->update($id, ['status_alta' => $nuevoEstado])){
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE '.$messageEstado.' EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                    ];
                    $data_view['data'] = $roleModel->findAll();
                    $response['view'] =  view('admin/roles/ajax/table_data', $data_view);
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

    // ------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------
    // INDEX: ASIGNACION DE ROLES
    public function index_assignRoles(){
        $roleModel = new RoleModel();
        $permissionModel = new PermissionModel();
        $rolePermissionModel = new RolePermissionModel();
        $data['roles'] = $roleModel->where('status_alta', 1)->findAll();
        $data['permissions'] = $permissionModel->where('status_alta', 1)->findAll();
        $data['data'] = $rolePermissionModel
            ->join('sys_roles', 'sys_roles.id = sys_roles_permissions.role_id')
            ->join('sys_permissions', 'sys_permissions.id = sys_roles_permissions.permission_id')
            ->select('sys_roles_permissions.id, sys_roles.name AS role, sys_permissions.name AS permission, sys_roles_permissions.status_alta')
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
        
        if($data->role_id != ""){
            $response['next'] = true;
            $rolePermissionModel = new RolePermissionModel();
            $roleModel = new RoleModel();
            // OBTENEMOS EL NOMBRE DEL ROLE
            $role_name = $roleModel->where('id', $data->role_id)->first();
            // Eliminar permisos previos del rol antes de agregar nuevos
            // $rolePermissionModel->where('role_id', $role_id)->delete();
            
            $response['response_message']['message'] = 'ROLE '.$role_name['name'].' CONTIENE LAS SIGUIENTES ACTIVIDADES: <ul>';

            foreach ($data_permissions->permission_ids as $key => $value) {
                $permissionModel = new PermissionModel();
                $encontrado_permission = $permissionModel->where('id', $value)->first();
                // ANTES DE INSERTAR, HAY QUE VERIFICAR QUE YA CUENTE CON LOS PERMISOS
                $encontrado_role = $rolePermissionModel->where([
                    'role_id' => $data->role_id, 
                    'permission_id' => $value
                ])->first();
                
                
                if(empty($encontrado_role)){
                    // INSERTAMOS SI NO ENCONTRAMOS ROLES ASIGNANOS A LA RUTA => SOLO MANDAMOS EL INDEX
                    if($rolePermissionModel->insert([
                        'role_id'  => $data->role_id,
                        'permission_id' => $value
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
                ->join('sys_roles', 'sys_roles.id = sys_roles_permissions.role_id')
                ->join('sys_permissions', 'sys_permissions.id = sys_roles_permissions.permission_id')
                ->select('sys_roles_permissions.id, sys_roles.name AS role, sys_permissions.name AS permission, sys_roles_permissions.status_alta')
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
                        ->join('sys_roles', 'sys_roles.id = sys_roles_permissions.role_id')
                        ->join('sys_permissions', 'sys_permissions.id = sys_roles_permissions.permission_id')
                        ->select('sys_roles_permissions.id, sys_roles.name AS role, sys_permissions.name AS permission, sys_roles_permissions.status_alta')
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