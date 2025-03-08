<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatOrganizacionModel;
use App\Models\SatRegimenFiscalModel;
use App\Models\SatTipoCfdiModel;
use App\Models\SatUsoCfdiModel;
use App\Models\SatFormaPagoModel;

class CatOrganizacionController extends BaseController
{
    public function index(){
        $model = new CatOrganizacionModel();
        $modelRegimen = new SatRegimenFiscalModel();
        $modelTipoCFDI = new SatTipoCfdiModel();
        $modelUsoCFDI = new SatUsoCfdiModel();
        $modelFormaPago = new SatFormaPagoModel();
        
        $data['data'] = $model
        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
        ->findAll();
        $data['list_regimen'] = $modelRegimen->where(['status_alta' => 1])->findAll();
        $data['list_tipocfdi'] = $modelTipoCFDI->where(['status_alta' => 1])->findAll();
        $data['list_usocfdi'] = $modelUsoCFDI->where(['status_alta' => 1])->findAll();
        $data['list_formapago'] = $modelFormaPago->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/organizaciones/index',
            'data'  => $data
        ]);
    }

    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;
        $next = true;
        unset($data->data);
            
        if($data->razon_social != ""){
            $model = new CatOrganizacionModel();
            // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
            $data->rfc = limpiar_cadena_texto($data->rfc);
            $data->razon_social = limpiar_cadena_texto($data->razon_social);
            
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA LA EMPRESA
            $encontrado = $model->where('razon_social', $data->razon_social)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA DE LA EMPRESA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['razon_social'] != $data->razon_social){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'LA RAZON SOCIAL '.$data->razon_social.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO NOMBRE.'
                    ];
                }
            }
            // ANTES DE AGREGAR/ACTUALIZAR, VALIDAMOS QUE NO EXISTA EL RFC
            $encontrado = $model->where('rfc', $data->rfc)->first();
            if(!empty($encontrado)){
                // SI EXISTE, MANDAMOS UN MENSAJE DE LA EXISTENCIA DE LA EMPRESA
                // ANTES VERIFICAMOS QUE SEA EL MISMO REGISTRO ENCONTRADO
                if($encontrado['id'] != $id && $encontrado['rfc'] != $data->rfc){
                    $next = false;
                    $response['response_message'] = [
                        'type' => 'warning',
                        'message' => 'EL RFC '.$data->rfc.' YA SE ENCUENTRA REGISTRADO. INTENTE CON OTRO RFC.'
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
                    if ($model->where('razon_social', $data->razon_social)->countAllResults() > 0) {
                        $response['response_message'] = [
                            'type' => 'error',
                            'message' => 'LA ORGANIZACION YA SE ENCUENTRA AGREGADA. INTENTE CON OTRO NOMBRE.'
                        ];
                    }else{
                        $data->id_usuario_creacion = $this->user_id;
                        
                        $resultModel = $model->save((array)$data);
                        $response['next'] = true;
                        $response['response_message'] = [
                            'type' => 'success',
                            'message' => 'SE AGREGO CON EXITO LA NUEVA ORGANIZACION.'
                        ];  
                    }                                  
                } 
            }
        
            $data_view['data'] = $model
                ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
                ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
                ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
                ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
                ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
                ->findAll();
            $response['view'] =  view('catalogos/organizaciones/ajax/table_data', $data_view);
        }
        
        return json_encode($response);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => 'NO SE ENCONTRO EL IDENTIFICADOR PARA REALIZAR LA OPERACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $id = (isset($data->data->id)) ? $data->data->id : "" ;

        if($id != ""){
            $model = new CatOrganizacionModel();
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
            $model = new CatOrganizacionModel();
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
                    $data_view['data'] = $model
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
                        ->findAll();
                    $response['view'] =  view('catalogos/organizaciones/ajax/table_data', $data_view);
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