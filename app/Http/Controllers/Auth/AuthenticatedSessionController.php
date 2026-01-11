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
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Check if user is admin (legacy support)
        if ($user->is_admin) {
            return redirect('/admin-dashboard');
        }

        // Check user role for redirection
        if ($user->role) {
            switch ($user->role->name) {
                case 'super_admin':
                case 'admin':
                    return redirect('/admin-dashboard');
                case 'agent':
                    return redirect('/agent-dashboard');
                case 'customer':
                default:
                    return redirect()->intended(route('dashboard', absolute: false));
            }
        }

        // Default fallback
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Ensure session is cleared
        $request->session()->flush();

        return redirect('/');
    }
}
