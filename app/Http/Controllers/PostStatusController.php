<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostStatus;
use App\EmptyMuch;
use App\Problem;
use App\UsersPostFeeling;
use App\PostFeeling;
use App\Quote;
use Auth;
use GuzzleHttp;
use Validator;

class PostStatusController extends Controller
{
    
    public function displayPosts(){
        $id = Auth::id();
        $posts = PostStatus::where('post_user_id',$id)->get();
        // return $posts;
        // return response($posts,200);
        // return view('display',compact('posts'));
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
        $authorizationHeader = $request->header('Authorization');

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
        $post->post_user_id = $authorizationHeader;
        $post->save();

        $db_feeling = PostFeeling::get();
        if (!empty($request->feeling)){
            foreach($db_feeling as $feel){
                if ($feel["post_feeling_name"] == $request->feeling){
                    $feelingID = $feel["post_feeling_id"];
                }
            }
            UsersPostFeeling::create([
                'post_id' => $pID,
                'post_feeling_id' => $feelingID,
            ]);
        } else {
            UsersPostFeeling::create([
                'post_id' => $pID,
                'post_feeling_id' => null,
            ]);
        }

        return response()->json([
            'message' => 'Posted!',
        ]);
    }   

    public function update($postid){
        // $mode = 'edit';
        $record = PostStatus::where("post_id",$postid)->get();
        // return view('comments',compact('mode','record')); 
        //multiple values jd ang compact
        return $record;
    }

    public function saveupdate(Request $request){
        $feelingID = ' ';
        $record = PostStatus::where("post_id",$request->postid)->first();
        $record->post_content = $request->post;
        $record->save();
        $id = $request->postid;
        $db_feeling = PostFeeling::get();
        $feeling = UsersPostFeeling::where("post_id",$id)->first();
        if (!empty($request->feeling)){
            foreach($db_feeling as $feel){
                if ($feel["post_feeling_name"] == $request->feeling){
                    $feelingID = $feel["post_feeling_id"];
                }
            }
            $feeling->post_feeling_id = $feelingID;
        } else {
            $feeling->post_feeling_id = null;
        }
        $feeling->save();

        return response()->json([
            'message' => 'Updated!',
        ]);
    }

    public function deletePost($postid){
        $record = PostStatus::where("post_id",$postid)->get();
        $record->delete();
        return response($record,200);
    }


    public function getFeelings(){
        $feelings = PostFeeling::get();
        return response($feelings,200);
    }

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
