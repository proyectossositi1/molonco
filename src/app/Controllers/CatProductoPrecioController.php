<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoPrecio;
use App\Models\CatProducto;

class CatProductoPrecioController extends BaseController
{
    function index(){
        // 
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoPrecio();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['id_producto', 'anio'],
            'field_name'  => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoPrecio())
                        ->where('cat_productos_precios.id_instancia', $this->id_instancia)
                        ->join('cat_productos', 'cat_productos.id = cat_productos_precios.id_producto')
                        ->select('cat_productos.nombre AS producto, cat_productos_precios.*')
                        ->findAll();
                }
            ]
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatProductoPrecio(),
            'field_name' => 'precio'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoPrecio();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['id_producto', 'anio'],
            'field_name'  => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoPrecio())
                        ->where('cat_productos_precios.id_instancia', $this->id_instancia)
                        ->join('cat_productos', 'cat_productos.id = cat_productos_precios.id_producto')
                        ->select('cat_productos.nombre AS producto, cat_productos_precios.*')
                        ->findAll();
                }
            ]
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProductoPrecio();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'precio',
            'view' => [
                'load' => 'catalogos/productos/precio/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoPrecio())
                        ->where('cat_productos_precios.id_instancia', $this->id_instancia)
                        ->join('cat_productos', 'cat_productos.id = cat_productos_precios.id_producto')
                        ->select('cat_productos.nombre AS producto, cat_productos_precios.*')
                        ->findAll();        
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProductoPrecio();

        $encontrado['data'] = $model
            ->where('cat_productos_precios.id_instancia', $this->id_instancia)
            ->join('cat_productos', 'cat_productos.id = cat_productos_precios.id_producto')
            ->select('cat_productos.nombre AS producto, cat_productos_precios.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/precio/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }
}