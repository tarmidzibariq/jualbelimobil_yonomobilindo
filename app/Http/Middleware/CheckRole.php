<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah pengguna sudah login dan apakah role-nya sesuai dengan yang diminta
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Jika tidak sesuai, redirect ke halaman utama atau halaman lainnya
            return redirect('/');
        }

        return $next($request);
    }
}
