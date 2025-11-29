<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMentor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if(! $user || ! $user->isMentor(), Response::HTTP_FORBIDDEN, 'Solo mentores pueden acceder a esta seccion.');

        return $next($request);
    }
}
