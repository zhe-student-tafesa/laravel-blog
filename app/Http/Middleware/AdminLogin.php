<?php

namespace App\Http\Middleware;
session_start();

use Closure;
use Illuminate\Http\Request;

class AdminLogin
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
        //echo 7788;
        //echo $_SESSION['admin'];  ok
        //$_SESSION['admin'] session('admin');
        if(!$_SESSION['admin']){
            return redirect('Admin/login');
        }
        return $next($request);
    }
}
