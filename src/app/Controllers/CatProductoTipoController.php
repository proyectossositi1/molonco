<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoTipo;

class CatProductoTipoController extends BaseController
{
    function index(){
        //
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoTipo();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'categoria',
            'view' => [
                'load' => 'catalogos/productos/tipos/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoTipo())
                        ->where('cat_productos_tipos.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_tipos.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_tipos.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->nombre = limpiar_cadena_texto($return->nombre);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatProductoTipo(),
            'field_name' => 'categoria'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoTipo();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'categoria',
            'view' => [
                'load' => 'catalogos/productos/tipos/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoTipo())
                        ->where('cat_productos_tipos.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_tipos.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_tipos.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->nombre = limpiar_cadena_texto($return->nombre);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoTipo();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'categorias',
            'view' => [
                'load' => 'catalogos/productos/tipos/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoTipo())
                        ->where('cat_productos_tipos.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_tipos.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_tipos.*')
                        ->findAll();
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProductoTipo();

        $encontrado['data'] = $model
            ->where('cat_productos_tipos.id_empresa', $this->id_empresa)
            ->join('cat_empresas', 'cat_empresas.id = cat_productos_tipos.id_empresa', 'left')
            ->select('cat_empresas.nombre AS empresa, cat_productos_tipos.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/tipos/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }
}