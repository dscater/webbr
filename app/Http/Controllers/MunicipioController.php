<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipioStoreRequest;
use App\Http\Requests\MunicipioUpdateRequest;
use App\Models\Municipio;
use App\Services\MunicipioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class MunicipioController extends Controller
{
    public function __construct(private MunicipioService $municipioService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Municipios/Index");
    }

    /**
     * Listado de municipios
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "municipios" => $this->municipioService->listado()
        ]);
    }

    /**
     * Listado de municipios para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "municipios" => $this->municipioService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de municipios paginado para datatable
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

        $usuarios = $this->municipioService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo municipio
     *
     * @param MunicipioStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(MunicipioStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Municipio
            $this->municipioService->crear($request->validated());
            DB::commit();
            return redirect()->route("municipios.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un municipio
     *
     * @param Municipio $municipio
     * @return JsonResponse
     */
    public function show(Municipio $municipio): JsonResponse
    {
        return response()->JSON($municipio);
    }

    public function update(Municipio $municipio, MunicipioUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar municipio
            $this->municipioService->actualizar($request->validated(), $municipio);
            DB::commit();
            return redirect()->route("municipios.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar municipio
     *
     * @param Municipio $municipio
     * @return JsonResponse|Response
     */
    public function destroy(Municipio $municipio): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->municipioService->eliminar($municipio);
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
