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

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatOrganizacionModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['razon_social', 'rfc'],
            'field_name'  => 'organizacion',
            'view' => [
                'load' => 'catalogos/organizaciones/ajax/table_data',
                'data'  => function(){
                    return (new CatOrganizacionModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->rfc = limpiar_cadena_texto($return->rfc);
                $return->razon_social = limpiar_cadena_texto($return->razon_social);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatOrganizacionModel(),
            'field_name' => 'organizacion'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatOrganizacionModel();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['razon_social', 'rfc'],
            'field_name'  => 'organizacion',
            'view' => [
                'load' => 'catalogos/organizaciones/ajax/table_data',
                'data'  => function(){
                    return (new CatOrganizacionModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->rfc = limpiar_cadena_texto($return->rfc);
                $return->razon_social = limpiar_cadena_texto($return->razon_social);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatOrganizacionModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'empresa',
            'view' => [
                'load' => 'catalogos/organizaciones/ajax/table_data',
                'data'  => function(){
                    return (new CatOrganizacionModel())
                        ->join('sat_regimen_fiscal', 'sat_regimen_fiscal.id = cat_organizaciones.id_sat_regimen_fiscal', 'left')
                        ->join('sat_uso_cfdi', 'sat_uso_cfdi.id = cat_organizaciones.id_sat_uso_cfdi', 'left')
                        ->join('sat_tipo_cfdi', 'sat_tipo_cfdi.id = cat_organizaciones.id_sat_tipo_cfdi', 'left')
                        ->join('sat_forma_pago', 'sat_forma_pago.id = cat_organizaciones.id_sat_forma_pago', 'left')
                        ->select('sat_regimen_fiscal.descripcion AS regimen_fiscal, sat_uso_cfdi.descripcion AS uso_cfdi, sat_tipo_cfdi.descripcion AS tipo_cfdi, sat_forma_pago.descripcion AS forma_pago, cat_organizaciones.*')
                        ->findAll();
                }
            ]         
        ]);
    }
}