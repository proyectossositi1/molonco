<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PuntoVentaCajaModel;

class PuntoVentaCajaController extends BaseController
{

    function __construct(){
        $this->modelPuntoVentaCaja = new PuntoVentaCajaModel();
    }
    
    function index(){
        
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES OBLIGATORIO ESCRIBIR UN MONTO INICIAL.'], 'next' => false, 'csrf_token' => csrf_hash()];        
        
        if(!empty($data->monto_inicial)){
            $caja_id = $this->modelPuntoVentaCaja->insert([
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

    function finalizar() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES NECESARIO TENER UNA CAJA ABIERTA PARA PODER REALIZAR ESTA ACCION.'], 'next' => false, 'csrf_token' => csrf_hash()];

        if($data->id_corte_caja != ""){
            $monto_final = $this->modelPuntoVentaCaja
                ->select('(SUM(IFNULL(xx_ventas_productos.total, 0)) + SUM(xx_ventas_corte_caja.monto_inicial)) total')
                ->join('xx_ventas_productos', 'xx_ventas_productos.id_corte_caja = xx_ventas_corte_caja.id')
                ->join('cat_tipopagos', 'cat_tipopagos.id = xx_ventas_productos.id_metodo_pago')
                ->where(['xx_ventas_productos.id_corte_caja' => $data->id_corte_caja, 'xx_ventas_productos.estado' => 'VENDIDO', 'LOWER(cat_tipopagos.nombre)' => 'efectivo'])
                ->first();
            
            if($this->modelPuntoVentaCaja->update($data->id_corte_caja, [
                'status_abierto' => 0,
                'status_alta'    => 2,
                'fecha_cierre'   => date('Y-m-d H:i:s'),
                'monto_final'    => $monto_final['total']
            ])){
                $response['next'] = true;
                $response['response_message'] = [
                    'type'      => 'success',
                    'message'   => 'SE HA FINALIZADO CON EXITOS EL NO. CAJA <strong>'.$data->id_corte_caja.'</strong> CON EL MONTO DE <strong>$ '.number_format($monto_final['total'], 2).'.</strong>'
                ];
            }
        }
        
        return json_encode($response);
    }
}