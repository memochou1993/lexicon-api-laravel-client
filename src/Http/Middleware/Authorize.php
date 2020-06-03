<?php

namespace MemoChou1993\Localize\Http\Middleware;

use Closure;
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
     */
    public function handle($request, $next)
    {
        $api_key = config('localize.api_key');

        if (! ($request->bearerToken() === $api_key)) {
            abort(403);
        }

        return $next($request);
    }
}
