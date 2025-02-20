<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RouteModel;
use App\Models\RoleRouteModel;
use App\Models\RoleModel;

class RouteController extends BaseController
{
    public function index(){
        $rutaModel = new RouteModel();
        $data['rutas'] = $rutaModel->findAll();
        
        return renderPage([
            'view'  => 'admin/routes/index',
            'data'  => $data
        ]);
    }
    
    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        unset($data->data);
            
        if($data->name != ""){
            $rutaModel = new RouteModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->name = limpiar_cadena_texto($data->name);
            
            // VALIDAMOS SI EXISTE EL ID PARA EDITAR O AGREGAR
            if($id != ""){
                // VERIFICAMOS SI EL CAMPO URL YA EXISTE, EN CASO DE QUE SI, ELIMINAMOS DEL ARREGLO
                if ($rutaModel->where('route', $data->route)->countAllResults() > 0) unset($data->route);
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
                // PRIMERO VERIFICAMOS EL QUE LA RUTA NO EXISTA
                if ($rutaModel->where('route', $data->route)->countAllResults() > 0) {
                    $response['response_message'] = [
                        'type' => 'error',
                        'message' => 'LA RUTA YA SE ENCUENTRA AGREGADA. INTENTE CON OTRA RUTA.'
                    ];
                }else{
                    $resultModel = $rutaModel->save((array)$data);
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE AGREGO CON EXITO LA NUEVA RUTA.'
                    ];  
                }                                  
            }                
            

            $data_view['rutas'] = $rutaModel->findAll();
            $response['view'] =  view('admin/routes/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $rutaModel = new RouteModel();
            $encontrado = $rutaModel->where('id', $id)->first();

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
            $rutaModel = new RouteModel();
            $encontrado = $rutaModel->where('id', $id)->first();

            if(!empty($encontrado)){
                $nuevoEstado = ($encontrado['status_alta'] == 1) ? 0 : 1;
                $messageEstado = ($encontrado['status_alta'] == 1) ? 'INACTIVO' : 'ACTIVO';
                if($rutaModel->update($id, ['status_alta' => $nuevoEstado])){
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE '.$messageEstado.' EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                    ];
                    $data_view['rutas'] = $rutaModel->findAll();
                    $response['view'] =  view('admin/routes/ajax/table_data', $data_view);
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

    public function assignRoles(){
        $rutaModel = new RouteModel();
        $roleModel = new RoleModel();
        $data['rutas'] = $rutaModel->findAll();
        $data['roles'] = $roleModel->findAll();
        return view('admin/rutas/assign_roles', $data);
    }

    public function storeRoleAssignment(){
        $rolesRutasModel = new RoleRouteModel();
        $role_id = $this->request->getPost('role_id');
        $route_ids = $this->request->getPost('route_id');

        // Eliminar permisos previos del rol antes de agregar nuevos
        $rolesRutasModel->where('role_id', $role_id)->delete();

        foreach ($route_ids as $route_id) {
            $rolesRutasModel->insert([
                'role_id'  => $role_id,
                'route_id' => $route_id
            ]);
        }

        return redirect()->to('/rutas/asignar')->with('success', 'Permisos asignados correctamente.');
    }
}