<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaStoreRequest;
use App\Http\Requests\VentaUpdateRequest;
use App\Models\Venta;
use App\Services\VentaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class VentaController extends Controller
{
    public function __construct(private VentaService $ventaService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Ventas/Index");
    }

    /**
     * Listado de ventas
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "ventas" => $this->ventaService->listado()
        ]);
    }

    /**
     * Listado de ventas para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "ventas" => $this->ventaService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de ventas paginado para datatable
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {

        $length = (int)$request->input('length', 10); // Valor de `length` enviado por DataTable
        $start = (int)$request->input('start', 0); // Índice de inicio enviado por DataTable
        $page = (int)(($start / $length) + 1); // Cálculo de la página actual
        $search = (string)$request->input('search', '');

        $usuarios = $this->ventaService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo venta
     *
     * @param VentaStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(VentaStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Venta
            $this->ventaService->crear($request->validated());
            DB::commit();
            return redirect()->route("ventas.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un venta
     *
     * @param Venta $venta
     * @return JsonResponse
     */
    public function show(Venta $venta): JsonResponse
    {
        return response()->JSON($venta);
    }

    public function update(Venta $venta, VentaUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar venta
            $this->ventaService->actualizar($request->validated(), $venta);
            DB::commit();
            return redirect()->route("ventas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar venta
     *
     * @param Venta $venta
     * @return JsonResponse|Response
     */
    public function destroy(Venta $venta): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->ventaService->eliminar($venta);
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'message' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
}
