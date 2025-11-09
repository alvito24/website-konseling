<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->email_verified_at) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Akun lu belum diverifikasi bro! Tunggu admin approve dulu ya.'], 403);
            }
            
            return redirect()->route('verification.notice')
                ->with('warning', 'Akun lu belum diverifikasi bro! Tunggu admin approve dulu ya.');
        }

        return $next($request);
    }
}