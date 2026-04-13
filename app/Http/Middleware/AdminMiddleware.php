<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas connecté ou n'est pas admin, on le redirige
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Accès réservé aux administrateurs.');
        }
        return $next($request);
    }
}
