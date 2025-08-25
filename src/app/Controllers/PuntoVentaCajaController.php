<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PuntoVentaCajaModel;

class PuntoVentaCajaController extends BaseController
{
    function index(){
        
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES OBLIGATORIO ESCRIBIR UN MONTO INICIAL.'], 'next' => false, 'csrf_token' => csrf_hash()];
        $modelPuntoVentaCaja = new PuntoVentaCajaModel();  
        
        if(!empty($data->monto_inicial)){
            $caja_id = $modelPuntoVentaCaja->insert([
                'id_instancia'  => $this->id_instancia,
                'id_usuario'    => $this->id_usuario,
                'id_usuario_creacion' => $this->id_usuario,
                'id_usuario_edicion' => $this->id_usuario,
                'monto_inicial' => $data->monto_inicial
            ]);
            if(!empty($caja_id)){
                $response['next'] = true;
                $response['response_message'] = ['type' => 'success', 'message' => 'SE CREO CON EXITO SU CAJA CON FOLIO <strong>'.$caja_id.'</strong> Y UN MONTO DE <strong>$ '.number_format($data->monto_inicial, 2).'</strong>'];
            }
        }


        return json_encode($response);
    }
}