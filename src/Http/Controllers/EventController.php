<?php

namespace MemoChou1993\Localize\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
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
     * Export language resources.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        collect($request->input('events'))
            ->intersect($this->events)
            ->each(function ($event) {
                Event::dispatch($event);
            });

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
