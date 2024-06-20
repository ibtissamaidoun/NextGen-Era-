<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {       
        if (!Auth::check())
        {
           return response()->json(['message' => 'Non authentifié'], 401);
        }
        $user = Auth::user();
        if (in_array($user->role, $roles)) 
        {
            return $next($request);
        }
        return response()->json(['message' => 'Accès non autorisé'], 403);
    }
}