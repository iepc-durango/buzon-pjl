<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $fillable = ['id_notificacion', 'destinatario_id', 'status_abierto', 'status_envio', 'link'];

    protected $casts = [
        'status_abierto' => 'string', // Ya que es un ENUM, se almacena como string
        'status_envio' => 'string',  // Almacenado también como string
    ];

    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'id_notificacion');
    }

    public function destinatario()
    {
        return $this->belongsTo(Destinatario::class, 'destinatario_id');
    }

    public function folio()
{
    return $this->hasOne(Folio::class, 'detalle_id', 'id');
}

    
    

}

