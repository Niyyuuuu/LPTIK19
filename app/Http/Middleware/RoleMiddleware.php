<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated and has the required role
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            
            return redirect('/home')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
        }
        return $next($request);
    }
}