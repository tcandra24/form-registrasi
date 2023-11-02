<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->headers->has('Content-Type')){
            return response()->json([
                'success' => false,
                'message' => 'Content Type Header harus application/json'
            ], 400);
        }

        if (!$request->headers->has('X-Token')){
            return response()->json([
                'success' => false,
                'message' => 'Token Header harus diisi'
            ], 400);
        }

        if ($request->header('X-Token')!== env('TOKEN_TRANSACTION')) {
            return response()->json([
                'success' => false,
                'message' => 'Token Salah'
            ], 400);
        }

        return $next($request);
    }
}
