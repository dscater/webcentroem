<?php

namespace App;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Model;

class FacturaConcepto extends Model
{
    protected $fillable = [
        "id_factura",
        "id_concepto",
        "concepto",
        "costo",
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function o_concepto()
    {
        return $this->belongsTo(Concepto::class, 'id_concepto');
    }
}
