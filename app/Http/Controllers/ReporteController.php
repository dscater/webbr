<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\HistorialOferta;
use App\Models\Publicacion;
use App\Models\PublicacionDetalle;
use App\Models\SubastaCliente;
use App\Models\Terreno;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PDF;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function usuarios()
    {
        return Inertia::render("Admin/Reportes/Usuarios");
    }

    public function r_usuarios(Request $request)
    {
        $tipo =  $request->tipo;
        $usuarios = User::select("users.*")
            ->where('id', '!=', 1);

        if ($tipo != 'todos') {
            $request->validate([
                'tipo' => 'required',
            ]);
            $usuarios->where('tipo', $tipo);
        }

        $usuarios = $usuarios->orderBy("paterno", "ASC")->get();

        $pdf = PDF::loadView('reportes.usuarios', compact('usuarios'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('usuarios.pdf');
    }
    public function clientes()
    {
        return Inertia::render("Admin/Reportes/Clientes");
    }

    public function r_clientes(Request $request)
    {
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;
        $clientes = Cliente::select("clientes.*");

        if ($fecha_ini && $fecha_fin) {
            $request->validate([
                'fecha_ini' => 'required',
                'fecha_fin' => 'required',
            ]);
            $clientes->whereBetween('fecha_registro', [$fecha_ini, $fecha_fin]);
        }

        $clientes = $clientes->get();

        $pdf = PDF::loadView('reportes.clientes', compact('clientes'))->setPaper('letter', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('clientes.pdf');
    }

    public function especificacion_terrenos()
    {
        return Inertia::render("Admin/Reportes/EspecificacionTerrenos");
    }

    public function r_especificacion_terrenos(Request $request)
    {
        $terreno_id =  $request->terreno_id;

        $terrenos = Terreno::select("terrenos.*");

        if ($terreno_id != 'todos') {
            $terrenos->where('id', $terreno_id);
        }

        $terrenos = $terrenos->where("status", 1)->get();

        $pdf = PDF::loadView('reportes.especificacion_terrenos', compact('terrenos'))->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('especificacion_terrenos.pdf');
    }
    public function terrenos()
    {
        return Inertia::render("Admin/Reportes/Terrenos");
    }

    public function r_terrenos(Request $request)
    {
        $fecha_ini =  $request->fecha_ini;
        $fecha_fin =  $request->fecha_fin;

        $terrenos = Terreno::select("terrenos.*");


        if ($fecha_ini && $fecha_fin) {
            $request->validate([
                'fecha_ini' => 'required',
                'fecha_fin' => 'required',
            ]);
            $terrenos->whereBetween('fecha_registro', [$fecha_ini, $fecha_fin]);
        }


        $terrenos = $terrenos->where("status", 1)->get();

        $pdf = PDF::loadView('reportes.terrenos', compact('terrenos'))->setPaper('legal', 'landscape');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('terrenos.pdf');
    }

    public function gingresos_economicos()
    {
        return Inertia::render("Admin/Reportes/GSubastaClientes");
    }

    public function r_gingresos_economicos(Request $request)
    {
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;


        $total_vendidos = Terreno::where("vendido", 1)
            ->join("ventas", "ventas.terreno_id", "=", "terrenos.id");
        if ($fecha_ini && $fecha_fin) {
            $total_vendidos->whereBetween("ventas.fecha_registro", [$fecha_ini, $fecha_fin]);
        }
        $total_vendidos = $total_vendidos->sum("terrenos.costo_contado");

        $total_preventas = Terreno::where("vendido", 0)
            ->join("preventas", "preventas.terreno_id", "=", "terrenos.id");

        if ($fecha_ini && $fecha_fin) {
            $total_preventas->whereBetween("preventas.fecha_registro", [$fecha_ini, $fecha_fin]);
        }

        $total_preventas = $total_preventas
            ->groupBy("terrenos.id")
            ->selectRaw("SUM(DISTINCT terrenos.costo_contado) as total") // <- suma sin duplicar
            ->pluck("total")
            ->sum(); // <- suma final si hay varios grupos

        $data = [
            ["PRE-VENTAS", (float)$total_preventas],
            [
                "VENTAS",
                (float)$total_vendidos
            ]
        ];

        return response()->JSON([
            "data" => $data
        ]);
    }

    public function gcantidadventas()
    {
        return Inertia::render("Admin/Reportes/GSubastaClientes");
    }

    public function r_gcantidadventas(Request $request)
    {
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;


        $total_vendidos = Terreno::where("vendido", 1)
            ->join("ventas", "ventas.terreno_id", "=", "terrenos.id");
        if ($fecha_ini && $fecha_fin) {
            $total_vendidos->whereBetween("ventas.fecha_registro", [$fecha_ini, $fecha_fin]);
        }
        $total_vendidos = $total_vendidos->count();

        $total_preventas = Terreno::join("preventas", "preventas.terreno_id", "=", "terrenos.id");

        if ($fecha_ini && $fecha_fin) {
            $total_preventas->whereBetween("preventas.fecha_registro", [$fecha_ini, $fecha_fin]);
        }

        $total_preventas = $total_preventas->count();

        $data = [
            ["PRE-VENTAS", (float)$total_preventas],
            [
                "VENTAS",
                (float)$total_vendidos
            ]
        ];

        return response()->JSON([
            "data" => $data
        ]);
    }
}
