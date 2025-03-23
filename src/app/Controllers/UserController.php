<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;

class UserController extends BaseController
{
    public function index(){
        $model = new UserModel();        
        $modelRole = new RoleModel();        
        $data['data'] = $model
            ->join('sys_user_roles', 'sys_user_roles.user_id = xx_usuarios.id',' left')
            ->join('sys_roles', 'sys_roles.id = sys_user_roles.role_id', 'left')
            ->select('xx_usuarios.*, sys_roles.name AS role')
            ->findAll();
        $data['list_role'] = $modelRole->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'admin/users/index',
            'data'  => $data
        ]);
    }

    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        $next = true;
        unset($data->data);
            
        if(!empty($data)){
            $model = new UserModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->nombre = limpiar_cadena_texto($data->nombre);
            
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA
            $encontrado = $model->where('email', $data->email)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['email'] != $data->email){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'EL E-MAIL'.$data->email.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO E-MAIL.'
                    ];
                }
            }

            if($next){                
                // SETEAMOS EL DATA
                $data->usr = $data->email;
                $id_role = ($data->id_role == "") ? "" :  $data->id_role ;
                if($data->pwd == ""){
                    unset($data->pwd);
                }else{
                    $data->pwd = password_hash($data->pwd, PASSWORD_DEFAULT);
                }                   
                unset($data->confirm_pwd, $data->id_role);

                // VALIDAMOS SI EXISTE EL ID PARA EDITAR O AGREGAR
                if($id != ""){                
                    // ACTUALIZAMOS 
                    $data->id_usuario_edicion = $this->user_id;

                    if($model->update($id, (array)($data))){
                        // UNA VEZ QUE SE HAYA ACTUALIZADO, ASIGNAMEROS EL ROLE AL USUARIO PERO ANTES, HAY QUE VALIDAR QUE EXISTA
                        $userRoleModel = new UserRoleModel();
                        if(!$userRoleModel->where(['user_id' => $id])->first()){
                            $userRoleModel->insert([
                                'user_id' => $id,
                                'role_id' => $id_role
                            ]);
                        }else{
                            $userRoleModel->where('user_id', $id)
                                ->set(['role_id' => $id_role])
                                ->update();
                        }
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
                    $data->id_usuario_creacion = $this->user_id;
                    
                    $resultModel = $model->save((array)$data);
                    // UNA VEZ QUE SE HAYA INSERTADO, ASIGNAMEROS EL ROLE AL USUARIO
                    $userRoleModel = new UserRoleModel();
                    $userRoleModel->insert([
                        'user_id' => $resultModel,
                        'role_id' => $id_role
                    ]);
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE AGREGO CON EXITO EL NUEVO USUARIO.'
                    ];                                   
                } 
            }
        
            $data_view['data'] = $model
                ->join('sys_user_roles', 'sys_user_roles.user_id = xx_usuarios.id',' left')
                ->join('sys_roles', 'sys_roles.id = sys_user_roles.role_id', 'left')
                ->select('xx_usuarios.*, sys_roles.name AS role')
                ->findAll();
            $response['view'] =  view('admin/users/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $model = new UserModel();
            $encontrado = $model->where(['xx_usuarios.id' => $id])
                ->join('sys_user_roles', 'sys_user_roles.user_id = xx_usuarios.id',' left')
                ->join('sys_roles', 'sys_roles.id = sys_user_roles.role_id', 'left')
                ->select('xx_usuarios.id, xx_usuarios.nombre, xx_usuarios.usr, xx_usuarios.status_alta, xx_usuarios.email, sys_roles.id AS id_role, sys_roles.name AS role')->first();

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
            $model = new UserModel();
            $encontrado = $model->where('id', $id)->first();

            if(!empty($encontrado)){
                $nuevoEstado = ($encontrado['status_alta'] == 1) ? 0 : 1;
                $messageEstado = ($encontrado['status_alta'] == 1) ? 'INACTIVO' : 'ACTIVO';
                if($model->update($id, ['status_alta' => $nuevoEstado])){
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE '.$messageEstado.' EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                    ];
                    $data_view['data'] =  $model
                        ->join('cat_organizaciones', 'cat_organizaciones.id = xx_clientes.id_organizacion', 'left')
                        ->select('cat_organizaciones.razon_social AS organizacion, xx_clientes.*')
                        ->findAll();
                    $response['view'] =  view('catalogos/clientes/ajax/table_data', $data_view);
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