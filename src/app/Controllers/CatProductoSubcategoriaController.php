<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProductoCategoria;
use App\Models\CatProductoSubCategoria;

class CatProductoSubcategoriaController extends BaseController
{

    function __construct(){
        $this->modelCatProductoCategoria = new CatProductoCategoria();
        $this->modelCatProductoSubCategoria = new CatProductoSubCategoria();
    }
    
    function index(){}

    function store() {
        $data = json_decode($this->request->getPost('data'));

        return process_store([
            'data'        => $data,
            'model'       => $this->modelCatProductoSubCategoria,
            'field_check' => ['nombre'],
            'field_name'  => 'sub categoria',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return ($this->modelCatProductoSubCategoria)
                        ->where('cat_productos_subcategorias.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
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
            'model' => $this->modelCatProductoSubCategoria,
            'field_name' => 'sub categoria'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));

        return process_update([
            'data'        => $data,
            'model'       => $this->modelCatProductoSubCategoria,
            'field_check' => ['nombre'],
            'field_name'  => 'sub categoria',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return ($this->modelCatProductoSubCategoria)
                        ->where('cat_productos_subcategorias.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
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
        
        return process_destroy([
            'data'       => $data,
            'model'      => $this->modelCatProductoSubCategoria,
            'field_name' => 'categorias',
            'view' => [
                'load' => 'catalogos/productos/subcategorias/ajax/table_data',
                'data'  => function(){
                    return (new CatProductoSubCategoria())
                        ->where('cat_productos_subcategorias.id_instancia', $this->id_instancia)
                        ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
                        ->select('cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
                        ->findAll();
                }
            ]         
        ]);
    }

    function ajax_refresh_table() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => '', 'message' => ''], 'next' => false, 'csrf_token' => csrf_hash()];

        $encontrado['data'] = $this->modelCatProductoSubCategoria
            ->where('cat_productos_subcategorias.id_instancia', $this->id_instancia)
            ->join('cat_productos_categorias', 'cat_productos_categorias.id = cat_productos_subcategorias.id_categoria', 'left')
            ->select('cat_productos_categorias.nombre AS categoria,  cat_productos_subcategorias.*')
            ->findAll();

        if(!empty($encontrado)){
            $response['next'] = true;
            $response['view'] = view('catalogos/productos/subcategorias/ajax/table_data', $encontrado);            
            $response['list_categorias'] = '<option value="">SELECCIONE UNA OPCION.</option>';
            
            $categorias = $this->modelCatProductoCategoria->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
            if(!empty($categorias)){
                foreach ($categorias as $key => $value) {
                    $response['list_categorias'] .= '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
                }
            }
        }

        return json_encode($response);
    }
}