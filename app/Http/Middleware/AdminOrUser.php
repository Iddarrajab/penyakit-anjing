<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrUser
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Jika hanya admin yang diizinkan
        if ($role === 'admin') {
            if (Auth::guard('admin')->check()) {
                return $next($request);
            }
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }

        // Jika hanya user yang diizinkan
        if ($role === 'user') {
            if (Auth::guard('web')->check()) {
                return $next($request);
            }
            abort(403, 'Hanya user yang dapat mengakses halaman ini.');
        }

        // Default: admin atau user bisa masuk
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            return $next($request);
        }

        return redirect()->route('login')
            ->with('error', 'Anda harus login sebagai admin atau user untuk mengakses halaman ini.');
    }
}
