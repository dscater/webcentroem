<?php

namespace App\Models;

use App\Concepto;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = "factura";

    protected $fillable = [
        "id_paciente",
        "tipo_paciente",
        "institucion",
        "id_especialidad",
        "numero_autorizacion",
        "codigo_control",
        "fecha_limite_emision",
        "paciente_nombre",
        "paciente_ci",
        "fecha_factura",
        "nro_factura",
        "concepto_id",
        "concepto",
        "monto",
        "descuento",
        "monto_total",
        "state"
    ];

    public function o_concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }
}
