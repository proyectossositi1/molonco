<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatServicioModel;

class CatServicioController extends BaseController
{
    public function index(){
        $model = new CatServicioModel();
        $data['data'] = $model->where(['id_instancia' => $this->id_instancia])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/servicios/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatServicioModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'servicio',
            'view' => [
                'load' => 'catalogos/servicios/ajax/table_data'
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
            'model' => new CatServicioModel(),
            'field_name' => 'servicio'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatServicioModel();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'servicio',
            'view' => [
                'load' => 'catalogos/servicios/ajax/table_data'
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
        $model = new CatServicioModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'servicio',
            'view' => [
                'load' => 'catalogos/servicios/ajax/table_data'
            ]         
        ]);
    }
}