<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClienteModel;
use App\Models\CatOrganizacionModel;
use App\Models\SatRegimenFiscalModel;
use App\Models\SatTipoCfdiModel;
use App\Models\SatUsoCfdiModel;
use App\Models\SatFormaPagoModel;

class ClienteController extends BaseController
{
    public function index(){
        $model = new ClienteModel();
        $modelOrganizacion = new CatOrganizacionModel();
        
        $data['data'] = $model
            ->join('cat_organizaciones', 'cat_organizaciones.id = xx_clientes.id_organizacion', 'left')
            ->select('cat_organizaciones.razon_social AS organizacion, xx_clientes.*')
            ->findAll();
        $data['list_organizacion'] = $modelOrganizacion->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/clientes/index',
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
            $model = new ClienteModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->nombres = limpiar_cadena_texto($data->nombres);
            $data->apellido_paterno = limpiar_cadena_texto($data->apellido_paterno);
            $data->apellido_materno = limpiar_cadena_texto($data->apellido_materno);
            
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA
            $encontrado = $model->where('email_primario', $data->email_primario)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['email_primario'] != $data->email_primario){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'EL E-MAIL'.$data->email_primario.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO E-MAIL.'
                    ];
                }
            }
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA
            $encontrado = $model->where('telefono_primario', $data->telefono_primario)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA DE LA EMPRESA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['telefono_primario'] != $data->telefono_primario){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'EL TELEFONO '.$data->telefono_primario.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO TELEFONO.'
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
                    $data->id_usuario_creacion = $this->user_id;
                    
                    $resultModel = $model->save((array)$data);
                    $response['next'] = true;
                    $response['response_message'] = [
                        'type' => 'success',
                        'message' => 'SE AGREGO CON EXITO EL NUEVO CLIENTE.'
                    ];                                   
                } 
            }
        
            $data_view['data'] = $model
                ->join('cat_organizaciones', 'cat_organizaciones.id = xx_clientes.id_organizacion', 'left')
                ->select('cat_organizaciones.razon_social AS organizacion, xx_clientes.*')
                ->findAll();
            $response['view'] =  view('catalogos/clientes/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $model = new ClienteModel();
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
            $model = new ClienteModel();
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