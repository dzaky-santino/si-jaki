<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AksesMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Arahkan ke halaman login jika pengguna belum login
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->akses === 'Admin') {
            // Jika pengguna adalah Admin, izinkan semua akses
            return $next($request);
        } elseif ($user->akses === 'User') {
            // Jika pengguna adalah User, batasi akses ke rute `users` dan `pt` saja
            if ($request->is('users*') || $request->is('ptn*') || $request->is('pts*') || $request->is('data-histori-pt*')) {
                return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            // Izinkan akses ke rute lain termasuk `home`, `logout`, dan `laporan`
            return $next($request);
        }

        // Jika peran tidak dikenali, arahkan ke halaman home
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
