<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoSubCategoria;

class CatProductoSubcategoriaController extends BaseController
{
    function index(){
    
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoSubCategoria();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'sub categoria',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoSubCategoria())
                        ->where('cat_productos_subcategorias.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_subcategorias.id_empresa', 'left')
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
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
            'model' => new CatProductoSubCategoria(),
            'field_name' => 'sub categoria'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoSubCategoria();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'sub categoria',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoSubCategoria())
                        ->where('cat_productos_subcategorias.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_subcategorias.id_empresa', 'left')
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
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
        $model = new CatProductoSubCategoria();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'categorias',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoSubCategoria())
                        ->where('cat_productos_subcategorias.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_subcategorias.id_empresa', 'left')
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
                        ->findAll();
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProductoSubCategoria();

        $encontrado['data'] = $model
            ->where('cat_productos_subcategorias.id_empresa', $this->id_empresa)
            ->join('cat_empresas', 'cat_empresas.id = cat_productos_subcategorias.id_empresa', 'left')
            ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
            ->select('cat_empresas.nombre AS empresa, cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/subcategorias/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }
}