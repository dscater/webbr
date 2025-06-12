<?php

namespace App\Http\Controllers;

use App\Http\Requests\TerrenoStoreRequest;
use App\Http\Requests\TerrenoUpdateRequest;
use App\Models\Terreno;
use App\Services\TerrenoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TerrenoController extends Controller
{
    public function __construct(private TerrenoService $terrenoService) {}

    /**
     * Página index
     *
     * @return Response
     */
    public function index(): InertiaResponse
    {
        return Inertia::render("Admin/Terrenos/Index");
    }

    /**
     * Listado de terrenos
     *
     * @return JsonResponse
     */
    public function listado(): JsonResponse
    {
        return response()->JSON([
            "terrenos" => $this->terrenoService->listado()
        ]);
    }

    /**
     * Listado de terrenos para portal
     *
     * @return JsonResponse
     */
    public function listadoPaginado(Request $request): JsonResponse
    {
        $perPage = $request->perPage;
        $page = (int)($request->input("page", 1));
        $search = (string)$request->input("search", "");
        $precioDesde = $request->precioDesde;
        $precioHasta = $request->precioHasta;
        $categoria_id = $request->categoria_id;
        $orderByCol = $request->orderByCol;
        $desc = $request->desc;

        $columnsSerachLike = ["nombre"];
        $columnsFilter = [
            "publicar" => "SI",
            "vendido" =>  0,
        ];
        $columnsBetweenFilter = [
            "costo_contado" => [$precioDesde, $precioHasta]
        ];

        $arrayOrderBy = [];
        if ($orderByCol && $desc) {
            $arrayOrderBy = [
                [$orderByCol, $desc]
            ];
        }

        $terrenos = $this->terrenoService->listadoPaginado($perPage, $page, $search, $columnsSerachLike, $columnsFilter, $columnsBetweenFilter, $arrayOrderBy);
        return response()->JSON([
            "total" => $terrenos->total(),
            "terrenos" => $terrenos->items(),
            "lastPage" => $terrenos->lastPage()
        ]);
    }

    /**
     * Endpoint para obtener la lista de terrenos paginado para datatable
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

        $usuarios = $this->terrenoService->listadoDataTable($length, $start, $page, $search);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    /**
     * Registrar un nuevo terreno
     *
     * @param TerrenoStoreRequest $request
     * @return RedirectResponse|Response
     */
    public function store(TerrenoStoreRequest $request): RedirectResponse|Response
    {
        DB::beginTransaction();
        try {
            // crear el Terreno
            $this->terrenoService->crear($request->validated());
            DB::commit();
            return redirect()->route("terrenos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Mostrar un terreno
     *
     * @param Terreno $terreno
     * @return JsonResponse
     */
    public function show(Terreno $terreno): JsonResponse
    {
        return response()->JSON($terreno->load(["municipio", "urbanizacion", "manzano", "imagens"]));
    }

    public function update(Terreno $terreno, TerrenoUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // actualizar terreno
            $this->terrenoService->actualizar($request->validated(), $terreno);
            DB::commit();
            return redirect()->route("terrenos.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    /**
     * Eliminar terreno
     *
     * @param Terreno $terreno
     * @return JsonResponse|Response
     */
    public function destroy(Terreno $terreno): JsonResponse|Response
    {
        DB::beginTransaction();
        try {
            $this->terrenoService->eliminar($terreno);
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
