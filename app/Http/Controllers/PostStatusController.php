<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostStatus;
use App\EmptyMuch;
use App\Problem;
use App\UsersPostFeeling;
use App\PostFeeling;
use App\Quote;
use App\CommentPost;
use App\MatchPostQuote;
use App\MatchQuote;
use App\MatchVideo;
use App\TopCategoriesForPost;
use Auth;
use GuzzleHttp;
use Validator;
use DB;

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
        $post = PostStatus::where("post_id",$postid)->first();
        $comments = CommentPost::where('post_id',$postid)->orderBy('commentID','desc')->get();
        // return response($post,200);
        return view('user.viewComments',compact('post','comments'));
    }

    public function addPost(){
        return view('post');
    }

    public function savePost(Request $request){
        $feelingID = ' ';
        $id = Auth::id();
        // $authorizationHeader = $request->header('Authorization');

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
        // $post->post_user_id = $authorizationHeader;
        $post->save();

        $db_feeling = PostFeeling::get();
        if($request->feeling != "null") {
            foreach($db_feeling as $feel){
                if ($feel["post_feeling_name"] == $request->feeling){
                    $feelingID = $feel["post_feeling_id"];
                }
            }
            UsersPostFeeling::create([
                'post_id' => $pID,
                'post_feeling_id' => $feelingID,
            ]);
        }
        $feelings = PostFeeling::get();

        // $post = DB::table('systemusers')
        //     ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
        //     ->select('poststatus.post_content','poststatus.post_id')
        //     ->orderBy('post_id','desc')
        //     ->where('user_id',$id)
        //     ->first();
        $words = explode(' ',$request->post);
        $similar = [];
        for( $i = 0 ; $i < count($words) ; $i++ ){
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$i])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                $temp = json_decode($ss);
                array_push($similar,$temp);
            }
        }
        $temp = [];
        $total = [];
        $final = [];
        $temp2 = [];
        $quotes = [];
        $s = [];
        $count = 0;
        // return $similar;
        foreach($similar as $row){
            foreach($row as $details => $value){
                $false = 0;
                if (empty($total)){
                    $temp = [
                                'category' => $value->categoryID,
                                'counter' => $value->cnt_keyword,
                            ];
                    array_push($total,$temp);
                } 
                else {
                    foreach($total as $index => $value1){
                        if ($value1['category'] == $value->categoryID){
                            $value1['counter'] = $value1['counter'] + $value->cnt_keyword;
                            
                            $temp2 = $value1;
                            $false++;
                        }
                    }
                    if ($false == 0){
                        $temp = [
                                    'category' => $value->categoryID,
                                    'counter' => $value->cnt_keyword,
                                ];
                        array_push($total,$temp);
                    }
                    for($i  = 0 ; $i < count($total); $i++){
                        if (!empty($temp2)){
                            if ($total[$i]['category'] == $temp2['category']){
                                $total[$i]['counter'] = $temp2['counter'];
                            }
                        }
                    }
                }
            }
        }
        usort($total, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        // return $total;
        $newTotal = $total;
        // return array_splice($total,0,3);
        foreach(array_splice($total,0,3) as $value){
            $quotes = DB::table('matchquote')
                    ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
                    ->select('quotes.*')
                    ->where('matchquote.categoryID',$value['category'])
                    ->get();
        }
        foreach($quotes as $quote){
            $match = new MatchPostQuote();
            if (MatchPostQuote::get() == EmptyMuch::get()){
                $match->matchID = "M00000000001";
            }
            else {
                $row = MatchPostQuote::orderby('matchID','desc')->first();
                $temp = substr($row["matchID"],1);
                $temp = (int)$temp + 1;
                $newPostID = "M".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                $match->matchID = $newPostID;
            }
            $match->post_id = $pID;
            $match->quoteID = $quote->quoteID;
            $match->save();
        }
        // return array_splice($newTotal,0,3);
        foreach(array_splice($newTotal,0,3) as $row1){
            $top = new TopCategoriesForPost();
            if (TopCategoriesForPost::get() == EmptyMuch::get()){
                $top->top_id = "T00000000001";
                $top->post_id = $pID;
                $top->categoryID = $row1['category'];
                $top->save();
                // return 'hey';
            }
            else {
                $row = TopCategoriesForPost::orderby('top_id','desc')->first();
                $temp = substr($row["top_id"],1);
                $temp = (int)$temp + 1;
                $newPostID = "T".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                $top->top_id = $newPostID;
                $top->post_id = $pID;
                $top->categoryID = $row1['category'];
                $top->save();
            }
        }
        // return 'yhey';
        $quotes = [];
        $videos = [];
        $result = [];
        $comp = [];
        $usersPost = PostStatus::where('post_user_id',$id)->orderBy('post_id','desc')->get();
        $catPost = TopCategoriesForPost::get();
        foreach($usersPost as $post){
            $temp = MatchPostQuote::where('post_id', $post['post_id'])->orderByRaw("RAND()")->take(3)->get();
            array_push($quotes,$temp);
            // return $catPost;
            foreach($catPost as $row){
                if ($post->post_id == $row->post_id){
                    array_push($result,$row);
                }
            }
        }
        foreach($result as $row){
            $temp = MatchVideo::where('categoryID', $row['categoryID'])->orderByRaw("RAND()")->take(2)->get();
            foreach($temp as $row1){
                $tem = [
                    'post_id' => $row['post_id'],
                    'videoID' => $row1->videoID,
                ];
                array_push($comp,$tem);
                // return $comp;
            }
            array_push($videos,$temp);
        }
        // return $videos;
        return view("user.postList",compact('usersPost','quotes','videos','comp'));
    }   

    public function update($postid){
        $record = PostStatus::where("post_id",$postid)->first();
        $feelings = PostFeeling::get();
        return view('user.editPost',compact('record','feelings'));
    }

    public function saveupdate(Request $request){
        $userid = Auth::id();
        $feelingID = ' ';
        $record = PostStatus::where("post_id",$request->postid)->first();
        $record->post_content = $request->post;
        $record->save();

        $id = $request->postid;
        $db_feeling = PostFeeling::get();
        $feeling = UsersPostFeeling::where("post_id",$id)->first();
        if($request->feeling != "null") {
            if($feeling){
                foreach($db_feeling as $feel){
                    if ($feel["post_feeling_name"] == $request->feeling){
                        $feelingID = $feel["post_feeling_id"];
                    }
                }
                $feeling->post_feeling_id = $feelingID;
                $feeling->save();
            }
            else {
                foreach($db_feeling as $feel){
                    if ($feel["post_feeling_name"] == $request->feeling){
                        $feelingID = $feel["post_feeling_id"];
                    }
                }
                UsersPostFeeling::create([
                    'post_id' => $id,
                    'post_feeling_id' => $feelingID,
                ]);
            }
        } 
        else {
            $feeling->delete();
        }
        // $post = DB::table('systemusers')
        //     ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
        //     ->select('poststatus.post_content','poststatus.post_id')
        //     ->orderBy('post_id','desc')
        //     ->where('user_id',$userid)
        //     ->first();
        $words = explode(' ',$request->post);
        $similar = [];
        for( $i = 0 ; $i < count($words) ; $i++ ){
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$i])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                $temp = json_decode($ss);
                array_push($similar,$temp);
            }
        }
        $temp = [];
        $total = [];
        $final = [];
        $temp2 = [];
        $quotes = [];
        $s = [];
        $count = 0;
        // return $similar;
        foreach($similar as $row){
            foreach($row as $details => $value){
                $false = 0;
                if (empty($total)){
                    $temp = [
                                'category' => $value->categoryID,
                                'counter' => $value->cnt_keyword,
                            ];
                    array_push($total,$temp);
                } 
                else {
                    foreach($total as $index => $value1){
                        if ($value1['category'] == $value->categoryID){
                            $value1['counter'] = $value1['counter'] + $value->cnt_keyword;
                            
                            $temp2 = $value1;
                            $false++;
                        }
                    }
                    if ($false == 0){
                        $temp = [
                                    'category' => $value->categoryID,
                                    'counter' => $value->cnt_keyword,
                                ];
                        array_push($total,$temp);
                    }
                    for($i  = 0 ; $i < count($total); $i++){
                        if (!empty($temp2)){
                            if ($total[$i]['category'] == $temp2['category']){
                                $total[$i]['counter'] = $temp2['counter'];
                            }
                        }
                    }
                }
            }
        }
        usort($total, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        $newTotal = $total;
        foreach(array_splice($total,0,3) as $value){
            $quotes = DB::table('matchquote')
                    ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
                    ->select('quotes.*')
                    ->where('matchquote.categoryID',$value['category'])
                    ->get();
        }
        $orig = MatchPostQuote::where("post_id", $id)->get();
        foreach ($orig as $row) {
            $row->delete();
        }
        foreach($quotes as $quote){
            $match = new MatchPostQuote();
            if (MatchPostQuote::get() == EmptyMuch::get()){
                $match->matchID = "M00000000001";
            }
            else {
                $row = MatchPostQuote::orderby('matchID','desc')->first();
                $temp = substr($row["matchID"],1);
                $temp = (int)$temp + 1;
                $newPostID = "M".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                $match->matchID = $newPostID;
            }
            $match->post_id = $id;
            $match->quoteID = $quote->quoteID;
            $match->save();
        }
        $orig = TopCategoriesForPost::where("post_id", $id)->get();
        foreach ($orig as $row) {
            $row->delete();
        }
        foreach(array_splice($newTotal,0,3) as $row1){
            $top = new TopCategoriesForPost();
            if (TopCategoriesForPost::get() == EmptyMuch::get()){
                $top->top_id = "T00000000001";
                $top->post_id = $id;
                $top->categoryID = $row1['category'];
                $top->save();
            }
            else {
                $row = TopCategoriesForPost::orderby('top_id','desc')->first();
                $temp = substr($row["top_id"],1);
                $temp = (int)$temp + 1;
                $newPostID = "T".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                $top->top_id = $newPostID;
                $top->post_id = $id;
                $top->categoryID = $row1['category'];
                $top->save();
            }
        }   
        return redirect(url('/wall'));
    }

    public function deletePost($postid){
        $userid = Auth::id();
        $record = PostStatus::where("post_id",$postid);
        $record->delete();
        $usersPost = PostStatus::where('post_user_id',$userid)->orderBy('post_id','desc')->get();
        $feelings = PostFeeling::get();
        return redirect(url('/wall'));
    }


    public function getFeelings(){
        $feelings = PostFeeling::get();
        return response()->json([
            'feelings' => $feelings,
        ]);
    }


    public function addComment($postid){
        $post = PostStatus::where('post_id',$postid)->first();
        $comments = CommentPost::where('post_id',$postid)->orderBy('commentID','desc')->get();
        return view('user.addComment',compact('post','comments'));
    }

    public function saveComment(Request $request){
        $userid = Auth::id();
        $comment = new CommentPost();
        $postid = $request->postid;
        if (CommentPost::get() == EmptyMuch::get()){
            $comment->commentID = "C00000000001";
        }
        else {
            $row = CommentPost::orderby('commentID','desc')->first();
            $temp = substr($row["commentID"],1);
            $temp = (int)$temp + 1;
            $newPostID = "C".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
            $comment->commentID = $newPostID;
        }
        $cID = $comment->commentID;
        $comment->comment_content = $request->comment;
        $comment->post_id = $postid;
        $comment->user_id = $userid;
        $comment->save();
        $comments = CommentPost::where('post_id',$postid)->orderBy('commentID','desc')->get();
        $post = PostStatus::where('post_id',$postid)->first();
        // return view('addComment',compact('comment','comments','post'));
        return response($request,200);
    }

}
