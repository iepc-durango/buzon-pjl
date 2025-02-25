<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionArchivo extends Model
{
    protected $fillable = ['notificacion_id', 'file_path', 'file_name'];

    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class);
    }
}
