<?php

namespace App\Models;

use CodeIgniter\Model;

class PuntoVentaLineaModel extends Model
{
    protected $table            = 'xx_ventas_productos_lineas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_instancia', 'id_usuario_creacion', 'id_usuario_edicion', 'id_venta_producto', 'id_producto', 'precio', 'cantidad', 'subtotal', 'status_alta'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    function listado_ventas_lineas($data = ['id_instancia' => '', 'id_venta_producto' => '']){
        $builder = $this->db->table($this->table . ' vpl')
        ->select('p.nombre AS producto, vpl.*')
        ->join('cat_productos p', 'p.id = vpl.id_producto')
        ->join('xx_ventas_productos vp', 'vp.id = vpl.id_venta_producto')
        ->where([
            'vp.estado'   => 'ABIERTO',
            'vp.id_instancia'   => $data['id_instancia'],
            'vpl.id_venta_producto' => $data['id_venta_producto']
        ]);   

        return $builder->get()->getResultArray();
    }

    function total_ventas_lineas($data = ['id_instancia' => '', 'id_venta_producto' => '']){
        $builder = $this->db->table($this->table . ' vpl')
        ->select('SUM(vpl.subtotal) AS subtotal, (SUM(vpl.subtotal) * .16) AS iva, ((SUM(vpl.subtotal) * .16) + SUM(vpl.subtotal)) AS total')
        ->join('xx_ventas_productos vp', 'vp.id = vpl.id_venta_producto')
        ->where([
            'vp.estado'   => 'ABIERTO',
            'vp.id_instancia'   => $data['id_instancia'],
            'vpl.id_venta_producto' => $data['id_venta_producto']
        ]);   

        return $builder->get()->getRowArray();
    }

    function disponibilidad_linea($data = ['id_venta_producto' => '']){
        $builder = $this->db->table($this->table . ' vpl')
            ->select('vpl.id_venta_producto
                ,vpl.id_producto
                ,p.nombre producto
                ,vpl.cantidad
                ,p.cantidad disponibilidad
                ,IF(vpl.cantidad < p.cantidad, 1, 0) procesar')
        ->join('cat_productos p', 'p.id = vpl.id_producto')
        ->where([
            'vpl.id_venta_producto' => $data['id_venta_producto']
        ]);
        
        return $builder->get()->getResultArray();
    }
}