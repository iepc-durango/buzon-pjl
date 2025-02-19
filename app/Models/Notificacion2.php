<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion2 extends Model
{
    use HasFactory;

    protected $table = 'notificaciones2';

    protected $fillable = [
        'user_id', 'destinatario_id', 'tipo_id', 'titulo', 'descripcion',
        'descripcion_fundamento', 'descripcion_docu', 'frag_doc', 'descripcion_notificado',
        'sesion', 'no_acuerdo', 'denunciante', 'denunciado', 'no_expediente', 'municipio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destinatario()
    {
        return $this->belongsTo(Destinatarios::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
