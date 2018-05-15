<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\EmptyMuch;
use App\Keywords;

class KeywordController extends Controller
{
    public function deleteKeyword($catID, $id){
        $keyword = Keywords::findOrFail($id);
        $keyword->delete();
        return redirect(url("/viewCat"."/".$catID));
    }

    public function addKeyword($id){
        $category = Category::findOrFail($id);
        return view("addKeyword")->with(["category"=>$category]);
    }

    public function saveKeyword($id, Request $req){
        $keyword = new Keywords;

        if(Keywords::get() == EmptyMuch::get()){
            $keyword->keywordID = "K0001";
        }
        else{
            $row = Keywords::orderby('keywordID', 'desc')->first();
            $temp = substr($row['keywordID'], 1);
            $temp =(int)$temp + 1;
            $newKeywordID = "K".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                    
            $keyword->keywordID = $newKeywordID;
        }
        $keyword->categoryID = $id;
        $keyword->keywordName = $req->keyword;
        $keyword->save();

        return redirect(url("/viewCat"."/".$id));
    }
}
