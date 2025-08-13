<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatClienteModel;
use App\Models\CatEmpresaModel;

class ClienteController extends BaseController
{
    public function index(){
        $model = new CatClienteModel();
        $modelEmpresa = new CatEmpresaModel();
        
        $data['data'] = $model
            ->where(['cat_clientes.id_instancia' => $this->id_instancia])
            ->join('cat_empresas', 'cat_empresas.id = cat_clientes.id_empresa', 'left')
            ->select('cat_empresas.nombre AS empresa, cat_clientes.*')
            ->findAll();
        $data['list_empresa'] = $modelEmpresa->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        
        return renderPage([
            'view'  => 'catalogos/clientes/index',
            'data'  => $data
        ]);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatClienteModel();

        return process_store([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['email_primario', 'telefono_primario'],
            'field_name'  => 'cliente',
            'view' => [
                'load' => 'catalogos/clientes/ajax/table_data',
                'data'  => function(){
                    return (new CatClienteModel())
                        ->where(['cat_clientes.id_instancia' => $this->id_instancia])
                        ->join('cat_empresas', 'cat_empresas.id = cat_clientes.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_clientes.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombres = limpiar_cadena_texto($return->nombres);
                $return->apellido_paterno = limpiar_cadena_texto($return->apellido_paterno);
                $return->apellido_materno = limpiar_cadena_texto($return->apellido_materno);
                
                return $return;
            }
        ]);
    }

    function edit() {
        $data = json_decode($this->request->getPost('data'));
        
        return process_edit([
            'data' => $data,
            'model' => new CatClienteModel(),
            'field_name' => 'cliente'
        ]);
    }

    function update() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatClienteModel();

        return process_update([
            'data'        => $data,
            'model'       => $model,
            'field_check' => ['email_primario', 'telefono_primario'],
            'field_name'  => 'cliente',
            'view' => [
                'load' => 'catalogos/clientes/ajax/table_data',
                'data'  => function(){
                    return (new CatClienteModel())
                        ->where(['cat_clientes.id_instancia' => $this->id_instancia])
                        ->join('cat_empresas', 'cat_empresas.id = cat_clientes.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_clientes.*')
                        ->findAll();
                }
            ],
            'precallback' => function($return) {
                // SETEAMOS CAMPOS ANTES DE AGREGAR O EDITAR
                $return->nombres = limpiar_cadena_texto($return->nombres);
                $return->apellido_paterno = limpiar_cadena_texto($return->apellido_paterno);
                $return->apellido_materno = limpiar_cadena_texto($return->apellido_materno);
                
                return $return;
            }
        ]);
    }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $model = new CatClienteModel();
        
        return process_destroy([
            'data'       => $data,
            'model'      => $model,
            'field_name' => 'cliente',
            'view' => [
                'load' => 'catalogos/clientes/ajax/table_data',
                'data'  => function(){
                    return (new CatClienteModel())
                        ->where(['cat_clientes.id_instancia' => $this->id_instancia])
                        ->join('cat_empresas', 'cat_empresas.id = cat_clientes.id_empresa', 'left')
                        ->select('cat_empresas.nombre AS empresa, cat_clientes.*')
                        ->findAll();
                }
            ]         
        ]);
    }

}