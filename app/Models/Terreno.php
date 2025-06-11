<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    use HasFactory;

    protected $fillable = [
        "municipio_id",
        "urbanizacion_id",
        "manzano_id",
        "nombre",
        "tipo_calle",
        "ancho_calle",
        "conectividad",
        "trafico",
        "tipo_zona",
        "agua_potable",
        "alcantarillado",
        "energia_electrica",
        "gas_natural",
        "alumbrado",
        "recoleccion_basura",
        "conexion_internet",
        "escuelas",
        "centros_educativos",
        "hospitales",
        "centros_salud",
        "centros_comerciales",
        "mercados",
        "tiendas",
        "parques",
        "plazas",
        "espacios_recreativos",
        "iglesias",
        "oficinas_gubarnamentales",
        "oficinas_servicios",
        "bancos",
        "areas_verdes",
        "nivel_urbanizacion",
        "seguro",
        "limpio",
        "en_desarrollo",
        "viviendas",
        "negocios",
        "bodegas",
        "galpones",
        "terrenos_baldios",
        "topografia_entorno",
        "superficie_terreno",
        "costo_contado",
        "costo_credito",
        "publicar",
        "vendido",
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

    public function urbanizacion()
    {
        return $this->belongsTo(Urbanizacion::class, 'urbanizacion_id');
    }

    public function manzano()
    {
        return $this->belongsTo(Manzano::class, 'manzano_id');
    }

    public function imagens()
    {
        return $this->hasMany(TerrenoImagen::class, 'terreno_id');
    }
}
