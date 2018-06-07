<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Category;
use App\CategoryImage;
use App\EmptyMuch;
use App\Keywords;
use Validator;
class CategoryController extends Controller
{
    private $messages = [
        'category.required'=>'Please enter a name for the new category.',
        'name.unique'=>' The category name has already been taken! Please try a different category name.',
        // 'keywordIni.required'=>'Please enter the first three keywords for the category.',
    ];

    public function dashboard(){
        $list = Category::paginate(5);
        return view("admin.categoryDash")->with(["list"=>$list]);
    }

    public function addCat(){
        return view("admin.addCategory");
    }

    public function saveCat(Request $req){
        $category = new Category;
        
        $rules = [
            'category'=>'required|unique:categories,categoryName',
            // 'keywordIni'=>'required',
        ];

        $validation = Validator::make($req->all(), $rules, $this->messages);
        
        if($validation->passes()){
            if(Category::get() == EmptyMuch::get()){
                $category->categoryID = "C0001";
            }
            else{
                $row = Category::orderby('categoryID', 'desc')->first();
                $temp = substr($row['categoryID'], 1);
                $temp =(int)$temp + 1;
                $newCategoryID = "C".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                
                $category->categoryID = $newCategoryID;
            }
            $tempid =  $category->categoryID;
            $category->categoryName = $req->category;
            $category->save();


            // foreach ($req->keywordIni as $key) {
            //     $keyword = new Keywords;
            //     if(Keywords::get() == EmptyMuch::get()){
            //         $keyword->keywordID = "K0001";
            //     }
            //     else{
            //         $row = Keywords::orderby('keywordID', 'desc')->first();
            //         $temp = substr($row['keywordID'], 1);
            //         $temp =(int)$temp + 1;
            //         $newKeywordID = "K".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                    
            //         $keyword->keywordID = $newKeywordID;
            //     }
            //     $keyword->categoryID = $category->categoryID;
            //     $keyword->keywordName = $key;
            //     $keyword->save();
            // }
            return redirect(url('/addKeyword'.'/'.$tempid));
        }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }
    }

    public function deleteCat($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect(url("/categories"));
    }

    public function viewCat($id){
        $category = Category::findOrFail($id);
        $keywords = Keywords::where("categoryID", $id)->paginate(5);
        return view("admin.viewCategory")->with(["category"=>$category, "list"=>$keywords]);
    }   

    public function addImageCategory($catid, Request $req){
        if(!is_null($req->media[0])){
            $category = Category::findOrFail($catid);
            foreach ($req->media as $file) {
                $fileName = $category->categoryName."/categoryUploads"."/".$file->getClientOriginalName();
                $fileName = str_replace(' ', '', $fileName);
                // dd($fileName);
                Storage::disk('public')->put($fileName, File::get($file));
                $url = Storage::url($fileName);

                $newFile = new CategoryImage;
                if(CategoryImage::get() == EmptyMuch::get()){
                    $newFile->catImageID = "F00001";
                }
                else{
                    $row = CategoryImage::orderby('catImageID', 'desc')->first();
                    $temp = substr($row['catImageID'], 1);
                    $temp =(int)$temp + 1;
                    $id = "F".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                    $newFile->catImageID = $id;
                }
                $newFile->imageContent = $url;
                $newFile->categoryID = $catid;
                $newFile->save();
            }
        }
        return redirect(url('/viewCat'.'/'.$catid));
    }

    public function viewCategoryImages($id){
        $category = Category::findOrFail($id);
        return view("viewCatImages")->with(["category"=>$category]);
    }

    public function deleteImg($id){
        $img = CategoryImage::findOrFail($id);
        $img->delete();
        return redirect()->back();
    }
}
