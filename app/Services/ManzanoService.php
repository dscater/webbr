<?php

namespace App\Services;

use App\Models\IngresoProducto;
use App\Services\HistorialAccionService;
use App\Models\Manzano;
use App\Models\Terreno;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ManzanoService
{
    private $modulo = "MANZANOS";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $manzanos = Manzano::with(["municipio", "urbanizacion"])->select("manzanos.*")->get();
        return $manzanos;
    }

    public function listadoPorMunicipioUrbanizacion(int $municipio_id, int $urbanizacion_id): Collection
    {
        $manzanos = Manzano::with(["municipio", "urbanizacion"])->select("manzanos.*")
            ->where("municipio_id", $municipio_id)
            ->where("urbanizacion_id", $urbanizacion_id)
            ->get();
        return $manzanos;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $manzanos = Manzano::with(["municipio", "urbanizacion"])->select("manzanos.*");
        if ($search && trim($search) != '') {
            $manzanos->where("nombre", "LIKE", "%$search%");
        }
        $manzanos = $manzanos->paginate($length, ['*'], 'page', $page);
        return $manzanos;
    }

    /**
     * Crear manzano
     *
     * @param array $datos
     * @return Manzano
     */
    public function crear(array $datos): Manzano
    {

        $manzano = Manzano::create([
            "municipio_id" => $datos["municipio_id"],
            "urbanizacion_id" => $datos["urbanizacion_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN MANZANO", $manzano);

        return $manzano;
    }

    /**
     * Actualizar manzano
     *
     * @param array $datos
     * @param Manzano $manzano
     * @return Manzano
     */
    public function actualizar(array $datos, Manzano $manzano): Manzano
    {
        $old_manzano = Manzano::find($manzano->id);
        $manzano->update([
            "municipio_id" => $datos["municipio_id"],
            "urbanizacion_id" => $datos["urbanizacion_id"],
            "nombre" => mb_strtoupper($datos["nombre"]),
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN MANZANO", $old_manzano, $manzano);

        return $manzano;
    }

    /**
     * Eliminar manzano
     *
     * @param Manzano $manzano
     * @return boolean
     */
    public function eliminar(Manzano $manzano): bool
    {
        // verificar usos
        $usos = Terreno::where("manzano_id", $manzano->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        // no eliminar manzanos predeterminados para el funcionamiento del sistema
        $old_manzano = Manzano::find($manzano->id);
        $manzano->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UN MANZANO", $old_manzano);

        return true;
    }
}
