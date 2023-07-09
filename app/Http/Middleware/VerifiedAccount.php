<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedAccount
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
        if ($request->verify != 1){
            return redirect('/verify');
        }
        return $next($request);
    }
}
