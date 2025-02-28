<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Folio extends Model
{
    use HasFactory;

    protected $fillable = ['notificacion_id', 'folio'];



    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'notificacion_id', 'id');
    }
}
