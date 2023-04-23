<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CustomerMiddleWare
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
        if(Auth::guard('webcustomer')->check())
        {
            $user = Auth::guard('webcustomer')->user();
            if($user)
                return $next($request);
            else
                return response()->json([
                  'message' => 'Not allow access this page'
                ], 403);
        }
        else
        {
            return response()->json([
                'message' => 'Not allow access this page'
              ], 403);
        }   
    }
}
