<?php

namespace App\Services;

use App\Models\Cliente;
use App\Services\HistorialAccionService;
use App\Models\Preventa;
use App\Models\Terreno;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PreventaService
{
    private $modulo = "PRE-VENTAS";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $preventas = Preventa::with(["terreno", "cliente"])->select("preventas.*")->get();
        return $preventas;
    }

    public function listadoPorTerreno(int $terreno_id): Collection
    {
        $preventas = Preventa::with(["terreno", "cliente"])->select("preventas.*")->where("terreno_id", $terreno_id)->get();
        return $preventas;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $preventas = Preventa::with(["terreno", "cliente"])->select("preventas.*");
        if ($search && trim($search) != '') {
            $preventas->where("nombre", "LIKE", "%$search%");
        }
        $preventas = $preventas->paginate($length, ['*'], 'page', $page);
        return $preventas;
    }

    /**
     * Crear preventa
     *
     * @param array $datos
     * @return Preventa
     */
    public function crear(array $datos): Preventa
    {
        $preventa = Preventa::create([
            "terreno_id" => $datos["terreno_id"],
            "cliente_id" => $datos["cliente_id"],
            "descripcion" => mb_strtoupper($datos["descripcion"]),
            "estado" => "PRE-VENTA",
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UNA PRE-VENTA", $preventa);

        return $preventa;
    }

    /**
     * Crear preventa del portal
     *
     * @param array $datos
     * @return Preventa
     */
    public function crearPorPortal(array $datos, Terreno $terreno, Cliente $cliente): Preventa
    {
        //verificar pre-venta del cliente
        $existe = Preventa::where("cliente_id", $cliente->id)->where("terreno_id", $terreno->id)->get()->first();
        if ($existe) {
            throw new Exception("Ya tiene registrada la pre-venta de este terreno");
        }

        $preventa = Preventa::create([
            "terreno_id" => $terreno->id,
            "cliente_id" => $cliente->id,
            "descripcion" => "PRE-VENTA DEL TERRENO " . $terreno->nombre . " POR EL CLIENTE " . $cliente->full_name,
            "estado" => "PRE-VENTA",
            "fecha_registro" => date("Y-m-d")
        ]);

        return $preventa;
    }


    /**
     * Actualizar preventa
     *
     * @param array $datos
     * @param Preventa $preventa
     * @return Preventa
     */
    public function actualizar(array $datos, Preventa $preventa): Preventa
    {
        $old_preventa = Preventa::find($preventa->id);
        $preventa->update([
            "terreno_id" => $datos["terreno_id"],
            "cliente_id" => $datos["cliente_id"],
            "descripcion" => mb_strtoupper($datos["descripcion"]),
            // "estado" => $datos["estado"],
        ]);
        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UNA PRE-VENTA", $old_preventa, $preventa);

        return $preventa;
    }

    /**
     * Eliminar preventa
     *
     * @param Preventa $preventa
     * @return boolean
     */
    public function eliminar(Preventa $preventa): bool
    {
        // // verificar usos
        // $usos = Venta::where("preventa_id", $preventa->id)->get();
        // if (count($usos) > 0) {
        //     throw ValidationException::withMessages([
        //         'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
        //     ]);
        // }

        if ($preventa->estado == 'VENDIDO') {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado",
            ]);
        }

        // no eliminar preventas predeterminados para el funcionamiento del sistema
        $old_preventa = Preventa::find($preventa->id);
        $preventa->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UNA PRE-VENTA", $old_preventa);

        return true;
    }
}
