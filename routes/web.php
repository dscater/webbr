<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ManzanoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PreventaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TerrenoController;
use App\Http\Controllers\UrbanizacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PortalController::class, 'index'])->name("portal.index");

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('optimize');
    return 'Cache eliminado <a href="/">Ir al inicio</a>';
})->name('clear.cache');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Login');
})->name("login");

Route::post('/registro/validaForm1', [RegisteredUserController::class, 'validaForm1'])->name("registro.validaForm1");
Route::get('/registro', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Register');
})->name("registro");

Route::get("configuracions/getConfiguracion", [ConfiguracionController::class, 'getConfiguracion'])->name("configuracions.getConfiguracion");

// PORTAL
Route::get("urbanizacions/listadoPorMunicipio", [UrbanizacionController::class, 'listadoPorMunicipio'])->name("urbanizacions.listadoPorMunicipio");
Route::get("manzanos/listadoPorMunicipioUrbanizacion", [ManzanoController::class, 'listadoPorMunicipioUrbanizacion'])->name("manzanos.listadoPorMunicipioUrbanizacion");
Route::get("terrenos/listadoPaginado", [TerrenoController::class, 'listadoPaginado'])->name("terrenos.listadoPaginado");
Route::get("terrenos/verProducto/{terreno}", [PortalController::class, 'terreno'])->name("portal.terreno");
Route::post("preventas/registrarPreventaPortal/{terreno}", [PreventaController::class, 'registrarPreventaPortal'])->name("preventas.registrarPreventaPortal");
Route::get("clientes/buscarPorCi", [ClienteController::class, 'buscarPorCi'])->name("clientes.buscarPorCi");

Route::get("municipios/listado", [MunicipioController::class, 'listado'])->name("municipios.listado");
Route::get("urbanizacions/listado", [UrbanizacionController::class, 'listado'])->name("urbanizacions.listado");
Route::get("manzanos/listado", [ManzanoController::class, 'listado'])->name("manzanos.listado");
Route::get("busqueda", [TerrenoController::class, 'busqueda'])->name("terrenos.busqueda");


