<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinatarios extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'correo'];


    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
}
