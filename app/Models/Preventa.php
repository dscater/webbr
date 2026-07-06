<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preventa extends Model
{
    use HasFactory;

    protected $fillable = [
        "terreno_id",
        "cliente_id",
        "descripcion",
        "estado",
        "calificacion",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    public function terreno()
    {
        return $this->belongsTo(Terreno::class, 'terreno_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
