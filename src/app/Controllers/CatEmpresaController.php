<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatEmpresaModel;
use App\Models\SatRegimenFiscalModel;
use App\Models\SatTipoCfdiModel;
use App\Models\SatUsoCfdiModel;
use App\Models\SatFormaPagoModel;

class CatEmpresaController extends BaseController
{
    public function index(){
        $model = new CatEmpresaModel();
        $modelRegimen = new SatRegimenFiscalModel();
        $modelTipoCFDI = new SatTipoCfdiModel();
        $modelUsoCFDI = new SatUsoCfdiModel();
        $modelFormaPago = new SatFormaPagoModel();
        
        $data['data'] = $model
        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_empresas.id_sat_regimen_fiscal', 'left')
        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_empresas.id_sat_uso_cfdi', 'left')
        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_empresas.id_sat_tipo_cfdi', 'left')
        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_empresas.id_sat_forma_pago', 'left')
        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_empresas.*')
        ->findAll();
        $data['list_regimen'] = $modelRegimen->where(['status_alta' => 1])->findAll();
        $data['list_tipocfdi'] = $modelTipoCFDI->where(['status_alta' => 1])->findAll();
        $data['list_usocfdi'] = $modelUsoCFDI->where(['status_alta' => 1])->findAll();
        $data['list_formapago'] = $modelFormaPago->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/empresas/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatEmpresaModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['razon_social', 'nombre', 'rfc'],
            'field_name'  => 'empresa',
            'view' => [
                'load' => 'catalogos/empresas/ajax/table_data',
                'data'  => function(){
                    return (new CatEmpresaModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_empresas.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_empresas.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_empresas.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_empresas.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_empresas.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombre = limpiar_cadena_texto($return->nombre);
                $return->rfc = limpiar_cadena_texto($return->rfc);
                $return->razon_social = limpiar_cadena_texto($return->razon_social);
                $return->abreviacion = limpiar_cadena_texto($return->abreviacion);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatEmpresaModel(),
            'field_name' => 'empresa'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatEmpresaModel();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['razon_social', 'nombre', 'rfc'],
            'field_name'  => 'empresa',
            'view' => [
                'load' => 'catalogos/empresas/ajax/table_data',
                'data'  => function(){
                    return (new CatEmpresaModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_empresas.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_empresas.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_empresas.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_empresas.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_empresas.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombre = limpiar_cadena_texto($return->nombre);
                $return->rfc = limpiar_cadena_texto($return->rfc);
                $return->razon_social = limpiar_cadena_texto($return->razon_social);
                $return->abreviacion = limpiar_cadena_texto($return->abreviacion);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatEmpresaModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'empresa',
            'view' => [
                'load' => 'catalogos/empresas/ajax/table_data',
                'data'  => function(){
                    return (new CatEmpresaModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_empresas.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_empresas.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_empresas.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_empresas.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_empresas.*')
                        ->findAll();
                }
            ]         
        ]);
    }

}