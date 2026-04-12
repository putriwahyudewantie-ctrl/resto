<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsDapur
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, ['dapur', 'admin'])) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Akses Ditolak! Halaman ini hanya untuk Staff Dapur.');
    }
}