// ADMINISTRACION
Route::middleware(['auth', 'permisoUsuario'])->prefix("admin")->group(function () {
    // INICIO
    Route::get('/inicio', [InicioController::class, 'inicio'])->name('inicio');

    // CONFIGURACION
    Route::resource("configuracions", ConfiguracionController::class)->only(
        ["index", "show", "update"]
    );

    // USUARIO
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/update_foto', [ProfileController::class, 'update_foto'])->name('profile.update_foto');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get("getUser", [UserController::class, 'getUser'])->name('users.getUser');
    Route::get("permisosUsuario", [UserController::class, 'permisosUsuario']);

    // USUARIOS
    Route::get("usuarios/clientes", [UsuarioController::class, 'clientes'])->name("usuarios.clientes");
    Route::put("usuarios/password/{user}", [UsuarioController::class, 'actualizaPassword'])->name("usuarios.password");
    Route::get("usuarios/api_clientes", [UsuarioController::class, 'api_clientes'])->name("usuarios.api_clientes");
    Route::get("usuarios/api", [UsuarioController::class, 'api'])->name("usuarios.api");
    Route::get("usuarios/paginado", [UsuarioController::class, 'paginado'])->name("usuarios.paginado");
    Route::get("usuarios/listado", [UsuarioController::class, 'listado'])->name("usuarios.listado");
    Route::get("usuarios/listado/byTipo", [UsuarioController::class, 'byTipo'])->name("usuarios.byTipo");
    Route::get("usuarios/show/{user}", [UsuarioController::class, 'show'])->name("usuarios.show");
    Route::put("usuarios/update/{user}", [UsuarioController::class, 'update'])->name("usuarios.update");
    Route::delete("usuarios/{user}", [UsuarioController::class, 'destroy'])->name("usuarios.destroy");
    Route::resource("usuarios", UsuarioController::class)->only(
        ["index", "store"]
    );

    // MUNICIPIOS
    Route::get("municipios/api", [MunicipioController::class, 'api'])->name("municipios.api");
    Route::get("municipios/paginado", [MunicipioController::class, 'paginado'])->name("municipios.paginado");
    Route::resource("municipios", MunicipioController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // URBANIZACIONS
    Route::get("urbanizacions/api", [UrbanizacionController::class, 'api'])->name("urbanizacions.api");
    Route::get("urbanizacions/paginado", [UrbanizacionController::class, 'paginado'])->name("urbanizacions.paginado");
    Route::resource("urbanizacions", UrbanizacionController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // MANZANOS
    Route::get("manzanos/api", [ManzanoController::class, 'api'])->name("manzanos.api");
    Route::get("manzanos/paginado", [ManzanoController::class, 'paginado'])->name("manzanos.paginado");
    Route::resource("manzanos", ManzanoController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // TERRENOS
    Route::get("terrenos/api", [TerrenoController::class, 'api'])->name("terrenos.api");
    Route::get("terrenos/paginado", [TerrenoController::class, 'paginado'])->name("terrenos.paginado");
    Route::get("terrenos/listado", [TerrenoController::class, 'listado'])->name("terrenos.listado");
    Route::resource("terrenos", TerrenoController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // CLIENTES
    Route::get("clientes/api", [ClienteController::class, 'api'])->name("clientes.api");
    Route::get("clientes/paginado", [ClienteController::class, 'paginado'])->name("clientes.paginado");
    Route::get("clientes/listado", [ClienteController::class, 'listado'])->name("clientes.listado");
    Route::resource("clientes", ClienteController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // PREVENTA
    Route::get("preventas/api", [PreventaController::class, 'api'])->name("preventas.api");
    Route::get("preventas/paginado", [PreventaController::class, 'paginado'])->name("preventas.paginado");
    Route::get("preventas/listado", [PreventaController::class, 'listado'])->name("preventas.listado");
    Route::get("preventas/listadoPorTerreno", [PreventaController::class, 'listadoPorTerreno'])->name("preventas.listadoPorTerreno");
    Route::resource("preventas", PreventaController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // VENTAS
    Route::get("ventas/api", [VentaController::class, 'api'])->name("ventas.api");
    Route::get("ventas/paginado", [VentaController::class, 'paginado'])->name("ventas.paginado");
    Route::get("ventas/listado", [VentaController::class, 'listado'])->name("ventas.listado");
    Route::resource("ventas", VentaController::class)->only(
        ["index", "store", "edit", "show", "update", "destroy"]
    );

    // REPORTES
    Route::get('reportes/usuarios', [ReporteController::class, 'usuarios'])->name("reportes.usuarios");
    Route::get('reportes/r_usuarios', [ReporteController::class, 'r_usuarios'])->name("reportes.r_usuarios");

    Route::get('reportes/clientes', [ReporteController::class, 'clientes'])->name("reportes.clientes");
    Route::get('reportes/r_clientes', [ReporteController::class, 'r_clientes'])->name("reportes.r_clientes");
    
    Route::get('reportes/especificacion_terrenos', [ReporteController::class, 'especificacion_terrenos'])->name("reportes.especificacion_terrenos");
    Route::get('reportes/r_especificacion_terrenos', [ReporteController::class, 'r_especificacion_terrenos'])->name("reportes.r_especificacion_terrenos");
    
    Route::get('reportes/terrenos', [ReporteController::class, 'terrenos'])->name("reportes.terrenos");
    Route::get('reportes/r_terrenos', [ReporteController::class, 'r_terrenos'])->name("reportes.r_terrenos");
    
    Route::get('reportes/gingresos_economicos', [ReporteController::class, 'gingresos_economicos'])->name("reportes.gingresos_economicos");
    Route::get('reportes/r_gingresos_economicos', [ReporteController::class, 'r_gingresos_economicos'])->name("reportes.r_gingresos_economicos");
    
    Route::get('reportes/gcantidadventas', [ReporteController::class, 'gcantidadventas'])->name("reportes.gcantidadventas");
    Route::get('reportes/r_gcantidadventas', [ReporteController::class, 'r_gcantidadventas'])->name("reportes.r_gcantidadventas");
});
require __DIR__ . '/auth.php';
