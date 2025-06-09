<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urbanizacion extends Model
{
    use HasFactory;
    protected $fillable = [
        "municipio_id",
        "nombre",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t"];

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    // RELACIONES
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }
}
