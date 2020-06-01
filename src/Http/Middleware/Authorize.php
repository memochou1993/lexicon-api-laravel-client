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
        $secret_key = config('localize.secret_key');

        if (! ($request->header('X-Localize-Secret-Key') === $secret_key)) {
            abort(403);
        }

        return $next($request);
    }
}
