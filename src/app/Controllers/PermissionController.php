<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatPermissionModel;

class PermissionController extends BaseController
{
    public function index(){
        $permissionModel = new CatPermissionModel();
        $data['data'] = $permissionModel->findAll();
        
        return renderPage([
            'view'  => 'admin/permissions/index',
            'data'  => $data
        ]);
    }

    public function store(){
        $data = json_decode($this->request->getPost('data'));
        $model = new CatPermissionModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['name'],
            'field_name'  => 'permiso',
            'view' => [
                'load' => 'admin/permissions/ajax/table_data'
            ],
            'precallback' => function($return) {
                $return->name = limpiar_cadena_texto($return->name);
                
                return $return;
            }
        ]);
    }

    public function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatPermissionModel(),
            'field_name' => 'permiso'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatPermissionModel();
        
        return process_update([
            'data' => $data,
            'model' => $model,
            'field_check' => ['name'],
            'field_name' => 'permiso',
            'view' => [
                'load' => 'admin/permissions/ajax/table_data',
                
            ],        
            'precallback' => function ($return) {
                $return->name = limpiar_cadena_texto($return->name);
                
                return $return;
            }
        ]);
    }

    public function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatPermissionModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'permiso',
            'view' => [
                'load' => 'admin/permissions/ajax/table_data'
            ]         
        ]);
    }
}