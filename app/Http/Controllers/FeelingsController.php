<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostFeeling;
use App\EmptyMuch;
use Validator;

class FeelingsController extends Controller
{

    private $messages = [
        'name.required'=>'Please enter the name for the feeling.',
        'name.unique'=>'This feeling has already been taken! Please try a different feeling.',
    ];

    public function dashboard(){
        $list = PostFeeling::paginate(5);
        return view("admin.feelingDash")->with(['list'=>$list]);
    }

    public function addFeeling(){
        return view("admin.addFeeling");
    }

    public function deleteFeeling($id){
        $feeling = PostFeeling::findOrFail($id);
        $feeling->delete();
        return view("admin.feelingDash");
    }


    public function saveFeeling(Request $req){
        $feels = new PostFeeling;

        $rules = [
            'name'=>'required|unique:postfeelings,post_feeling_name',
        ];

        $validation = Validator::make($req->all(), $rules, $this->messages);

        if($validation->passes()){
        if(PostFeeling::get() == EmptyMuch::get()){
            $feels->post_feeling_id = "PF01";
        }
        else{
            $row = PostFeeling::orderby('post_feeling_id', 'desc')->first();
            $temp = substr($row['post_feeling_id'], 2);
            $temp =(int)$temp + 1;
            $new_post_feeling_id = "PF".(string)str_pad($temp, 2, "0", STR_PAD_LEFT);
        }
        $feels->post_feeling_id = $new_post_feeling_id;
        $feels->post_feeling_name = $req->name;
        $feels->save();

        return redirect(url('/feelings'));
    }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }   
    }
}
