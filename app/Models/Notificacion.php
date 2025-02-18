<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $tipo_id
 * @property User $user_id
 * @property Destinatarios $destinatario_id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha
 */
class Notificacion extends Model
{
    use HasFactory;


    protected $table = 'notificaciones';

    protected $fillable = [
        'tipo_id', 'user_id', 'destinatario_id', 'titulo', 'descripcion', 'fecha'
    ];

    /**
     * @return BelongsTo<Tipo, Notificacion>
     */
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    /**
     * @return BelongsTo<User, Notificacion>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Destinatarios, Notificacion>
     */
    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(Destinatarios::class, 'destinatario_id');
    }
}
