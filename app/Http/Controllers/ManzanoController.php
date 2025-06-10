<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManzanoStoreRequest;
use App\Http\Requests\ManzanoUpdateRequest;
use App\Models\Manzano;
use App\Services\ManzanoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ManzanoController extends Controller
{
    public function __construct(private ManzanoService $manzanoService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Manzanos/Index");
    }

    /**
     * Listado de manzanos
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "manzanos" => $this->manzanoService->listado()
        ]);
    }

    public function listadoPorMunicipioUrbanizacion(Request $request): JsonResponse
    {
        return response()->JSON([
            "manzanos" => $this->manzanoService->listadoPorMunicipioUrbanizacion($request->municipio_id ?? 0, $request->urbanizacion_id ?? 0)
        ]);
    }

    /**
     * Listado de manzanos para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "manzanos" => $this->manzanoService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de manzanos paginado para datatable
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

        $usuarios = $this->manzanoService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo manzano
     *
     * @param ManzanoStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(ManzanoStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Manzano
            $this->manzanoService->crear($request->validated());
            DB::commit();
            return redirect()->route("manzanos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un manzano
     *
     * @param Manzano $manzano
     * @return JsonResponse
     */
    public function show(Manzano $manzano): JsonResponse
    {
        return response()->JSON($manzano);
    }

    public function update(Manzano $manzano, ManzanoUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar manzano
            $this->manzanoService->actualizar($request->validated(), $manzano);
            DB::commit();
            return redirect()->route("manzanos.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar manzano
     *
     * @param Manzano $manzano
     * @return JsonResponse|Response
     */
    public function destroy(Manzano $manzano): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->manzanoService->eliminar($manzano);
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
