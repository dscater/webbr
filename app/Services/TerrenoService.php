<?php

namespace App\Services;

use App\Models\Preventa;
use App\Services\HistorialAccionService;
use App\Models\Terreno;
use App\Models\TerrenoImagen;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TerrenoService
{
    private $modulo = "TERRENOS";

    public function __construct(private HistorialAccionService $historialAccionService, private TerrenoImagenService $terrenoImagenService) {}

    public function listado(): Collection
    {
        $terrenos = Terreno::with(["municipio", "urbanizacion", "manzano", "imagens"])
            ->select("terrenos.*")
            ->where("status", 1)
            ->get();
        return $terrenos;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $terrenos = Terreno::with(["municipio", "urbanizacion", "manzano", "imagens"])->select("terrenos.*");
        if ($search && trim($search) != '') {
            $terrenos->where("nombre", "LIKE", "%$search%");
        }
        $terrenos->where("status", 1);

        $terrenos = $terrenos->paginate($length, ['*'], 'page', $page);
        return $terrenos;
    }

    /**
     * Crear terreno
     *
     * @param array $datos
     * @return Terreno
     */
    public function crear(array $datos): Terreno
    {

        $terreno = Terreno::create([
            "municipio_id" => $datos["municipio_id"],
            "urbanizacion_id" => $datos["urbanizacion_id"],
            "manzano_id" => $datos["manzano_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
            "tipo_calle" => $datos["tipo_calle"],
            "ancho_calle" => $datos["ancho_calle"],
            "conectividad" => $datos["conectividad"],
            "trafico" => $datos["trafico"],
            "tipo_zona" => $datos["tipo_zona"],
            "agua_potable" => $datos["agua_potable"],
            "alcantarillado" => $datos["alcantarillado"],
            "energia_electrica" => $datos["energia_electrica"],
            "gas_natural" => $datos["gas_natural"],
            "alumbrado" => $datos["alumbrado"],
            "recoleccion_basura" => $datos["recoleccion_basura"],
            "conexion_internet" => $datos["conexion_internet"],
            "escuelas" => $datos["escuelas"],
            "centros_educativos" => $datos["centros_educativos"],
            "hospitales" => $datos["hospitales"],
            "centros_salud" => $datos["centros_salud"],
            "centros_comerciales" => $datos["centros_comerciales"],
            "mercados" => $datos["mercados"],
            "tiendas" => $datos["tiendas"],
            "parques" => $datos["parques"],
            "plazas" => $datos["plazas"],
            "espacios_recreativos" => $datos["espacios_recreativos"],
            "iglesias" => $datos["iglesias"],
            "oficinas_gubarnamentales" => $datos["oficinas_gubarnamentales"],
            "oficinas_servicios" => $datos["oficinas_servicios"],
            "bancos" => $datos["bancos"],
            "areas_verdes" => $datos["areas_verdes"],
            "nivel_urbanizacion" => $datos["nivel_urbanizacion"],
            "seguro" => $datos["seguro"],
            "limpio" => $datos["limpio"],
            "en_desarrollo" => $datos["en_desarrollo"],
            "viviendas" => $datos["viviendas"],
            "negocios" => $datos["negocios"],
            "bodegas" => $datos["bodegas"],
            "galpones" => $datos["galpones"],
            "terrenos_baldios" => $datos["terrenos_baldios"],
            "topografia_entorno" => $datos["topografia_entorno"],
            "superficie_terreno" => $datos["superficie_terreno"],
            "costo_contado" => $datos["costo_contado"],
            "costo_credito" => $datos["costo_credito"],
            "publicar" => $datos["publicar"],
            "fecha_registro" => date("Y-m-d")
        ]);

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN TERRENO", $terreno);

        // registrar imagenes
        if (!empty($datos["imagens"])) {
            $datos_original = [];
            foreach ($datos["imagens"] as $key => $imagen) {
                if (!is_string($imagen["file"])) {
                    $datos_original[] =  $this->terrenoImagenService->guardarImagenTerreno($terreno, $imagen["file"], $key);
                }
            }

            // registrar imagens asignadas
            $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRÓ LAS IMAGENES DEL TERRENO " . $terreno->nombre, $terreno, null, ["imagens"]);
        }

        return $terreno;
    }

    /**
     * Actualizar terreno
     *
     * @param array $datos
     * @param Terreno $terreno
     * @return Terreno
     */
    public function actualizar(array $datos, Terreno $terreno): Terreno
    {
        $old_terreno = clone $terreno;
        $terreno->update([
            "municipio_id" => $datos["municipio_id"],
            "urbanizacion_id" => $datos["urbanizacion_id"],
            "manzano_id" => $datos["manzano_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
            "tipo_calle" => $datos["tipo_calle"],
            "ancho_calle" => $datos["ancho_calle"],
            "conectividad" => $datos["conectividad"],
            "trafico" => $datos["trafico"],
            "tipo_zona" => $datos["tipo_zona"],
            "agua_potable" => $datos["agua_potable"],
            "alcantarillado" => $datos["alcantarillado"],
            "energia_electrica" => $datos["energia_electrica"],
            "gas_natural" => $datos["gas_natural"],
            "alumbrado" => $datos["alumbrado"],
            "recoleccion_basura" => $datos["recoleccion_basura"],
            "conexion_internet" => $datos["conexion_internet"],
            "escuelas" => $datos["escuelas"],
            "centros_educativos" => $datos["centros_educativos"],
            "hospitales" => $datos["hospitales"],
            "centros_salud" => $datos["centros_salud"],
            "centros_comerciales" => $datos["centros_comerciales"],
            "mercados" => $datos["mercados"],
            "tiendas" => $datos["tiendas"],
            "parques" => $datos["parques"],
            "plazas" => $datos["plazas"],
            "espacios_recreativos" => $datos["espacios_recreativos"],
            "iglesias" => $datos["iglesias"],
            "oficinas_gubarnamentales" => $datos["oficinas_gubarnamentales"],
            "oficinas_servicios" => $datos["oficinas_servicios"],
            "bancos" => $datos["bancos"],
            "areas_verdes" => $datos["areas_verdes"],
            "nivel_urbanizacion" => $datos["nivel_urbanizacion"],
            "seguro" => $datos["seguro"],
            "limpio" => $datos["limpio"],
            "en_desarrollo" => $datos["en_desarrollo"],
            "viviendas" => $datos["viviendas"],
            "negocios" => $datos["negocios"],
            "bodegas" => $datos["bodegas"],
            "galpones" => $datos["galpones"],
            "terrenos_baldios" => $datos["terrenos_baldios"],
            "topografia_entorno" => $datos["topografia_entorno"],
            "superficie_terreno" => $datos["superficie_terreno"],
            "costo_contado" => $datos["costo_contado"],
            "costo_credito" => $datos["costo_credito"],
            "publicar" => $datos["publicar"],
        ]);

        // actualizar imagenes
        if (!empty($datos["imagens"])) {
            foreach ($datos["imagens"] as $key => $imagen) {
                if ($imagen["id"] == 0) {
                    $this->terrenoImagenService->guardarImagenTerreno($terreno, $imagen["file"], $key);
                }
            }
        }

        // imagenes eliminadas
        if (!empty($datos["eliminados"])) {
            foreach ($datos["eliminados"] as $key => $eliminado) {
                $terrenoImagen = TerrenoImagen::find($eliminado);
                if ($terrenoImagen) {
                    $this->terrenoImagenService->eliminarImagenTerreno($terrenoImagen);
                }
            }
        }

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN TERRENO", $terreno, $old_terreno, ["imagens"]);

        return $terreno;
    }

    /**
     * Eliminar terreno
     *
     * @param Terreno $terreno
     * @return boolean
     */
    public function eliminar(Terreno $terreno): bool
    {
        // verificar usos
        $usos = Preventa::where("terreno_id", $terreno->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }
        $usos = Venta::where("terreno_id", $terreno->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $old_terreno = clone $terreno;
        $terreno->status = 0;
        $terreno->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UN TERRENO", $terreno, $old_terreno, ["imagens"]);

        return true;
    }
}
