<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialization;

class SpecializationController extends Controller
{
    public function getSpecsFromDB(){
        $specs = Specialization::get();
        return response($specs,200);
    }
}
