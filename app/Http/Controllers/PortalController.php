<?php

namespace App\Http\Controllers;

use App\Models\Terreno;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PortalController extends Controller
{
    public function index()
    {
        return Inertia::render("Portal/Inicio");
    }

    /**
     * Ver terreno portal
     *
     * @param Terreno $terreno
     * @return InertiaResponse
     */
    public function terreno(Terreno $terreno): InertiaResponse
    {
        $terreno = $terreno->load(["imagens", "municipio", "urbanizacion", "manzano"]);
        return Inertia::render("Portal/Terreno", compact("terreno"));
    }
}
