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
        // if (!$request->headers->has('Content-Type')){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Content Type Header harus application/json'
        //     ], 400);
        // }

        // if (!$request->headers->has('X-Token')){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Token Header harus diisi'
        //     ], 400);
        // }

        // if ($request->header('X-Token') !== 'bd78cb96df3de3e068e22643760e85bbd9a66b3b6ec6b9248d580d011e489143') {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Token Transaksi Salah'
        //     ], 400);
        // }

        return $next($request);
    }
}
