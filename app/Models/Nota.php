<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
    ];

    /**
     * Alcance global: solo notas con recordatorio activo
     */
    protected static function booted()
    {
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($query) {
                $query->where('fecha_vencimiento', '>=', now())
                      ->where('completado', false);
            });
        });
    }

    /**
     * Accesor: título formateado según estado del recordatorio
     */
    public function getTituloFormateadoAttribute()
    {
        // Por seguridad, si no hay recordatorio devolvemos solo el título
        if (!$this->recordatorio) {
            return $this->titulo;
        }

        return $this->recordatorio->completado
            ? "[Completado] {$this->titulo}"
            : $this->titulo;
    }

    /**
     * Una nota pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Una nota tiene un recordatorio
     */
    public function recordatorio()
    {
        return $this->hasOne(Recordatorio::class);
    }

    /**
     * Una nota tiene muchas actividades
     */
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }
}
