<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProducto;
use App\Models\CatProductoTipoModel;
use App\Models\CatProductoCategoria;
use App\Models\CatProductoSubCategoria;
use App\Models\CatProductoMarca;

class CatProductoController extends BaseController
{
    public function index(){
        $model = new CatProductoCategoria();
        $modelSubCategoria = new CatProductoSubCategoria();
        $modelTipo = new CatProductoTipoModel();
        $modelMarca = new CatProductoMarca();
        $modelProducto = new CatProducto();
        $data['list_tipos'] = $modelTipo->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_marcas'] = $modelMarca->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_categorias'] = $model->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_subcategorias'] = $modelSubCategoria->where(['status_alta' => 1])->findAll();        
        $data['list_productos'] = $modelProducto->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->select('cat_productos.id, cat_productos.nombre')->findAll();
        
        $data['data'] = $model->where('id_instancia', $this->id_instancia)->findAll();
        
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
                        ->where('cat_productos.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos.id_categoria', 'left')
                        ->join('cat_productos_subcategorias', 'cat_productos_subcategorias.id = cat_productos.id_subcategoria', 'left')
                        ->join('cat_productos_marcas', 'cat_productos_marcas.id = cat_productos.id_marca', 'left')
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria, cat_productos_subcategorias.nombre AS subcategoria, cat_productos_marcas.nombre AS marca, cat_productos_tipos.nombre AS tipo, cat_productos.*')
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
            'field_name' => 'producto',
            'query' => function($model, $id) {
                return $model->where(['cat_productos.id' => $id])
                    ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos.id_categoria', 'left')
                    ->join('cat_productos_subcategorias', 'cat_productos_subcategorias.id = cat_productos.id_subcategoria', 'left')
                    ->join('cat_productos_marcas', 'cat_productos_marcas.id = cat_productos.id_marca', 'left')
                    ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                    ->select('cat_productos_categorias.nombre AS categoria, cat_productos_subcategorias.nombre AS subcategoria, cat_productos_marcas.nombre AS marca, cat_productos_tipos.nombre AS tipo, cat_productos.*')
                    ->first();
            }
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
                        ->where('cat_productos.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos.id_categoria', 'left')
                        ->join('cat_productos_subcategorias', 'cat_productos_subcategorias.id = cat_productos.id_subcategoria', 'left')
                        ->join('cat_productos_marcas', 'cat_productos_marcas.id = cat_productos.id_marca', 'left')
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria, cat_productos_subcategorias.nombre AS subcategoria, cat_productos_marcas.nombre AS marca, cat_productos_tipos.nombre AS tipo, cat_productos.*')
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
                        ->where('cat_productos.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos.id_categoria', 'left')
                        ->join('cat_productos_subcategorias', 'cat_productos_subcategorias.id = cat_productos.id_subcategoria', 'left')
                        ->join('cat_productos_marcas', 'cat_productos_marcas.id = cat_productos.id_marca', 'left')
                        ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria, cat_productos_subcategorias.nombre AS subcategoria, cat_productos_marcas.nombre AS marca, cat_productos_tipos.nombre AS tipo, cat_productos.*')
                        ->findAll();
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];
        $model = new CatProducto();

        $encontrado['data'] = $model
            ->where('cat_productos.id_instancia', $this->id_instancia)
            ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos.id_categoria', 'left')
            ->join('cat_productos_subcategorias', 'cat_productos_subcategorias.id = cat_productos.id_subcategoria', 'left')
            ->join('cat_productos_marcas', 'cat_productos_marcas.id = cat_productos.id_marca', 'left')
            ->join('cat_productos_tipos', 'cat_productos_tipos.id = cat_productos.id_tipo_producto', 'left')
            ->select('cat_productos_categorias.nombre AS categoria, cat_productos_subcategorias.nombre AS subcategoria, cat_productos_marcas.nombre AS marca, cat_productos_tipos.nombre AS tipo, cat_productos.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/ajax/table_data', $encontrado);
        }

        return json_encode($response);
    }

    function ajax_onchange_categorias() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => true, 'csrf_token' => csrf_hash()];
        $model = new CatProductoSubCategoria();
        $option = '<option value="">SELECIONE UNA OPCION</option>';

        if(array_key_exists('id', (array)$data)){
            $encontrado = $model->where(['status_alta' => 1, 'id_categoria' => $data->id])->findAll();

            if(!empty($encontrado)){
                foreach ($encontrado as $key => $value) {
                    $option .= '<option value="'.$value['id'].'">'.strtoupper($value['nombre']).'</option>';
                }
            }   
        }
        
        $response['select'] = $option;
        
        return json_encode($response);
    }

}