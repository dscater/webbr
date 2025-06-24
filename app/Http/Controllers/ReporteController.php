<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\HistorialOferta;
use App\Models\Publicacion;
use App\Models\PublicacionDetalle;
use App\Models\SubastaCliente;
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

    public function g_subasta_clientes()
    {
        return Inertia::render("Admin/Reportes/GSubastaClientes");
    }

    public function gr_subasta_clientes(Request $request)
    {
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        $categoria = $request->categoria;

        $publicacions = Publicacion::select("publicacions.*")
            ->whereIn("estado_sub", [1, 2, 3, 4]);

        if ($categoria != 'todos') {
            $publicacions->where("publicacions.categoria", $categoria);
        }

        $permisos = Auth::user()->permisos;
        if (is_array($permisos) && !in_array("publicacions.todos", $permisos)) {
            $publicacions->where("user_id", Auth::user()->id);
        }

        $publicacions->whereNotIn("estado_sub", [5]);
        $publicacions = $publicacions->get();
        $data = [];
        foreach ($publicacions as $publicacion) {
            $total = 0;
            if ($publicacion->subasta) {
                $total = SubastaCliente::select("subasta_clientes.*")
                    ->join("historial_ofertas", "historial_ofertas.subasta_cliente_id", "=", "subasta_clientes.id")
                    ->where("subasta_clientes.subasta_id", $publicacion->subasta->id);
                if ($fecha_ini && $fecha_fin) {
                    $total->whereBetween("historial_ofertas.fecha_oferta", [$fecha_ini, $fecha_fin]);
                }
                $total = $total->distinct("subasta_clientes.cliente_id")->count();
            }

            $data[] = [
                "y" => (int)$total,
                "name" => "PUBLICACIÓN NRO. " . $publicacion->nro . " | " . $publicacion->categoria,
                "nro_pub" => $publicacion->nro
            ];
        }

        return response()->JSON([
            "data" => $data
        ]);
    }

    public function g_puja_clientes()
    {
        return Inertia::render("Admin/Reportes/GPujaClientes");
    }

    public function prueba()
    {
        $pdf = PDF::loadView('reportes.venta')->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('venta.pdf');
    }

    public function prueba2()
    {
        $pdf = PDF::loadView('reportes.venta2')->setPaper('letter', 'portrait');

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 90, $alto - 25, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, array(0, 0, 0));

        return $pdf->stream('venta.pdf');
    }
}
