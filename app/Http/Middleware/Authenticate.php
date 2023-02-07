<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
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
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        $path = $request->fullUrl();
        $path = str_replace('login-mobile','', $path);
        $path = str_replace('login','', $path);
        $path = str_replace('logout','', $path);
            //redirect with params url intended
        return route('login', ['extend' => $path]);
    }

}
