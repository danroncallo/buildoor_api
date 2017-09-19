<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class PortfolioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::findOrFail($request->user()->id);
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
}
