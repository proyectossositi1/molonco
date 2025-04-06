<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProducto;
use App\Models\CatProductoTipoModel;

class CatProductoController extends BaseController
{
    public function index(){
        $model = new CatProducto();
        $modelTipo = new CatProductoTipoModel();
        
        $data['data'] = $model
            ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
            ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
            ->findAll();
        $data['list_tipos'] = $modelTipo->where(['status_alta' => 1])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/productos/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProducto();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'producto',
            'view' => [
                'load' => 'catalogos/productos/ajax/table_data',
                'data'  => function(){
                    return (new CatProducto())
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
                        ->findAll();
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
            'model' => new CatProducto(),
            'field_name' => 'producto'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatProducto();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['nombre'],
            'field_name'  => 'producto',
            'view' => [
                'load' => 'catalogos/productos/ajax/table_data',
                'data'  => function(){
                    return (new CatProducto())
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
                        ->findAll();
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
        $model = new CatProducto();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'empresa',
            'view' => [
                'load' => 'catalogos/productos/ajax/table_data',
                'data'  => function(){
                    return (new CatProducto())
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_tipos.nombre AS tipo_producto, cat_productos.*')
                        ->findAll();
                }
            ]         
        ]);
    }

}