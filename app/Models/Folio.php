<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Folio extends Model
{
    use HasFactory;

    protected $fillable = ['notificacion_id', 'folio', 'detalle_id'];



    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class, 'notificacion_id', 'id');
    }

    public function detalle()
{
    return $this->belongsTo(Detalle::class, 'detalle_id', 'id');
}



}
