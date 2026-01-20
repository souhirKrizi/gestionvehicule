<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}

