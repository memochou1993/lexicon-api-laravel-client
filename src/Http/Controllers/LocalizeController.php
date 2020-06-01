<?php

namespace MemoChou1993\Localize\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use MemoChou1993\Localize\Facades\Localize;
use Symfony\Component\HttpFoundation\Response;

class LocalizeController extends Controller
{
    /**
     * Export language resources.
     *
     * @return JsonResponse
     */
    public function export()
    {
        Localize::export();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Clear language resources.
     *
     * @return JsonResponse
     */
    public function clear()
    {
        Localize::clear();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
