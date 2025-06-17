<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreventaStoreRequest;
use App\Http\Requests\PreventaUpdateRequest;
use App\Models\Preventa;
use App\Services\PreventaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PreventaController extends Controller
{
    public function __construct(private PreventaService $preventaService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Preventas/Index");
    }

    /**
     * Listado de preventas
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "preventas" => $this->preventaService->listado()
        ]);
    }

    /**
     * Listado de preventas para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "preventas" => $this->preventaService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de preventas paginado para datatable
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

        $usuarios = $this->preventaService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo preventa
     *
     * @param PreventaStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(PreventaStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Preventa
            $this->preventaService->crear($request->validated());
            DB::commit();
            return redirect()->route("preventas.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un preventa
     *
     * @param Preventa $preventa
     * @return JsonResponse
     */
    public function show(Preventa $preventa): JsonResponse
    {
        return response()->JSON($preventa);
    }

    public function update(Preventa $preventa, PreventaUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar preventa
            $this->preventaService->actualizar($request->validated(), $preventa);
            DB::commit();
            return redirect()->route("preventas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar preventa
     *
     * @param Preventa $preventa
     * @return JsonResponse|Response
     */
    public function destroy(Preventa $preventa): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->preventaService->eliminar($preventa);
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
