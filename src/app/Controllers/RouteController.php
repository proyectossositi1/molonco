<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatRouteModel;
use App\Models\RoleRouteModel;
use App\Models\RoleModel;
use App\Models\CatMenuModel;

class RouteController extends BaseController
{
    function index(){
        $rutaModel = new CatRouteModel();
        $menuModel = new CatMenuModel();
        $data['menus'] = $menuModel->where(['status_alta' => 1])->findAll();
        $data['rutas'] = $rutaModel
            ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu', 'left')
            ->select('cat_sys_routes.*, cat_sys_menus.name AS menu')
            ->findAll();
        
        return renderPage([
            'view'  => 'admin/routes/index',
            'data'  => $data
        ]);
    }

    function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;        
        $methods = (isset($data->data->data->methods)) ? $data->data->data->methods : [] ;
        $text_method = (isset($data->new_method)) ? $data->new_method : '';
        if($data->new_method != "") array_push($methods, $data->new_method);
        unset($data->data, $data->new_method, $data->method);
            
        if($data->name != ""){
            $rutaModel = new CatRouteModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->name = limpiar_cadena_texto($data->name);
            if($data->icon == "") unset($data->icon);
            
            // VALIDAMOS SI EXISTE EL ID PARA EDITAR O AGREGAR
            if($id != ""){
                // VERIFICAMOS SI EL CAMPO URL YA EXISTE, EN CASO DE QUE SI, ELIMINAMOS DEL ARREGLO
                if ($rutaModel->where('route', $data->route)->countAllResults() > 0) unset($data->route);
                // ACTUALIZAMOS DATOS DE UNO A UNO
                $data->method = $text_method;
                
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
                if(!empty($methods)){
                    $data_route = [];
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => '<p>ESTAS RUTAS YA SE ENCUENTRAN REGISTRADAS.</p>'
                    ];
                    
                    foreach ($methods as $key => $value) {
                        if($value == 'index'){
                            $route = $data->route;
                            $name = $data->name;
                            $id_menu = $data->id_menu;
                        }else{
                            $route = $data->route.'/'.$value;
                            $name = $data->name.' - '.strtoupper($value);
                            $id_menu = null;
                        }

                        if ($rutaModel->where('route', $route)->countAllResults() > 0) {
                            $response['response_message']['message'] .= $route.'<br>';
                        }else{
                            // INSERTAREMOS LAS RUTAS QUE NO EXISTAN
                            $data_route = [
                                'id_menu' => $id_menu,
                                'name'  => $name,
                                'route' => $route,
                                'controller'    => $data->controller,
                                'method' => $value
                            ];

                            $resultModel = $rutaModel->save($data_route);
                            $response['response_message']['message'] .= 'LA RUTA '.$route.' SE REGISTRO CON EXITO.<br>';
                        }
                    }
                }                           
            }                
            

