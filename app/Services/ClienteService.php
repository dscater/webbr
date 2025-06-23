<?php

namespace App\Services;

use App\Services\HistorialAccionService;
use App\Models\Cliente;
use App\Models\Preventa;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClienteService
{
    private $modulo = "CLIENTES";

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function listado(): Collection
    {
        $clientes = Cliente::select("clientes.*")->get();
        return $clientes;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $clientes = Cliente::select("clientes.*");
        if ($search && trim($search) != '') {
            $clientes->where("nombre", "LIKE", "%$search%");
        }
        $clientes = $clientes->paginate($length, ['*'], 'page', $page);
        return $clientes;
    }

    /**
     * Crear cliente
     *
     * @param array $datos
     * @return Cliente
     */
    public function crear(array $datos): Cliente
    {
        $cliente = Cliente::create([
            "nombre" => mb_strtoupper($datos["nombre"]),
            "paterno" => mb_strtoupper($datos["paterno"]),
            "materno" => mb_strtoupper($datos["materno"]),
            "ci" => $datos["ci"],
            "ci_exp" => $datos["ci_exp"],
            "fono" => mb_strtoupper($datos["fono"]),
            "correo" => $datos["correo"],
            "dir" => mb_strtoupper($datos["dir"]),
            "fecha_registro" => date("Y-m-d")
        ]);
        // registrar accion
        if (Auth::check()) {
            $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN CLIENTE", $cliente);
        }
        return $cliente;
    }

    /**
     * Actualizar cliente
     *
     * @param array $datos
     * @param Cliente $cliente
     * @return Cliente
     */
    public function actualizar(array $datos, Cliente $cliente): Cliente
    {
        $old_cliente = Cliente::find($cliente->id);
        $cliente->update([
            "nombre" => mb_strtoupper($datos["nombre"]),
            "paterno" => mb_strtoupper($datos["paterno"]),
            "materno" => mb_strtoupper($datos["materno"]),
            "ci" => $datos["ci"],
            "ci_exp" => $datos["ci_exp"],
            "fono" => mb_strtoupper($datos["fono"]),
            "correo" => $datos["correo"],
            "dir" => mb_strtoupper($datos["dir"]),
        ]);
        // registrar accion
        if (Auth::check()) {
            $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN CLIENTE", $old_cliente, $cliente);
        }
        return $cliente;
    }

    /**
     * Eliminar cliente
     *
     * @param Cliente $cliente
     * @return boolean
     */
    public function eliminar(Cliente $cliente): bool
    {
        // verificar usos
        $usos = Preventa::where("cliente_id", $cliente->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        $usos = Venta::where("cliente_id", $cliente->id)->get();
        if (count($usos) > 0) {
            throw ValidationException::withMessages([
                'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
            ]);
        }

        // no eliminar clientes predeterminados para el funcionamiento del sistema
        $old_cliente = Cliente::find($cliente->id);
        $cliente->delete();

        // registrar accion
        $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ UN CLIENTE", $old_cliente);

        return true;
    }
}
