<?php

namespace App\Http\Middleware;

use App\Model\Admin;
use Closure;

class CheckLogin
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
       $aid = Admin::getid();
        if (empty($aid)) {
            return redirect('/');
        }
        return $next($request);
    }
}
