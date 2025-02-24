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

    public function edit() {
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

    // ------
    // INDEX: ASIGNACION DE RUTAS
    public function index_assignRoles(){
        $rutaModel = new RouteModel();
        $roleModel = new RoleModel();
        $roleRouteModel = new RoleRouteModel();
        $listRoutes = $rutaModel->where(['method' => 'index', 'status_alta' => 1])->findAll();
        $data['rutas'] = select_group( $listRoutes );
        $data['roles'] = $roleModel->where('status_alta', 1)->findAll();
        $data['data'] = $roleRouteModel
            ->join('sys_roles', 'sys_roles.id = sys_role_routes.role_id')
            ->join('sys_routes', 'sys_routes.id = sys_role_routes.route_id')
            ->select('sys_role_routes.id, sys_roles.name AS role, sys_routes.name AS route, sys_routes.method, sys_role_routes.status_alta')
            ->findAll();
        
        return renderPage([
            'view' => 'admin/routes/assign_roles',
            'data' => $data
        ]);
    }

    public function store_roleAssignment(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        $data_routes = (isset($data->data)) ? $data->data->data : "" ;
        unset($data->data);
        
        if($data->role_id != ""){
            $response['next'] = true;
            $rolesRutasModel = new RoleRouteModel();
            $roleModel = new RoleModel();
            // OBTENEMOS EL NOMBRE DEL ROLE
            $role_name = $roleModel->where('id', $data->role_id)->first();
            // Eliminar permisos previos del rol antes de agregar nuevos
            // $rolesRutasModel->where('role_id', $role_id)->delete();
            
            $response['response_message']['message'] = 'ROLE '.$role_name['name'].' CONTIENE LAS SIGUIENTES ACTIVIDADES: <ul>';

            foreach ($data_routes->route_ids as $key => $value) {
                $rutaModel = new RouteModel();
                $encontrado_ruta = $rutaModel->where('id', $value)->first();
                // ANTES DE INSERTAR, HAY QUE VERIFICAR QUE YA CUENTE CON LOS PERMISOS
                $encontrado_role = $rolesRutasModel->where([
                    'role_id' => $data->role_id, 
                    'route_id' => $value
                ])->first();
                
                
                if(empty($encontrado_role)){
                    // INSERTAMOS SI NO ENCONTRAMOS ROLES ASIGNANOS A LA RUTA => SOLO MANDAMOS EL INDEX
                    if($rolesRutasModel->insert([
                        'role_id'  => $data->role_id,
                        'route_id' => $value
                    ])){                         
                        $response['response_message']['type'] = 'success';
                        $response['response_message']['message'] .= '<li>'.$encontrado_ruta['name'].' - ASIGNADO EXITOSAMENTE.</li>';
                        
                        // DE MANERA AUTOMATICA INSERTAREMOS TODOS LOS METODOS DEL CONTROLADOR ASIGNADO 
                        $arrayRoute = $rutaModel->where('controller', $encontrado_ruta['controller'])->whereNotIn('id', [$value])->findAll();
                        if(!empty($arrayRoute)){
                            // ASIGNAMOS TODOS LOS METODOS DEL CONTROLADOR DEL INDEX ASIGNADO
                            foreach ($arrayRoute as $key_route => $value_route) {
                                $rolesRutasModel->insert([
                                    'role_id'  => $data->role_id,
                                    'route_id' => $value_route['id']
                                ]);
                            }
                        }
                    }else{
                        // MANDAMOS ALGUN MENSAJE DE ERROR EN CASO DE NO PODER INSERTAR
                        $response['response_message']['type'] = 'error';
                        $response['response_message']['message'] .= '<li>'.$encontrado_ruta['name'].' - ERROR AL ASIGNARLO.</li>';
                    }
                }else{
                    // MANDAMOS UN WARNING DEL ROLE QUE YA ESTA ASIGNADO A LA RUTA
                    $response['response_message']['type'] = 'warning';
                    $response['response_message']['message'] .= '<li>'.$encontrado_ruta['name'].' - YA ASIGNADO.</li>';
                    // EN ESTE PUNTO, HAY QUE VERIFICAR SI QUEDAN METODOS POR ASIGNAR AL ROLE, PARA INSERTAR
                    // BUSCAMOS LAS RUTAS ASIGNADAS A UN ROLE
                    $rutas_asignadas = $rolesRutasModel->where('role_id', $data->role_id)->select('route_id')->findAll();
                    if(!empty($rutas_asignadas)){
                        $tmp_rutas_asignadas = [];
                        // GUARDAMOS LOS ID DE LAS RUTAS ASIGNADAS A UN ARRAY
                        foreach ($rutas_asignadas as $key => $value) {
                            $tmp_rutas_asignadas[] = $value['route_id'];
                        }
                        // VALIDAMOS QUE NO QUEDE UNA RUTA PENDIENTE BAJO EL CONTROLADOR PRINCIPAL
                        $arrayRoute = $rutaModel->where('controller', $encontrado_ruta['controller'])->whereNotIn('id', $tmp_rutas_asignadas)->findAll();
                        if(!empty($arrayRoute)){
                            // ASIGNAMOS TODOS LOS METODOS DEL CONTROLADOR DEL INDEX ASIGNADO
                            foreach ($arrayRoute as $key_route => $value_route) {
                                $rolesRutasModel->insert([
                                    'role_id'  => $data->role_id,
                                    'route_id' => $value_route['id']
                                ]);
                            }
                        }
                    }                                        
                }
    
            }

            $response['response_message']['message'] .= '</ul>';
            $data_view['data'] = $rolesRutasModel
                ->join('sys_roles', 'sys_roles.id = sys_role_routes.role_id')
                ->join('sys_routes', 'sys_routes.id = sys_role_routes.route_id')
                ->select('sys_role_routes.id, sys_roles.name AS role, sys_routes.name AS route, sys_routes.method, sys_role_routes.status_alta')
                ->findAll();
            $response['view'] =  view('admin/routes/ajax/table_roles_routes', $data_view);
        }

        return json_encode($response);
    }

    public function destroy_roleAssignment() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];        
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        
        if($id != ""){
            $rolesRutasModel = new RoleRouteModel();
            $encontrado = $rolesRutasModel->where('id', $id)->first();

            if(!empty($encontrado)){
                $nuevoEstado = ($encontrado['status_alta'] == 1) ? 0 : 1;
                $messageEstado = ($encontrado['status_alta'] == 1) ? 'INACTIVO' : 'ACTIVO';
                if($rolesRutasModel->update($id, ['status_alta' => $nuevoEstado])){
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE '.$messageEstado.' EL REGISTO CON ID <strong>'.$id.'</strong> EXITOSAMENTE.'
                    ];
                    $data_view['data'] = $rolesRutasModel
                        ->join('sys_roles', 'sys_roles.id = sys_role_routes.role_id')
                        ->join('sys_routes', 'sys_routes.id = sys_role_routes.route_id')
                        ->select('sys_role_routes.id, sys_roles.name AS role, sys_routes.name AS route, sys_routes.method, sys_role_routes.status_alta')
                        ->findAll();
                    $response['view'] =  view('admin/routes/ajax/table_roles_routes', $data_view);
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