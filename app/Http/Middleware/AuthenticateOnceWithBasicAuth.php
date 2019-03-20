<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateOnceWithBasicAuth
{
    /***********************************************************

     * @params \Closure $next

     * @description http기본인증 미들웨어

     * @method

     * @return mixed

     ***********************************************************/
    public function handle($request, Closure $next)
    {
        return auth()->onceBasic() ?: $next($request);
    }
}
