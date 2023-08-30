<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitaMedica extends Model
{
    protected $table = "cita_medica";

    public static function citasNoAtendidas()
    {
        $citas = CitaMedica::where("estado", "PENDIENTE")
            ->where("fecha_cita", "<", date("Y-m-d"))
            ->where("state", 1)
            ->get();
        if (count($citas) > 0) {
            foreach ($citas as $value) {
                $value->estado = "NO ATENDIDO";
                $value->save();
            }
        }
    }
}
