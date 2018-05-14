<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostStatus;
use App\EmptyMuch;
use App\PostFeeling;
use App\UsersPostFeeling;
use App\Quote;
use Auth;
use GuzzleHttp;

class PostStatusController extends Controller
{
    public function displayPosts(){
        $id = Auth::id();
        $posts = PostStatus::where('post_user_id',$id)->get();
        // return $posts;
        // return response($posts,200);
        return view('display',compact('posts'));
    }

    public function displayPost($postid){
        $post = PostStatus::where("post_id",$postid)->get();
        // return $post;
        return response($post,200);
    }

    public function addPost(){
        return view('post');
    }

    public function savePost(Request $request){
        $feelingID = ' ';
        $id = Auth::id();
        $post = new PostStatus();
        if (PostStatus::get() == EmptyMuch::get()){
            $post->post_id = "P00000000001";
        }
        else {
            $row = PostStatus::orderby('post_id','desc')->first();
            $temp = substr($row["post_id"],1);
            $temp = (int)$temp + 1;
            $newPostID = "P".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
            $post->post_id = $newPostID;
        }
        $pID = $post->post_id;
        $post->post_content = $request->post;
        $insertedID = $post->post_id;
        $post->post_user_id = $id;
        $post->save();

        $db_feeling = PostFeeling::get();
        foreach($db_feeling as $feel){
            if ($feel["post_feeling_name"] == $request->feeling){
                $feelingID = $feel["post_feeling_id"];
            }
        }
        
        UsersPostFeeling::create([
            'post_id' => $pID,
            'post_feeling_id' => $feelingID,
        ]);
        // return redirect(url('/posts/'.$insertedID.'/display'));
        return response("Posted!",200);
    }   

    public function update($postid){
        // $mode = 'edit';
        $record = PostStatus::where("post_id",$postid)->get();
        // return view('comments',compact('mode','record')); 
        //multiple values jd ang compact
        return $record;
    }

    public function saveupdate(Request $request){
        // $validation = Validator::make($request->all(),$this->rules,$this->messages);
        // if($validation->passes()){
        $feelingID = ' ';
        $record = PostStatus::where("post_id",$request->postid)->get();
        $record->post_content = $request->content;
        $post->save();
        $db_feeling = PostFeeling::get();
        foreach($db_feeling as $feel){
            if ($feel["post_feeling_name"] == $request->feeling){
                $feelingID = $feel["post_feeling_id"];
            }
        }
        $feeling = UsersPostFeeling::where("post_id",$request->postid)->get();
        $feeling->post_feeling_id = $feelingID;
        // $insertedID = $post->post_id;
        // $post->post_user_id = $id;
        return response("Post updated!",200);
    }

    public function deletePost($postid){
        $record = PostStatus::where("post_id",$postid)->get();
        $record->delete();
        return response($record,200);
    }


    // public function displayPostFeelings(){
        
    // }












    public function displayQuotes(){
        // $collection = []; $j = 0; $count = 0; $check = true;
        // for($i = 0 ; $i < 10 ; $i++){
        //     if ($i === 0){
                $client = new GuzzleHttp\Client();
                $res = $client->request('GET', 'https://api.forismatic.com/api/1.0/?method=getQuote&key=happy&format=json&lang=en');
                $data = $res->getBody()->getContents();
                $newData = json_decode($data, true);
                // array_push($collection,$newData);
        //     }
        //     if(!empty($collection)) {
        //         do{
        //             $client = new GuzzleHttp\Client();
        //             $res = $client->request('GET', 'https://api.forismatic.com/api/1.0/?method=getQuote&key=happy&format=json&lang=en');
        //             $data = $res->getBody()->getContents();
        //             $newData = json_decode($data, true);
        //             $count = 0;
        //             foreach($collection as $index){
        //                 if (strcmp($index["quoteText"],$newData['quoteText']) == 0 ){
        //                     $count++;
        //                 } 
        //             }
        //             if ($count == 0){
        //                 $check = false;
        //                 array_push($collection,$newData);
        //             }
        //         } while($check);
        //     }
        // }
        // dd($collection, $j);
        return response($newData);
    }   
}
