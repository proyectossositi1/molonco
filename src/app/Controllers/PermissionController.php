<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatPermissionModel;

class PermissionController extends BaseController
{
    function index(){
        $permissionModel = new CatPermissionModel();
        $data['data'] = $permissionModel
            ->where(['cat_sys_permissions.id_instancia' => $this->id_instancia])
            ->join('sys_instancias', 'sys_instancias.id = cat_sys_permissions.id_instancia', 'left')
            ->select('sys_instancias.nombre AS instancia, cat_sys_permissions.*')
            ->findAll();
        
        return renderPage([
            'view'  => 'admin/permissions/index',
            'data'  => $data
        ]);
    }

    function store(){
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

    function edit() {
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

    function destroy() {
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