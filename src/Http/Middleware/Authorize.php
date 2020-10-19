<?php

namespace MemoChou1993\Lexicon\Http\Middleware;

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
        if (! ($request->bearerToken() === config('lexicon.api_key'))) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
