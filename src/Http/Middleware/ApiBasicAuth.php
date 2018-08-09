<?php

namespace Consilience\ApiBasicAuth\Http\Middleware;

use Closure;

class ApiBasicAuth
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
        // Check if middleware is in use in current environment
        if (count(array_intersect(['*', app()->environment()], config('api_basic_auth.envs'))) > 0) {

            // Check for credentials
            if (
                $request->getUser() != config('fis_basic_auth.user')
                || $request->getPassword() != config('fis_basic_auth.password')
            ) {
                // TODO: just return a 404.

                // Build header
                $header = ['WWW-Authenticate' => sprintf('Basic realm="%s", charset="UTF-8"', config('api_basic_auth.realm', 'Basic Auth'))];

                // Else return default message
                return response(config('api_basic_auth.error_message'), 401, $header);
            }
        }

        return $next($request);
    }
}
