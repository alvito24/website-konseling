<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            Auth::logout();
            
            return redirect()->route('login')
                ->with('error', 'Ups! Akun kamu belum aktif nih. Tunggu verifikasi dari admin ya, atau coba hubungi admin kalau udah nunggu lama.');
        }

        return $next($request);
    }
}