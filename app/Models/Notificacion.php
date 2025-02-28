<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tipo_id', 'titulo', 'no_acuerdo', 'sesion', 'descripcion', 
        'fecha_aprobacion', 'no_expediente', 'denunciante', 'denunciado', 'municipio',
        'descripcion_fundamento', 'descripcion_docu', 'frag_doc', 'descripcion_notificado'
    ];

    protected $table = 'notificaciones';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'id_notificacion');
    }

    public function archivos()
{
    return $this->hasMany(NotificacionArchivo::class);
}


public function folio()
{
    return $this->belongsTo(Folio::class, 'notificacion_id', 'id');
}
}
