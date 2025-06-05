<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Publicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        Auth::user()->ultima_sesion = date("Y-m-d");
        Auth::user()->save();

        $oPub = new Publicacion();
        $oPub->actualizaEstadoUsuario();
        $oPub->actualizaPublicacionesEstado();

        if ($request->ajax()) {
            return response()->JSON(["user" => Auth::user()]);
        }

        if (Auth::user()->role_id === 2) {
            return redirect()->intended(route('portal.index'));
        }

        return redirect()->intended(route('inicio'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
