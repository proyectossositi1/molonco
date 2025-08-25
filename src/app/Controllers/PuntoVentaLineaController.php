<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PuntoVentaLineaModel;

class PuntoVentaLineaController extends BaseController
{
    function __construct(){
        $this->modelPuntoVentaLinea = new PuntoVentaLineaModel();
    }

    function index(){ }

    function destroy() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'NO SE ENCONTRO UN FOLIO PARA PODER REALIZAR LA ELIMINACION.'], 'next' => false, 'csrf_token' => csrf_hash()];
        
        if(!empty($data->id)){
            if($this->modelPuntoVentaLinea->delete($data->id, true)){
                $response['next'] = true;
                $response['response_message'] = ['type' => 'success', 'message' => 'EL FOLIO <strong>'.$data->id.'</strong> FUE ELIMINADO CON EXITO.']; 
                $response['data_totales'] = $this->modelPuntoVentaLinea->total_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $data->id_venta_producto]);
                $response['view'] = view('puntoventas/ajax/table_data', ['data' => $this->modelPuntoVentaLinea->listado_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $data->id_venta_producto])]);
            }
        }

        return json_encode($response);
    }
}