<?php

namespace App\Services;

use App\Models\IngresoProducto;
use App\Models\Preventa;
use App\Services\HistorialAccionService;
use App\Models\Terreno;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TerrenoService
{
    private $modulo = "TERRENOS";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $terrenos = Terreno::with(["municipio", "urbanizacion", "manzano"])->select("terrenos.*")->get();
        return $terrenos;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $terrenos = Terreno::with(["municipio", "urbanizacion", "manzano"])->select("terrenos.*");
        if ($search && trim($search) != '') {
            $terrenos->where("nombre", "LIKE", "%$search%");
        }
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
            "nombre" => mb_strtoupper($datos["nombre"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN TERRENO", $terreno);

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
        $old_terreno = Terreno::find($terreno->id);
        $terreno->update([
            "municipio_id" => $datos["municipio_id"],
            "urbanizacion_id" => $datos["urbanizacion_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN TERRENO", $old_terreno, $terreno);

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

        // no eliminar terrenos predeterminados para el funcionamiento del sistema
        $old_terreno = Terreno::find($terreno->id);
        $terreno->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UN TERRENO", $old_terreno);

        return true;
    }
}
