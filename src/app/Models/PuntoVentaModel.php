<?php

namespace App\Models;

use CodeIgniter\Model;

class PuntoVentaModel extends Model
{
    protected $table            = 'xx_ventas_productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_instancia', 'id_usuario_creacion', 'id_usuario_edicion', 'id_metodo_pago', 'id_corte_caja', 'moneda', 'cod_referencia', 'subtotal', 'iva', 'total', 'pago_cliente', 'cambio_cliente', 'id_usuario_cancelo', 'fecha_cancelacion', 'comentario_cancelacion', 'estado', 'status_alta'];

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
}