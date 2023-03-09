<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\StatisticIndexRequest;
use App\Models\Link;
use App\Models\Transition;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatisticController
{
    public function index(StatisticIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $totals = Transition::query();

        if (isset($validated['from'])) {
            $totals->where('created_at', '>=', $validated['from']);
        }

        if (isset($validated['to'])) {
            $totals->where('created_at', '<=', $validated['to']);
        }

        $totals = $totals->get([
            DB::raw('COUNT(id) as total_views'),
            DB::raw('COUNT(DISTINCT user_agent, ip) as unique_views'),
        ]);

        return response()->json($totals);
    }

    public function link(Link $link): JsonResponse
    {
        $totals = $link->transitions()->groupBy('date')
                                      ->orderBy('date', 'DESC')
                                      ->get(array(
                                          DB::raw('COUNT(id) as total_views'),
                                          DB::raw('COUNT(DISTINCT user_agent, ip) as unique_views'),
                                          DB::raw('Date(created_at) as date'),
                                      ));

        return response()->json($totals);
    }
}
