<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusquedaInteligenteController extends Controller
{
    public function buscarInteligente(Request $request)
    {
        $criterios = $request->all();

        $query = Terreno::query();

        // 1. Coincidencias exactas
        $campos_exactos = [
            "municipio_id",
            "urbanizacion_id",
            "manzano_id",
            "tipo_calle",
            "ancho_calle",
            "conectividad",
            "trafico",
            "tipo_zona",
            "topografia_entorno",
            "nivel_urbanizacion",
            "costo_contado",
            "costo_credito",
        ];

        foreach ($campos_exactos as $campo) {
            if (!empty($criterios[$campo])) {
                $query->where($campo, $criterios[$campo]);
            }
        }

        // 2. Coincidencias booleanas
        $campos_booleanos = [
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
            "oficinas_gubernamentales",
            "oficinas_servicios",
            "bancos",
            "areas_verdes",
            "seguro",
            "limpio",
            "en_desarrollo",
            "viviendas",
            "negocios",
            "bodegas",
            "galpones",
            "terrenos_baldios"
        ];

        foreach ($campos_booleanos as $campo) {
            if (isset($criterios[$campo])) {
                $valor = $criterios[$campo] ? 1 : 0;
                $query->where($campo, $valor);
            }
        }

        $resultados = $query->get();

        return response()->json([
            'success' => true,
            'total' => $resultados->count(),
            'data' => $resultados
        ]);
    }
}
