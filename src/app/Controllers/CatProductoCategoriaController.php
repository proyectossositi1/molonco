<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoCategoria;

class CatProductoCategoriaController extends BaseController
{
    function index(){
        
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoCategoria();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'categoria',
            'view' => [
                'load' => 'catalogos/productos/categorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoCategoria())
                        ->where('id_instancia', $this->id_instancia)->findAll();
                }
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
            'model' => new CatProductoCategoria(),
            'field_name' => 'categoria'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoCategoria();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'categoria',
            'view' => [
                'load' => 'catalogos/productos/categorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoCategoria())
                        ->where('id_instancia', $this->id_instancia)->findAll();
                }
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
        $model = new CatProductoCategoria();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'categorias',
            'view' => [
                'load' => 'catalogos/productos/categorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoCategoria())
                        ->where('id_instancia', $this->id_instancia)->findAll();
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProductoCategoria();

        $encontrado['data'] = $model->where('id_instancia', $this->id_instancia)->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/categorias/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }
}