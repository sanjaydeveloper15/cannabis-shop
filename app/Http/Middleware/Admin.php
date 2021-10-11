<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        $admin_user = $request->session()->get('admin_session_data');
        if(!$admin_user){
            $request->session()->forget(['userData']);
            return redirect('admin');
        }
        return $next($request);
    }
}
