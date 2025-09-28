<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PuntoVentaCajaModel;
use App\Models\PuntoVentaModel;
use App\Models\PuntoVentaLineaModel;
use App\Models\CatProducto;
use App\Models\CatProductoCategoria;
use App\Models\CatProductoSubCategoria;
use App\Models\CatProductoTipoModel;
use App\Models\CatProductoMarca;
use App\Models\CatTipoPagoModel;


class PuntoVentaController extends BaseController
{
    function __construct(){
        $this->modelPuntoVentaCaja = new PuntoVentaCajaModel();  
        $this->modelPuntoVenta = new PuntoVentaModel();  
        $this->modelPuntoVentaLinea = new PuntoVentaLineaModel();
        $this->modelProducto = new CatProducto();
        $this->modelCategoria = new CatProductoCategoria();
        $this->modelSubCategoria = new CatProductoSubCategoria();
        $this->modelTipo = new CatProductoTipoModel();
        $this->modelMarca = new CatProductoMarca();
        $this->modelTipoPago = new CatTipoPagoModel();
    }

    function index(){
        // ANTES DE MOSTRAR EL POS, NECESITAMOS VERIFICAR QUE SE ENCUENTRE UNA CAJA ABIERTA, EN CASO DE QUE NO, MOSTRAMOS LA VISTA DE LA CAJA PARA ABRIRLA
        // CONSULTA PARA SABER SI EXISTE UNA CAJA ABIERTA
        $data['data_caja'] = $this->modelPuntoVentaCaja->where(['status_abierto' => 1, 'id_instancia' => $this->id_instancia, 'id_usuario' => $this->id_usuario])->first();  
        // CONSULTAS PARA VISUALIZAR EN EL PUNTO DE VENTA
        $data['list_categorias'] = $this->modelCategoria->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_subcategorias'] = $this->modelSubCategoria->where(['status_alta' => 1])->findAll();        
        $data['list_tipos'] = $this->modelTipo->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_marcas'] = $this->modelMarca->where(['status_alta' => 1, 'id_instancia' => $this->id_instancia])->findAll();
        $data['list_productos'] = $this->modelProducto->filter_producto(['id_instancia' => $this->id_instancia]);
        $data['list_tipopagos'] = $this->modelTipoPago->where(['id_instancia' => $this->id_instancia, 'status_alta' => 1])->findAll();
        // CONSUTLA PARA SABER SI EXISTE UNA VENTA ABEIRTA        
        $data['data_venta'] = (!empty($data['data_caja'])) ? $this->modelPuntoVenta->where(['id_instancia' => $this->id_instancia, 'id_corte_caja' => $data['data_caja']['id'], 'estado' => 'ABIERTO'])->first() : []; 
        $data['data'] = (!empty($data['data_venta'])) ? $this->modelPuntoVentaLinea->listado_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $data['data_venta']['id']]) : [];     
        $data['data_totales'] = (!empty($data['data_venta'])) ? $this->modelPuntoVentaLinea->total_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $data['data_venta']['id']]) : [];
        
        if(empty($data['data_caja'])){
            return renderPage([
                'view'  => 'puntoventas/caja/index',
                'data'  => $data
            ]);    
        }else{
            return renderPage([
                'view'  => 'puntoventas/index',
                'data'  => $data
            ]);
        }
    }

    function ajax_filter_listado_productos($key = null, $value = null) {    
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES NECESARIO SELECCIONAR AL MENOS UN FILTRO PARA MOSTRAR EL LISTADO DE LOS PRODUCTOS.'], 'next' => false, 'list_productos' => '<option value="">SELECCIONE UNA OPCION</option>'];
 
        $encontrado = $this->modelProducto->filter_producto(['key' => $key, 'value' => $value, 'id_instancia' => $this->id_instancia]);
        if(!empty($encontrado)){
            $response['next'] = true;
            
            foreach ($encontrado as $key => $value) {
                $response['list_productos'] .= '<option value="'.$value['id'].'" data-cantidad="'.$value['cantidad'].'" data-precio="'.$value['precio'].'" data-sku="'.$value['sku'].'" data-codigo_barras="'.$value['codigo_barras'].'">'.$value['nombre'].'</option>';
            }
        }
        
        return json_encode($response);
    }

    function store() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES NECESARIO SELECCIONAR TODOS LOS CAMPOS OBLIGATORIOS DEL FORMULARIO.'], 'next' => false, 'csrf_token' => csrf_hash()];

        if($data->id_corte_caja != "" && $data->id_producto != ""){           
           // SI SE ENCUENTRA VACION EL ID_VENTA_PRODCUTO, CREAREMOS LA VENTA
            $last_id_venta = (empty($data->id_venta_producto)) ? $this->modelPuntoVenta->insert([
                'id_instancia'  => $this->id_instancia,
                'id_usuario_creacion'   => $this->id_usuario,
                'id_usuario_edicion'    => $this->id_usuario,
                'id_corte_caja' => $data->id_corte_caja,
                'estado'    => 'ABIERTO'
            ]) : $data->id_venta_producto;
            if(!empty($last_id_venta)){
                $last_id_venta_linea = $this->modelPuntoVentaLinea->insert([
                    'id_instancia'  => $this->id_instancia,
                    'id_usuario_creacion'   => $this->id_usuario,
                    'id_usuario_edicion'    => $this->id_usuario,
                    'id_venta_producto'     => $last_id_venta,
                    'id_producto'           => $data->id_producto,
                    'precio'                => $data->precio,
                    'cantidad'              => $data->cantidad,
                    'subtotal'              => to_decimal($data->subtotal)
                ]);
            }

            // ASIGNAMOS EL ID DE LA VENTA, TENGA REGISTRO EN LA LINEA O NO, ESTO PARA QUE NO SE PIERDA EL FLUJO DE LA VENTA
            $response['id_venta_producto'] = $last_id_venta;
            if(!empty($last_id_venta_linea)){
                $response['next'] = true;                        
                $response['view'] = view('puntoventas/ajax/table_data', ['data' => $this->modelPuntoVentaLinea->listado_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $last_id_venta])]);
                $response['data_totales'] = $this->modelPuntoVentaLinea->total_ventas_lineas(['id_instancia' => $this->id_instancia, 'id_venta_producto' => $last_id_venta]);
            }
        }
        
        return json_encode($response);
    }

    function finalizar() {
        $data = json_decode($this->request->getPost('data'));
        $response = ['response_message' => ['type' => 'warning', 'message' => 'ES NECESARIO SELECCIONAR TODOS LOS CAMPOS OBLIGATORIOS PARA FINALIZAR LA VENTA.'], 'next' => false, 'csrf_token' => csrf_hash()];

        if(!empty($data)){
            // ANTES DE FINALIZAR LA COMPRA, TENDREMOS QUE VALIDAR SI HAY EN EXISTENCIA POR CADA LINEA DE VENTA
            $response = $this->validar_inventario($data);

            if($response['next']){
                // ACTUALIZAREMOS LOS TOTALES Y LOS ESTATUS DE LA VENTA
                $array_venta = [
                    'id_usuario_edicion'    => $this->id_usuario,
                    'id_metodo_pago'        => $data->id_metodo_pago,
                    'subtotal'              => $data->subtotal,
                    'iva'                   => $data->iva,
                    'total'                 => $data->total,
                    'estado'                => 'VENDIDO',
                    'status_alta'           => 2
                ];
                if(!empty($data->tipo_tarjeta)) $array_venta['tipo_tarjeta'] = $data->tipo_tarjeta;
                if(!empty($data->categoria_tarjeta)) $array_venta['categoria_tarjeta'] = $data->categoria_tarjeta;
                if(!empty($data->cod_referencia)) $array_venta['cod_referencia'] = $data->cod_referencia;
                if(!empty($data->pago_cliente)) $array_venta['pago_cliente'] = $data->pago_cliente;
                if(!empty($data->cambio_cliente)) $array_venta['cambio_cliente'] = $data->cambio_cliente;

                if($this->modelPuntoVenta->update($data->data->id_venta_producto, $array_venta)){
                    $response['next'] = true;                
                    $response['response_message'] = ['type' => 'success', 'message' => 'LA VENTA SE REALIZO CON EXITO.'];
                }else{
                    $response['next'] = false;
                    $response['response_message'] = ['type' => 'success', 'message' => 'HUBO UN PROBLEMA AL FINALIZAR LA VENTA.'];
                }

                // EN ESTE PROCESO LO UTILIZAREMOS PARA ACTUALIZAR EL TOTAL DE LA CAJA ABIERTA
                if($response['next']){   
                    $this->update_cierre([
                        'data' => $data->data
                    ]);  
                }
            }            
        }
        
        return json_encode($response);
    }

    function validar_inventario($data){        
        $response = ['response_message' => ['type' => 'warning', 'message' => 'NO SE ENCONTRO PRODUCTOS EN INVENTARIOS'], 'next' => false, 'csrf_token' => csrf_hash()];
        
        if(!empty($data)){
            $disponible = $this->modelPuntoVentaLinea->disponibilidad_linea(['id_venta_producto' => $data->data->id_venta_producto]);
            if(!empty($disponible)){
                $count_no_disponible = 0;
                $message = 'NO SE PUEDE FINALIZAR LA VENTA YA QUE LOS SIGUIENTES PRODUCTOS NO SE ENCUENTRAN DISPONIBLES: <ol>';                
                foreach ($disponible as $key => $value) {
                    if($value['procesar'] == 0){                        
                        $message .= "<li>{$value['producto']}, DISPONIBLE DE {$value['disponible']}</li>";
                        $count_no_disponible++;
                    }
                }
                $response['response_message'] = ['type' => 'danger', 'message' => $message.'</ol>'];
                
                if(($count_no_disponible == 0)){
                    $response['next'] = true;
                    // SI TODO SALE CON DISPONIBILIDAD, AHORA PROCEGUEREMOS A DESCONTAR EL PRODUCTO                    
                    foreach ($disponible as $key => $value) {
                        $this->modelProducto
                            ->where('id', (int)$value['id_producto'])
                            ->set('cantidad', 'cantidad - ' . (int)$value['cantidad'], false) // false => aritmética
                            ->update();
                    }
                }else{
                    $repsonse['next'] = false;
                }
            }
        }

        return $response;
    }

    function update_cierre($data = ['data' => []]) {
        $array_data = [];
        
        $array_data['monto_final'] = $this->modelPuntoVenta
            ->select('(SUM(IFNULL(xx_ventas_productos.total, 0)) + SUM(xx_ventas_corte_caja.monto_inicial)) total')
            ->join('xx_ventas_corte_caja', 'xx_ventas_corte_caja.id = xx_ventas_productos.id_corte_caja')
            ->join('cat_tipopagos', 'cat_tipopagos.id = xx_ventas_productos.id_metodo_pago')
            ->where(['xx_ventas_productos.id_corte_caja' => $data['data']->id_corte_caja, 'xx_ventas_productos.estado' => 'VENDIDO', 'LOWER(cat_tipopagos.nombre)' => 'efectivo'])
            ->first();
            
        $this->modelPuntoVentaCaja->update($data['data']->id_corte_caja, $array_data);     
    }
}