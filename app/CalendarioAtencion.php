<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarioAtencion extends Model
{
    protected $fillable = [
        "user_id",
        "fecha_ini",
        "fecha_fin",
    ];

    public function user()
    {
        return $this->belongsTo(Models\Usuario::class, 'user_id');
    }
}
