<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckAdminRole
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
        $user = User::findUserByToken($request->user()->id);

        if ($user->role_id != 1 || $user->status != 'active') {
            return response()->json(['message' => 'forbidden access'])
                                    ->setStatusCode(403);
        }

        return $next($request);
    }
}
