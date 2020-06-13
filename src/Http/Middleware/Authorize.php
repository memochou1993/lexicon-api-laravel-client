<?php

namespace MemoChou1993\Localize\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     * @throws AuthenticationException
     */
    public function handle($request, $next)
    {
        $apiKey = config('localize.api_key');

        if (! ($request->header('X-Localize-API-Key') === $apiKey)) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
