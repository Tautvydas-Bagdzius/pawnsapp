<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilingQuestion;
use Illuminate\Http\Request;

class ProfilingController extends Controller
{
    public function list()
    {
        $questions = ProfilingQuestion::select(['id', 'question', 'type'])
            ->with('answers')
            ->get();

        return response()->json($questions);
    }
}
