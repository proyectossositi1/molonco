<?php

namespace App\Models;

use CodeIgniter\Model;

class CatOrganizacionModel extends Model
{
    protected $table            = 'cat_organizaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_usuario_empresa_creacion', 'id_usuario_empresa_edicion', 'id_sat_regimen_fiscal', 'id_sat_tipo_cfdi', 'id_sat_forma_pago', 'id_sat_uso_cfdi', 'codigo_postal', 'rfc', 'razon_social', 'direccion', 'moneda', 'email_primario', 'email_secundario', 'telefono_primario', 'telefono_secundario', 'status_alta'];

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