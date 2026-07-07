<?php

namespace App\Services;

use App\Models\Preventa;
use App\Models\Terreno;
use App\Services\HistorialAccionService;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class VentaService
{
    private $modulo = "VENTAS";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $ventas = Venta::with(["terreno", "cliente"])->select("ventas.*")->where("status", 1)->get();
        return $ventas;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $ventas = Venta::with(["terreno", "cliente"])->select("ventas.*");
        if ($search && trim($search) != '') {
            $ventas->where("nombre", "LIKE", "%$search%");
        }
        $ventas = $ventas->where("status", 1)->paginate($length, ['*'], 'page', $page);
        return $ventas;
    }

    /**
     * Crear venta
     *
     * @param array $datos
     * @return Venta
     */
    public function crear(array $datos): Venta
    {
        $sw_preventa  = $datos["sw_preventa"];

        if ($sw_preventa == 1) {
            $preventa = Preventa::findOrFail($datos["preventa_id"]);
        } else {
            $existe = Preventa::where("cliente_id", $datos["cliente_id"])
                ->where("terreno_id", $datos["terreno_id"])
                ->where("estado", "PRE-VENTA")->first();
            if (!$existe) {
                $preventa = Preventa::create([
                    "terreno_id" => $datos["terreno_id"],
                    "cliente_id" => $datos["cliente_id"],
                    "estado" => "PRE-VENTA",
                    "descripcion" => mb_strtoupper($datos["descripcion"]),
                    "fecha_registro" => date("Y-m-d")
                ]);
            } else {
                $preventa = $existe;
            }
        }

        $venta = Venta::create([
            "terreno_id" => $datos["terreno_id"],
            "preventa_id" => $preventa->id,
            "cliente_id" => $preventa->cliente->id,
            "descripcion" => mb_strtoupper($datos["descripcion"]),
            "fecha_registro" => date("Y-m-d")
        ]);

        //actualizar terreno
        $terreno = Terreno::findOrFail($datos["terreno_id"]);
        $terreno->vendido = 1;
        $terreno->save();

        //actualizar preventa
        $preventa->estado = 'VENDIDO';
        $preventa->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UNA VENTA", $venta);

        return $venta;
    }

    /**
     * Actualizar venta
     *
     * @param array $datos
     * @param Venta $venta
     * @return Venta
     */
    public function actualizar(array $datos, Venta $venta): Venta
    {

        $old_venta = clone $venta;
        $old_preventa_id = $old_venta->preventa_id;
        $old_terreno_id = $old_venta->terreno_id;

        //restablecer valores
        $oldPreventa = Preventa::findOrFail($old_preventa_id);
        $oldPreventa->estado = 'PRE-VENTA';
        $oldPreventa->save();
        $oldTerreno = Terreno::findOrFail($old_terreno_id);
        $oldTerreno->vendido = 0;
        $oldTerreno->save();

        $sw_preventa  = $datos["sw_preventa"];
        if ($sw_preventa == 1) {
            $preventa = Preventa::findOrFail($datos["preventa_id"]);
        } else {
            $existe = Preventa::where("cliente_id", $datos["cliente_id"])
                ->where("terreno_id", $datos["terreno_id"])
                ->where("estado", "PRE-VENTA")
                ->first();
            if (!$existe) {
                $preventa = Preventa::create([
                    "terreno_id" => $datos["terreno_id"],
                    "cliente_id" => $datos["cliente_id"],
                    "estado" => "PRE-VENTA",
                    "descripcion" => mb_strtoupper($datos["descripcion"]),
                    "fecha_registro" => date("Y-m-d")
                ]);
            } else {
                $preventa = $existe;
            }
        }

        $venta->update([
            "terreno_id" => $datos["terreno_id"],
            "preventa_id" => $preventa->id,
            "cliente_id" => $preventa->cliente->id,
            "descripcion" => mb_strtoupper($datos["descripcion"]),
        ]);

        //actualizar terreno
        $terreno = Terreno::findOrFail($datos["terreno_id"]);
        $terreno->vendido = 1;
        $terreno->save();

        //actualizar preventa
        $preventa->estado = 'VENDIDO';
        $preventa->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UNA VENTA", $old_venta, $venta);

        return $venta;
    }

    /**
     * Eliminar venta
     *
     * @param Venta $venta
     * @return boolean
     */
    public function eliminar(Venta $venta): bool
    {
        // // verificar usos
        // $usos = Venta::where("venta_id", $venta->id)->get();
        // if (count($usos) > 0) {
        //     throw ValidationException::withMessages([
        //         'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
        //     ]);
        // }

        if ($venta->estado == 'VENDIDO') {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado",
            ]);
        }

        // no eliminar ventas predeterminados para el funcionamiento del sistema

        $old_venta = clone $venta;
        $old_preventa_id = $old_venta->preventa_id;
        $old_terreno_id = $old_venta->terreno_id;

        //restablecer valores
        $oldPreventa = Preventa::findOrFail($old_preventa_id);
        $oldPreventa->estado = 'PRE-VENTA';
        $oldPreventa->save();
        $oldTerreno = Terreno::findOrFail($old_terreno_id);
        $oldTerreno->vendido = 0;
        $oldTerreno->save();

        $venta->status = 0;
        $venta->save();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UNA VENTA", $old_venta);

        return true;
    }
}
