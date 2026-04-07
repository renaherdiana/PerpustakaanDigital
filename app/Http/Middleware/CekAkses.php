<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekAkses
{
    public function handle(Request $request, Closure $next, $role)
    {

        // ======================
        // CEK LOGIN ANGGOTA
        // ======================
                if (session()->has('anggota_id')) {

            if ($role === null || $role === 'anggota') {
                return $next($request);
            }

            // Redirect anggota jika mencoba akses halaman lain
            return redirect()->route('home')
                ->with('error', 'Akses ditolak!');
        }



        // ======================
        // CEK LOGIN ADMIN / PETUGAS / SUPERADMIN
        // ======================
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role != $role) {
            abort(403);
        }

        return $next($request);
    }
}