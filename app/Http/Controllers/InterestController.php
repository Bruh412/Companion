<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interest;
use App\EmptyMuch;
use Validator;

class InterestController extends Controller
{
    
    private $messages = [
        'name.required'=>'Please enter a name for the new interest.',
        'name.unique'=>' The interest name has already been taken! Please try a different interest name.',
    ];

    public function dashboard(){
        $list = Interest::paginate(5);
        return view("interestDash")->with(["list"=>$list]);
    }

    public function addInt(){
        return view("addInterest");
    }

    public function saveInt(Request $req){
        $interest = new Interest;
        
        $rules = [
            'name'=>'required|unique:interests,interestName',
        ];

        $validation = Validator::make($req->all(), $rules, $this->messages);
        
        if($validation->passes()){
            if(Interest::get() == EmptyMuch::get()){
                $interest->interestID = "I001";
            }
            else{
                $row = Interest::orderby('interestID', 'desc')->first();
                $temp = substr($row['interestID'], 1);
                $temp =(int)$temp + 1;
                $newInterestID = "I".(string)str_pad($temp, 3, "0", STR_PAD_LEFT);
                
                $interest->interestID = $newInterestID;
            }
            $interest->interestName = $req->name;
            $interest->save();
            return redirect(url('/interests'));
        }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }
    }

    public function deleteInt($id){
        $interest = Interest::findOrFail($id);
        $interest->delete();
        return redirect(url("/interests"));
    }
    
    
    public function getInterests(){
        $interests = Interest::get();
        return response()->json([
            'interests' => $interests,
        ]);
    }
}
