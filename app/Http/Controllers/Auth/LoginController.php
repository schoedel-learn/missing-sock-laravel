<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the central login page
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to their appropriate panel
        if (Auth::check()) {
            return $this->redirectToPanel(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle login attempt and redirect to appropriate panel
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectToPanel(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Redirect user to their appropriate panel based on role
     */
    protected function redirectToPanel($user)
    {
        return match ($user->role) {
            UserRole::Admin => redirect('/admin'),
            UserRole::PhotoManager => redirect('/photo-manager'),
            UserRole::OrganizationCoordinator => redirect('/coordinator'),
            UserRole::Parent => redirect('/my-account'),
            default => redirect()->route('home'),
        };
    }
}

