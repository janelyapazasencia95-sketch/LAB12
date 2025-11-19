<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';
    protected $fillable = ['nota_id', 'titulo', 'descripcion', 'completado'];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }
}