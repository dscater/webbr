<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Manzano;
use App\Models\Municipio;
use App\Models\Preventa;
use App\Models\Publicacion;
use App\Models\Terreno;
use App\Models\Urbanizacion;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function permisosUsuario(Request $request)
    {
        return response()->JSON([
            "permisos" => Auth::user()->permisos
        ]);
    }

    public function getUser()
    {
        return response()->JSON([
            "user" => Auth::user()
        ]);
    }

    public static function getInfoBoxUser()
    {
        $permisos = [];
        $array_infos = [];
        if (Auth::check()) {
            $oUser = new User();
            $permisos = $oUser->permisos;
            if ($permisos == '*' || (is_array($permisos) && in_array('usuarios.index', $permisos))) {
                $array_infos[] = [
                    'label' => 'USUARIOS',
                    'cantidad' => User::where('id', '!=', 1)->count(),
                    'color' => 'bg-principal',
                    'icon' => "fa-users",
                    "url" => "usuarios.index"
                ];
            }

            if (in_array('municipios.index', $permisos)) {
                $municipios = Municipio::count();
                $array_infos[] = [
                    'label' => 'MUNICIPIOS',
                    'cantidad' => $municipios,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "municipios.index"
                ];
            }

            if (in_array('urbanizacions.index', $permisos)) {
                $urbanizacions = Urbanizacion::count();
                $array_infos[] = [
                    'label' => 'URBANIZACIÓN',
                    'cantidad' => $urbanizacions,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "urbanizacions.index"
                ];
            }

            if (in_array('manzanos.index', $permisos)) {
                $manzanos = Manzano::count();
                $array_infos[] = [
                    'label' => 'MUNICIPIOS',
                    'cantidad' => $manzanos,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "manzanos.index"
                ];
            }

            if (in_array('terrenos.index', $permisos)) {
                $terrenos = Terreno::count();
                $array_infos[] = [
                    'label' => 'TERRENOS',
                    'cantidad' => $terrenos,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "terrenos.index"
                ];
            }

            if (in_array('clientes.index', $permisos)) {
                $clientes = Cliente::count();
                $array_infos[] = [
                    'label' => 'CLIENTES',
                    'cantidad' => $clientes,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "clientes.index"
                ];
            }

            if (in_array('preventas.index', $permisos)) {
                $preventas = Preventa::count();
                $array_infos[] = [
                    'label' => 'PRE-VENTAS',
                    'cantidad' => $preventas,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "preventas.index"
                ];
            }

            if (in_array('ventas.index', $permisos)) {
                $ventas = Venta::where("status", 1)->count();
                $array_infos[] = [
                    'label' => 'VENTAS',
                    'cantidad' => $ventas,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "ventas.index"
                ];
            }
        }


        return $array_infos;
    }
}
