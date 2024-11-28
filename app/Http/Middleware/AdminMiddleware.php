<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Verifica si el usuario está autenticado y es administrador
         if (Auth::check() && Auth::user()->admin) {
            return $next($request);
        }
         // Redirige a una página no autorizada o realiza otras acciones según tu caso
         return redirect('/');
    }
}
