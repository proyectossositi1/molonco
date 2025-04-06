<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatClienteModel;
use App\Models\CatOrganizacionModel;
use App\Models\SatRegimenFiscalModel;
use App\Models\SatTipoCfdiModel;
use App\Models\SatUsoCfdiModel;
use App\Models\SatFormaPagoModel;

class ClienteController extends BaseController
{
    public function index(){
        $model = new CatClienteModel();
        $modelOrganizacion = new CatOrganizacionModel();
        
        $data['data'] = $model
            ->join('cat_organizaciones', 'cat_organizaciones.id = cat_clientes.id_organizacion', 'left')
            ->select('cat_organizaciones.razon_social AS organizacion, cat_clientes.*')
            ->findAll();
        $data['list_organizacion'] = $modelOrganizacion->where(['status_alta' => 1])->findAll();
        
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
                        ->join('cat_organizaciones', 'cat_organizaciones.id = cat_clientes.id_organizacion', 'left')
                        ->select('cat_organizaciones.razon_social AS organizacion, cat_clientes.*')
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
                        ->join('cat_organizaciones', 'cat_organizaciones.id = cat_clientes.id_organizacion', 'left')
                        ->select('cat_organizaciones.razon_social AS organizacion, cat_clientes.*')
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
                        ->join('cat_organizaciones', 'cat_organizaciones.id = cat_clientes.id_organizacion', 'left')
                        ->select('cat_organizaciones.razon_social AS organizacion, cat_clientes.*')
                        ->findAll();
                }
            ]         
        ]);
    }

}