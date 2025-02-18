<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;


    protected $table = 'notificaciones';

    protected $fillable = [
        'tipo_id', 'user_id', 'destinatario_id', 'titulo', 'descripcion', 'fecha'
    ];

    

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(Destinatarios::class, 'destinatario_id');
    }
}
