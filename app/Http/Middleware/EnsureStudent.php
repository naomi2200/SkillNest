<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if(! $user || ! $user->isStudent(), Response::HTTP_FORBIDDEN, 'Solo estudiantes pueden acceder a esta seccion.');

        return $next($request);
    }
}
