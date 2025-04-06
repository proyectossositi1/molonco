<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatTipoPagoModel;

class CatTipoPagoController extends BaseController
{
    public function index(){
        $model = new CatTipoPagoModel();
        $data['data'] = $model->findAll();
        
        return renderPage([
            'view'  => 'catalogos/tipopagos/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatTipoPagoModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'tipo de pago',
            'view' => [
                'load' => 'catalogos/tipopagos/ajax/table_data'
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombre = limpiar_cadena_texto($return->nombre);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatTipoPagoModel(),
            'field_name' => 'tipo de pago'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatTipoPagoModel();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'tipo de pago',
            'view' => [
                'load' => 'catalogos/tipopagos/ajax/table_data'
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombre = limpiar_cadena_texto($return->nombre);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatTipoPagoModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'tipo de pago',
            'view' => [
                'load' => 'catalogos/tipopagos/ajax/table_data'
            ]         
        ]);
    }
}