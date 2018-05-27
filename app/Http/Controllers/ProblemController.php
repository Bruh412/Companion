<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problem;

class ProblemController extends Controller
{
    public function getProblems(){
        $problems = Problem::Get();
        return response()->json([
            'problems' => $problems,
        ]);
    }
}
