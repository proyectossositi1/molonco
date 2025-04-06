<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatMenuModel;

class MenuController extends BaseController
{
    function index(){
        $model = new CatMenuModel();
        $data['data'] = $model->findAll();
        
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
                'load' => 'admin/menus/ajax/table_data'
            ],
            'precallback' => function($return) {
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
                'load' => 'admin/menus/ajax/table_data',
                
            ],        
            'precallback' => function ($return) {
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
                'load' => 'admin/menus/ajax/table_data'
            ]         
        ]);
    }
}