<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in via session
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user has the correct role in session
        if (session('role') !== $role) {
            // Allow 'panitia' to access 'pengunjung' pages
            if ($role === 'pengunjung' && session('role') === 'panitia') {
                return $next($request);
            }

            if (session('role') === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (session('role') === 'panitia') {
                return redirect()->route('beranda.panitia');
            } else {
                return redirect()->route('pengunjung.dashboard');
            }
        }

        return $next($request);
    }
}
