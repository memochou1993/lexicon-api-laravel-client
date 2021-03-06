<?php

namespace MemoChou1993\Lexicon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;

class DispatchController extends Controller
{
    /**
     * The events for the application.
     *
     * @var array
     */
    protected array $events = [
        'sync',
    ];

    /**
     * Receive and dispatch events.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        collect($request->input('events'))
            ->intersect($this->events)
            ->each(fn($event) => Event::dispatch($event));

        return response()->json(null, Response::HTTP_ACCEPTED);
    }
}
