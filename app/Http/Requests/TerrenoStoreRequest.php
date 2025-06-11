<?php

namespace App\Http\Requests;

use App\Rules\TerrenoImagensRule;
use Illuminate\Foundation\Http\FormRequest;

class TerrenoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "municipio_id" => "required",
            "urbanizacion_id" => "required",
            "manzano_id" => "required",
            "nombre" => "required",
            "tipo_calle" => "required",
            "ancho_calle" => "required",
            "conectividad" => "required",
            "trafico" => "required",
            "tipo_zona" => "required",
            "agua_potable" => "required",
            "alcantarillado" => "required",
            "energia_electrica" => "required",
            "gas_natural" => "required",
            "alumbrado" => "required",
            "recoleccion_basura" => "required",
            "conexion_internet" => "required",
            "escuelas" => "required",
            "centros_educativos" => "required",
            "hospitales" => "required",
            "centros_salud" => "required",
            "centros_comerciales" => "required",
            "mercados" => "required",
            "tiendas" => "required",
            "parques" => "required",
            "plazas" => "required",
            "espacios_recreativos" => "required",
            "iglesias" => "required",
            "oficinas_gubarnamentales" => "required",
            "oficinas_servicios" => "required",
            "bancos" => "required",
            "areas_verdes" => "required",
            "nivel_urbanizacion" => "required",
            "seguro" => "required",
            "limpio" => "required",
            "en_desarrollo" => "required",
            "viviendas" => "required",
            "negocios" => "required",
            "bodegas" => "required",
            "galpones" => "required",
            "terrenos_baldios" => "required",
            "topografia_entorno" => "required",
            "superficie_terreno" => "required",
            "costo_contado" => "required",
            "costo_credito" => "required",
            "publicar" => "required",
            "imagens" => ["required", new TerrenoImagensRule]
        ];
    }

    public function messages(): array
    {
        return [
            "municipio_id.required" => "Debes completar este campo",
            "urbanizacion_id.required" => "Debes completar este campo",
            "manzano_id.required" => "Debes completar este campo",
            "nombre.required" => "Debes completar este campo",
            "tipo_calle.required" => "Debes completar este campo",
            "ancho_calle.required" => "Debes completar este campo",
            "conectividad.required" => "Debes completar este campo",
            "trafico.required" => "Debes completar este campo",
            "tipo_zona.required" => "Debes completar este campo",
            "agua_potable.required" => "Debes completar este campo",
            "alcantarillado.required" => "Debes completar este campo",
            "energia_electrica.required" => "Debes completar este campo",
            "gas_natural.required" => "Debes completar este campo",
            "alumbrado.required" => "Debes completar este campo",
            "recoleccion_basura.required" => "Debes completar este campo",
            "conexion_internet.required" => "Debes completar este campo",
            "escuelas.required" => "Debes completar este campo",
            "centros_educativos.required" => "Debes completar este campo",
            "hospitales.required" => "Debes completar este campo",
            "centros_salud.required" => "Debes completar este campo",
            "centros_comerciales.required" => "Debes completar este campo",
            "mercados.required" => "Debes completar este campo",
            "tiendas.required" => "Debes completar este campo",
            "parques.required" => "Debes completar este campo",
            "plazas.required" => "Debes completar este campo",
            "espacios_recreativos.required" => "Debes completar este campo",
            "iglesias.required" => "Debes completar este campo",
            "oficinas_gubarnamentales.required" => "Debes completar este campo",
            "oficinas_servicios.required" => "Debes completar este campo",
            "bancos.required" => "Debes completar este campo",
            "areas_verdes.required" => "Debes completar este campo",
            "nivel_urbanizacion.required" => "Debes completar este campo",
            "seguro.required" => "Debes completar este campo",
            "limpio.required" => "Debes completar este campo",
            "en_desarrollo.required" => "Debes completar este campo",
            "viviendas.required" => "Debes completar este campo",
            "negocios.required" => "Debes completar este campo",
            "bodegas.required" => "Debes completar este campo",
            "galpones.required" => "Debes completar este campo",
            "terrenos_baldios.required" => "Debes completar este campo",
            "topografia_entorno.required" => "Debes completar este campo",
            "superficie_terreno.required" => "Debes completar este campo",
            "costo_contado.required" => "Debes completar este campo",
            "costo_credito.required" => "Debes completar este campo",
            "publicar.required" => "Debes completar este campo",
            "imagens.required" => "Debes agregar al menos 1 imagen"
        ];
    }
}