            $data_view['rutas'] =  $rutaModel
                ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu', 'left')
                ->select('cat_sys_routes.*, cat_sys_menus.name AS menu')
                ->findAll();
            $response['view'] =  view('admin/routes/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatRouteModel()
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatRouteModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'view' => [
                'load' => 'admin/routes/ajax/table_data',
                'data' => function(){
                    return (new CatRouteModel())
                    ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu', 'left')
                    ->select('cat_sys_routes.*, cat_sys_menus.name AS menu')
                    ->findAll();
                }
            ]         
        ]);
    }

    public function destroy_bk() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];        
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        
        if($id != ""){
            $rutaModel = new CatRouteModel();
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
                    $data_view['rutas'] =  $rutaModel
                        ->join('cat_sys_menus', 'cat_sys_menus.id = cat_sys_routes.id_menu', 'left')
                        ->select('cat_sys_routes.*, cat_sys_menus.name AS menu')
                        ->findAll();
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

    // ------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------
    // INDEX: ASIGNACION DE RUTAS
    public function index_assignRoles(){
        $rutaModel = new CatRouteModel();
        $roleModel = new RoleModel();
        $roleRouteModel = new RoleCatRouteModel();
        $listRoutes = $rutaModel->where(['method' => 'index', 'status_alta' => 1])->findAll();
        $data['rutas'] = select_group( $listRoutes );
        $data['roles'] = $roleModel->where('status_alta', 1)->findAll();
        $data['data'] = $roleRouteModel
            ->join('sys_roles', 'sys_roles.id = sys_role_routes.id_role')
            ->join('cat_sys_routes', 'cat_sys_routes.id = sys_role_routes.id_route')
            ->select('sys_role_routes.id, sys_roles.name AS role, cat_sys_routes.name AS route, cat_sys_routes.method, sys_role_routes.status_alta')
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
        
        if($data->id_role != ""){
            $response['next'] = true;
            $rolesRutasModel = new RoleCatRouteModel();
            $roleModel = new RoleModel();
            // OBTENEMOS EL NOMBRE DEL ROLE
            $role_name = $roleModel->where('id', $data->id_role)->first();
            // Eliminar permisos previos del rol antes de agregar nuevos
            // $rolesRutasModel->where('id_role', $id_role)->delete();
            
            $response['response_message']['message'] = 'ROLE '.$role_name['name'].' CONTIENE LAS SIGUIENTES ACTIVIDADES: <ul>';

            foreach ($data_routes->route_ids as $key => $value) {
                $rutaModel = new CatRouteModel();
                $encontrado_ruta = $rutaModel->where('id', $value)->first();
                // ANTES DE INSERTAR, HAY QUE VERIFICAR QUE YA CUENTE CON LOS PERMISOS
                $encontrado_role = $rolesRutasModel->where([
                    'id_role' => $data->id_role, 
                    'id_route' => $value
                ])->first();
                
                
                if(empty($encontrado_role)){
                    // INSERTAMOS SI NO ENCONTRAMOS ROLES ASIGNANOS A LA RUTA => SOLO MANDAMOS EL INDEX
                    if($rolesRutasModel->insert([
                        'id_role'  => $data->id_role,
                        'id_route' => $value
                    ])){                         
                        $response['response_message']['type'] = 'success';
                        $response['response_message']['message'] .= '<li>'.$encontrado_ruta['name'].' - ASIGNADO EXITOSAMENTE.</li>';
                        
                        // DE MANERA AUTOMATICA INSERTAREMOS TODOS LOS METODOS DEL CONTROLADOR ASIGNADO 
                        $arrayRoute = $rutaModel->where('controller', $encontrado_ruta['controller'])->whereNotIn('id', [$value])->findAll();
                        if(!empty($arrayRoute)){
                            // ASIGNAMOS TODOS LOS METODOS DEL CONTROLADOR DEL INDEX ASIGNADO
                            foreach ($arrayRoute as $key_route => $value_route) {
                                $rolesRutasModel->insert([
                                    'id_role'  => $data->id_role,
                                    'id_route' => $value_route['id']
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
                    $rutas_asignadas = $rolesRutasModel->where('id_role', $data->id_role)->select('id_route')->findAll();
                    if(!empty($rutas_asignadas)){
                        $tmp_rutas_asignadas = [];
                        // GUARDAMOS LOS ID DE LAS RUTAS ASIGNADAS A UN ARRAY
                        foreach ($rutas_asignadas as $key => $value) {
                            $tmp_rutas_asignadas[] = $value['id_route'];
                        }
                        // VALIDAMOS QUE NO QUEDE UNA RUTA PENDIENTE BAJO EL CONTROLADOR PRINCIPAL
                        $arrayRoute = $rutaModel->where('controller', $encontrado_ruta['controller'])->whereNotIn('id', $tmp_rutas_asignadas)->findAll();
                        if(!empty($arrayRoute)){
                            // ASIGNAMOS TODOS LOS METODOS DEL CONTROLADOR DEL INDEX ASIGNADO
                            foreach ($arrayRoute as $key_route => $value_route) {
                                $rolesRutasModel->insert([
                                    'id_role'  => $data->id_role,
                                    'id_route' => $value_route['id']
                                ]);
                            }
                        }
                    }                                        
                }
    
            }

            $response['response_message']['message'] .= '</ul>';
            $data_view['data'] = $rolesRutasModel
                ->join('sys_roles', 'sys_roles.id = sys_role_routes.id_role')
                ->join('cat_sys_routes', 'cat_sys_routes.id = sys_role_routes.id_route')
                ->select('sys_role_routes.id, sys_roles.name AS role, cat_sys_routes.name AS route, cat_sys_routes.method, sys_role_routes.status_alta')
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
            $rolesRutasModel = new RoleCatRouteModel();
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
                        ->join('sys_roles', 'sys_roles.id = sys_role_routes.id_role')
                        ->join('cat_sys_routes', 'cat_sys_routes.id = sys_role_routes.id_route')
                        ->select('sys_role_routes.id, sys_roles.name AS role, cat_sys_routes.name AS route, cat_sys_routes.method, sys_role_routes.status_alta')
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