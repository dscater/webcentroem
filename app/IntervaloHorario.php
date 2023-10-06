<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntervaloHorario extends Model
{
    protected $fillable = [
        "user_id", "intervalo"
    ];
}
