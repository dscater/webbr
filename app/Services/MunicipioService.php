<?php

namespace App\Services;

use App\Models\IngresoProducto;
use App\Models\Manzano;
use App\Services\HistorialAccionService;
use App\Models\Municipio;
use App\Models\Terreno;
use App\Models\Urbanizacion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MunicipioService
{
    private $modulo = "MUNICIPIOS";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $municipios = Municipio::select("municipios.*")->get();
        return $municipios;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $municipios = Municipio::select("municipios.*");
        if ($search && trim($search) != '') {
            $municipios->where("nombre", "LIKE", "%$search%");
        }
        $municipios = $municipios->paginate($length, ['*'], 'page', $page);
        return $municipios;
    }

    /**
     * Crear municipio
     *
     * @param array $datos
     * @return Municipio
     */
    public function crear(array $datos): Municipio
    {

        $municipio = Municipio::create([
            "nombre" => mb_strtoupper($datos["nombre"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN MUNICIPIO", $municipio);

        return $municipio;
    }

    /**
     * Actualizar municipio
     *
     * @param array $datos
     * @param Municipio $municipio
     * @return Municipio
     */
    public function actualizar(array $datos, Municipio $municipio): Municipio
    {
        $old_municipio = Municipio::find($municipio->id);
        $municipio->update([
            "nombre" => mb_strtoupper($datos["nombre"]),
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN MUNICIPIO", $old_municipio, $municipio);

        return $municipio;
    }

    /**
     * Eliminar municipio
     *
     * @param Municipio $municipio
     * @return boolean
     */
    public function eliminar(Municipio $municipio): bool
    {
        // verificar usos
        $usos = Urbanizacion::where("municipio_id", $municipio->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $usos = Manzano::where("municipio_id", $municipio->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $usos = Terreno::where("municipio_id", $municipio->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        // no eliminar municipios predeterminados para el funcionamiento del sistema
        $old_municipio = Municipio::find($municipio->id);
        $municipio->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UN MUNICIPIO", $old_municipio);

        return true;
    }
}
