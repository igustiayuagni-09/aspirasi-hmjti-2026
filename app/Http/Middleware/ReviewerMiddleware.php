<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ReviewerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🔒 Belum login
        if (!Auth::check()) {
            abort(401, 'Anda harus login untuk mengakses halaman ini.');
        }

        // 🚫 Sudah login tapi bukan reviewer
        if (!Auth::user()->hasRole('reviewer')) {
            abort(403, 'Anda tidak memiliki akses sebagai reviewer.');
        }

        return $next($request);
    }
}
