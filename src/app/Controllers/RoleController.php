<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoleModel;

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
}