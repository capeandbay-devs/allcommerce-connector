<?php

namespace CapeAndBay\AllCommerce\Http\Middleware;

use Closure;

class CheckForAccessToken
{
    public function handle($request, Closure $next)
    {
        if(!session()->has('allcommerce-jwt-access-token'))
        {
            return redirect('/access');
        }

        return $next($request);
    }
}
