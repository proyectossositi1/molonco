<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProducto;
use App\Models\CatProductoTipoModel;

class CatProductoController extends BaseController
{
    public function index(){
        $model = new CatProducto();
        $modelTipo = new CatProductoTipoModel();
        
        $data['data'] = $model
            ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto')
            ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
            ->findAll();
        $data['list_tipos'] = $modelTipo->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/productos/index',
            'data'  => $data
        ]);
    }

    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        $next = true;
        unset($data->data);
            
        if($data->nombre != ""){
            $model = new CatProducto();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->nombre = limpiar_cadena_texto($data->nombre);
            
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA
            $encontrado = $model->where('nombre', $data->nombre)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA DE LA EMPRESA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['nombre'] != $data->nombre){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'EL NOMBRE '.$data->nombre.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO NOMBRE.'
                    ];
                }
            }

            if($next){
                // VALIDAMOS SI EXISTE EL ID PARA EDITAR O AGREGAR
                if($id != ""){                
                    // ACTUALIZAMOS 
                    $data->id_usuario_edicion = $this->user_id;

                    if($model->update($id, (array)($data))){
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
                    // PRIMERO VERIFICAMOS EL QUE LA EMPRESA NO EXISTA
                    if ($model->where('nombre', $data->nombre)->countAllResults() > 0) {
                        $response['response_message'] = [
                            'type' => 'error',
                            'message' => 'EL NOMBRE YA SE ENCUENTRA AGREGADA. INTENTE CON OTRO NOMBRE.'
                        ];
                    }else{
                        $data->id_usuario_creacion = $this->user_id;
                        
                        $resultModel = $model->save((array)$data);
                        $response['next'] = true;
                        $response['response_message'] = [
                            'type' => 'success',
                            'message' => 'SE AGREGO CON EXITO EL NUEVO PRODUCTO.'
                        ];  
                    }                                  
                } 
            }
        
            $data_view['data'] =  $model
                ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto')
                ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
                ->findAll();
            $response['view'] =  view('catalogos/productos/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $model = new CatProducto();
            $encontrado = $model->where('id', $id)->first();

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
            $model = new CatProducto();
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
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto')
                        ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
                        ->findAll();
                    $response['view'] =  view('catalogos/productos/ajax/table_data', $data_view);
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