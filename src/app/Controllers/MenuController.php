<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatMenuModel;
use App\Models\CatEmpresaModel;

class MenuController extends BaseController
{
    function index(){
        $model = new CatMenuModel();
        $modelEmpresa = new CatEmpresaModel();
        $data['list_empresas'] = $modelEmpresa->where(['status_alta' => 1])->findAll();
        $data['data'] = $model
            ->where('cat_sys_menus.id_empresa', $this->id_empresa)
            ->join('cat_empresas', 'cat_empresas.id = cat_sys_menus.id_empresa', 'left')
            ->select('cat_empresas.nombre AS empresa, cat_sys_menus.*')
            ->findAll();        
        
        return renderPage([
            'view'  => 'admin/menus/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatMenuModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['name'],
            'field_name'  => 'menu',
            'view' => [
                'load'  => 'admin/menus/ajax/table_data',
                'data'  => function(){
                    return (new CatMenuModel())
                        ->where('cat_sys_menus.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_sys_menus.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_sys_menus.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->name = limpiar_cadena_texto($return->name);
                if($return->icon == "") unset($return->icon);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatMenuModel(),
            'field_name' => 'menu'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatMenuModel();
        
        return process_update([
            'data' => $data,
            'model' => $model,
            'field_check' => ['name'],
            'field_name' => 'menu',
            'view' => [
                'load'  => 'admin/menus/ajax/table_data',
                'data'  => function(){
                    return (new CatMenuModel())
                        ->where('cat_sys_menus.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_sys_menus.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_sys_menus.*')
                        ->findAll();
                }
                
            ],        
            'precallback' => function ($return) {
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
                $return->name = limpiar_cadena_texto($return->name);
                if($return->icon == "") unset($return->icon);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatMenuModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'menu',
            'view' => [
                'load' => 'admin/menus/ajax/table_data',
                'data'  => function(){
                    return (new CatMenuModel())
                        ->where('cat_sys_menus.id_empresa', $this->id_empresa)
                        ->join('cat_empresas', 'cat_empresas.id = cat_sys_menus.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_sys_menus.*')
                        ->findAll();
                }
            ]         
        ]);
    }
}