<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CatProducto;
use App\Models\CatClienteModel;

class PuntoVentaController extends BaseController
{
    public function index()
    {
        $modelProducto = new CatProducto();
        $modelCliente = new CatClienteModel();
        
        $data['productos'] = $modelProducto
            ->select('cat_productos.*, cat_productos_empresa_precios.precio_venta')
            ->join('cat_productos_empresa_precios', 'cat_productos_empresa_precios.id_producto = cat_productos.id')
            ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
            ->where('cat_productos.status_alta', 1)
            ->paginate(10);
            
        $data['pager'] = $modelProducto->pager;
        $data['clientes'] = $modelCliente->findAll();
        
        return renderPage([
            'view'  => 'punto_venta/index',
            'data'  => $data
        ]);
    }

    public function buscarProducto()
    {
        $busqueda = $this->request->getPost('busqueda');
        $model = new CatProducto();
        
        $productos = $model
            ->select('cat_productos.*, cat_productos_empresa_precios.precio_venta')
            ->join('cat_productos_empresa_precios', 'cat_productos_empresa_precios.id_producto = cat_productos.id')
            ->where('cat_productos_empresa_precios.id_empresa', $this->id_empresa)
            ->where('cat_productos.status_alta', 1)
            ->groupStart()
                ->like('cat_productos.nombre', $busqueda)
                ->orLike('cat_productos.codigo_barras', $busqueda)
            ->groupEnd()
            ->paginate(10);
            
        $pager = $model->pager;
        
        return $this->response->setJSON([
            'productos' => $productos,
            'pager' => $pager
        ]);
    }

    public function guardarVenta()
    {
        $data = json_decode($this->request->getPost('data'));
        // Aquí iría la lógica para guardar la venta
        // Por ahora solo retornamos éxito
        return $this->response->setJSON(['success' => true]);
    }
}