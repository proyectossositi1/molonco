<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatPermissionModel;
use App\Models\CatEmpresaModel;

class PermissionController extends BaseController
{
    public function index(){
        $permissionModel = new CatPermissionModel();
        $modelEmpresa = new CatEmpresaModel(); 
        $data['list_empresas'] = $modelEmpresa->where(['status_alta' => 1])->findAll();
        $data['data'] = $permissionModel
            ->where(['cat_sys_permissions.id_empresa' => $this->id_empresa])
            ->join('cat_empresas', 'cat_empresas.id = cat_sys_permissions.id_empresa', 'left')
            ->select('cat_empresas.nombre AS empresa, cat_sys_permissions.*')
            ->findAll();
        
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
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
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
                if(!array_key_exists('id_empresa', (array)$return)) $return->id_empresa = $this->id_empresa;
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