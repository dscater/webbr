<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrbanizacionStoreRequest;
use App\Http\Requests\UrbanizacionUpdateRequest;
use App\Models\Urbanizacion;
use App\Services\UrbanizacionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class UrbanizacionController extends Controller
{
    public function __construct(private UrbanizacionService $urbanizacionService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Urbanizacions/Index");
    }

    /**
     * Listado de urbanizacions
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "urbanizacions" => $this->urbanizacionService->listado()
        ]);
    }

    /**
     * Listado de urbanizacions
     *
     * @return JsonResponse
     */
    public function listadoPorMunicipio(Request $request): JsonResponse
    {
        return response()->JSON([
            "urbanizacions" => $this->urbanizacionService->listadoPorMunicipio($request->id ?? 0)
        ]);
    }

    /**
     * Listado de urbanizacions para portal
     *
     * @return JsonResponse
     */
    public function listadoPortal(): JsonResponse
    {
        return response()->JSON([
            "urbanizacions" => $this->urbanizacionService->listado()
        ]);
    }

    /**
     * Endpoint para obtener la lista de urbanizacions paginado para datatable
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

        $usuarios = $this->urbanizacionService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo urbanizacion
     *
     * @param UrbanizacionStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(UrbanizacionStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Urbanizacion
            $this->urbanizacionService->crear($request->validated());
            DB::commit();
            return redirect()->route("urbanizacions.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un urbanizacion
     *
     * @param Urbanizacion $urbanizacion
     * @return JsonResponse
     */
    public function show(Urbanizacion $urbanizacion): JsonResponse
    {
        return response()->JSON($urbanizacion);
    }

    public function update(Urbanizacion $urbanizacion, UrbanizacionUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar urbanizacion
            $this->urbanizacionService->actualizar($request->validated(), $urbanizacion);
            DB::commit();
            return redirect()->route("urbanizacions.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar urbanizacion
     *
     * @param Urbanizacion $urbanizacion
     * @return JsonResponse|Response
     */
    public function destroy(Urbanizacion $urbanizacion): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->urbanizacionService->eliminar($urbanizacion);
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
