<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interest;

class InterestController extends Controller
{
    public function getInterests(){
        $interests = Interest::get();
        return response($interests,200);
    }
}
