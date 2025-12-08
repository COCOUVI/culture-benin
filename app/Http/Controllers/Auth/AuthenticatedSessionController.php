<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // ✅ authenticate() fait tout le travail (vérifie + connecte)
        $request->authenticate();

        // ✅ Régénère la session
        $request->session()->regenerate();

        // ✅ Redirige selon le rôle
        return $this->redirectAuthenticatedUser();
    }

    /**
     * Redirige l'utilisateur selon son rôle
     */
    private function redirectAuthenticatedUser(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->isAdminOrManager()) {
            return redirect()->route('home');
        }

        return redirect()->route('accueil');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
