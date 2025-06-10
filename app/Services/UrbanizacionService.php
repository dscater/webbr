<?php

namespace App\Services;

use App\Models\IngresoProducto;
use App\Models\Manzano;
use App\Services\HistorialAccionService;
use App\Models\Urbanizacion;
use App\Models\Terreno;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UrbanizacionService
{
    private $modulo = "URBANIZACIÓN";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $urbanizacions = Urbanizacion::with(["municipio"])->select("urbanizacions.*")->get();
        return $urbanizacions;
    }

    public function listadoPorMunicipio(int $municipio_id): Collection
    {
        $urbanizacions = Urbanizacion::with(["municipio"])->select("urbanizacions.*")
            ->where("municipio_id", $municipio_id)->get();
        return $urbanizacions;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $urbanizacions = Urbanizacion::with(["municipio"])->select("urbanizacions.*");
        if ($search && trim($search) != '') {
            $urbanizacions->where("nombre", "LIKE", "%$search%");
        }
        $urbanizacions = $urbanizacions->paginate($length, ['*'], 'page', $page);
        return $urbanizacions;
    }

    /**
     * Crear urbanizacion
     *
     * @param array $datos
     * @return Urbanizacion
     */
    public function crear(array $datos): Urbanizacion
    {

        $urbanizacion = Urbanizacion::create([
            "municipio_id" => $datos["municipio_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UNA URBANIZACIÓN", $urbanizacion);

        return $urbanizacion;
    }

    /**
     * Actualizar urbanizacion
     *
     * @param array $datos
     * @param Urbanizacion $urbanizacion
     * @return Urbanizacion
     */
    public function actualizar(array $datos, Urbanizacion $urbanizacion): Urbanizacion
    {
        $old_urbanizacion = Urbanizacion::find($urbanizacion->id);
        $urbanizacion->update([
            "municipio_id" => $datos["municipio_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UNA URBANIZACIÓN", $old_urbanizacion, $urbanizacion);

        return $urbanizacion;
    }

    /**
     * Eliminar urbanizacion
     *
     * @param Urbanizacion $urbanizacion
     * @return boolean
     */
    public function eliminar(Urbanizacion $urbanizacion): bool
    {
        // verificar usos
        $usos = Manzano::where("urbanizacion_id", $urbanizacion->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $usos = Terreno::where("urbanizacion_id", $urbanizacion->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        // no eliminar urbanizacions predeterminados para el funcionamiento del sistema
        $old_urbanizacion = Urbanizacion::find($urbanizacion->id);
        $urbanizacion->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UNA URBANIZACIÓN", $old_urbanizacion);

        return true;
    }
}
