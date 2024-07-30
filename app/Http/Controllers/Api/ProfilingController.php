<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilingQuestion;
use Illuminate\Http\JsonResponse;

class ProfilingController extends Controller
{
    /**
     * Return a list of available profiling questions with answer options if applicable
     */
    public function list(): JsonResponse
    {
        $questions = ProfilingQuestion::select(['id', 'question', 'type'])
            ->with('answers')
            ->get();

        return response()->json($questions);
    }
}
