<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
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

        if (!Auth::user()) {
            return response(['message' => 'Forbidden - user not found'], 401);
        }

        $roles = Auth::user()->roles;

        foreach ($roles as $role) {
            if ($role->role === 'Администратор') {
                return $next($request);
            }
        }

        return response(['message' => 'Forbidden - permission'], 403);
    }
}
