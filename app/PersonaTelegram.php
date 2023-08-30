<?php

namespace App;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Model;

class PersonaTelegram extends Model
{
    protected $fillable = [
        "persona_id",
        "chat_id",
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
