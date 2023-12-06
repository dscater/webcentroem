<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = "especialidad";
    protected $fillable = [
        "id",
        "especialidad",
        "state"
    ];
}
