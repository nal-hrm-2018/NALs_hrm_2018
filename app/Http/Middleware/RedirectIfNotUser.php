<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 4/11/2018
 * Time: 11:07 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }
        return redirect()->action('Auth\LoginController@getLogin');
    }

}