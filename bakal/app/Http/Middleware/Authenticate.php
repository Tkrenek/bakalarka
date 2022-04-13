<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(auth('customer')->user()){
                Auth::guard('customer')->logout();
                return route('start');
        } else if (auth('admin')->user()){
                Auth::guard('admin')->logout();
                return route('start');
            } else if(auth('employee')->user()){
                Auth::guard('employee')->logout();
                return route('start');
            } else {
                return route('start');
            }
                
        }
    }
}
