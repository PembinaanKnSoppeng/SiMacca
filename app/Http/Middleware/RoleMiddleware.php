<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Kalau belum login
        if (!$user) {
            abort(403, 'AKSES DITOLAK: Anda belum login.');
        }

        // Admin bisa akses semua route
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Role lain harus sesuai izin route
        if (!in_array($user->role, $roles)) {
            abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
