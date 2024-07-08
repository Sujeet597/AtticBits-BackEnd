<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error: ' . $e->getMessage());
        }

        return redirect('/')->with('error', 'You do not have admin access');
    }

}