<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoEmpresaPrecio;
use App\Models\CatProductoEmpresa;

class CatProductoEmpresaPrecioController extends BaseController
{
    function index(){
        // 
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoEmpresaPrecio();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['id_producto', 'anio'],
            'field_name'  => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoEmpresaPrecio())
                        ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_empresa_precios.id_empresa')
                        ->join('cat_productos', 'cat_productos.id = cat_productos_empresa_precios.id_producto')
                        ->select('cat_empresas.nombre AS empresa, cat_productos.nombre AS producto, cat_productos_empresa_precios.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                // VAMOS A BUSCAR EL ID DEL PRODUCTO EMPRESA
                $modelProductoEmpresa = new CatProductoEmpresa();
                $encontrado = $modelProductoEmpresa->where(['id_producto' => $return->id_producto, 'id_empresa' => $return->id_empresa])->first();
                if(!empty($encontrado)){
                    $return->id_producto_empresa = $encontrado['id'];
                }
          
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatProductoEmpresaPrecio(),
            'field_name' => 'precio'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoEmpresaPrecio();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['id_producto', 'anio'],
            'field_name'  => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoEmpresaPrecio())
                        ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_empresa_precios.id_empresa')
                        ->join('cat_productos', 'cat_productos.id = cat_productos_empresa_precios.id_producto')
                        ->select('cat_empresas.nombre AS empresa, cat_productos.nombre AS producto, cat_productos_empresa_precios.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                // VAMOS A BUSCAR EL ID DEL PRODUCTO EMPRESA
                $modelProductoEmpresa = new CatProductoEmpresa();
                $encontrado = $modelProductoEmpresa->where(['id_producto' => $return->id_producto, 'id_empresa' => $return->id_empresa])->first();
                if(!empty($encontrado)){
                    $return->id_producto_empresa = $encontrado['id'];
                }
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoEmpresaPrecio();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoEmpresaPrecio())
                        ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_productos_empresa_precios.id_empresa')
                        ->join('cat_productos', 'cat_productos.id = cat_productos_empresa_precios.id_producto')
                        ->select('cat_empresas.nombre AS empresa, cat_productos.nombre AS producto, cat_productos_empresa_precios.*')
                        ->findAll();
        
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProductoEmpresaPrecio();

        $encontrado['data'] = $model
            ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
            ->join('cat_empresas', 'cat_empresas.id = cat_productos_empresa_precios.id_empresa')
            ->join('cat_productos', 'cat_productos.id = cat_productos_empresa_precios.id_producto')
            ->select('cat_empresas.nombre AS empresa, cat_productos.nombre AS producto, cat_productos_empresa_precios.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/precio/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }
}