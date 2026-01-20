<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->isApproved()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte est en attente d\'approbation.');
        }

        return $next($request);
    }
}