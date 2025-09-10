<?php

namespace App\Models;

use CodeIgniter\Model;

class CatProducto extends Model
{
    protected $table            = 'cat_productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_instancia', 'id_usuario_creacion', 'id_usuario_edicion', 'id_categoria', 'id_subcategoria', 'id_marca', 'id_tipo_producto', 'nombre', 'codigo_barras', 'sku', 'cantidad', 'descripcion', 'status_alta'];

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


    function filter_producto($data = ['key' => '', 'value' => '', 'id_instancia' => '']){
        $builder = $this->db->table($this->table . ' p')
        ->select('p.id, CONCAT_WS("", "SKU: ", p.sku, ", ", p.nombre) AS nombre, p.cantidad, pp.precio_venta AS precio, p.sku, p.codigo_barras')
        ->join('cat_productos_precios pp', 'pp.id_producto = p.id AND pp.anio = YEAR(CURRENT_DATE())')        
        ->where('p.status_alta', 1)
        ->where('p.id_instancia', $data['id_instancia']);

        // Filtros dinámicos
        if(array_key_exists('key', $data)){
            if ($data['key'] === 'categoria' && !empty($data['value'])) {
                $builder->where('p.id_categoria', $data['value']);
            }
            if ($data['key'] === 'subcategoria' && !empty($data['value'])) {
                $builder->where('p.id_subcategoria', $data['value']);
            }
            if ($data['key'] === 'marca' && !empty($data['value'])) {
                $builder->where('p.id_marca', $data['value']);
            }
            if ($data['key'] === 'tipo' && !empty($data['value'])) {
                $builder->where('p.id_tipo_producto', $data['value']);
            }
        }        

        return $builder->get()->getResultArray();
    }
}