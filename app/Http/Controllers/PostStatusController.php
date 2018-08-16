<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostStatus;
use App\EmptyMuch;
use App\Problem;
use App\UsersPostFeeling;
use App\PostFeeling;
use App\Quote;
use App\Token;
use App\CommentPost;
use App\MatchPostQuote;
use App\MatchQuote;
use App\MatchVideo;
use App\TopCategoriesForPost;
use App\YoutubeAPIKey;
use Auth;
use GuzzleHttp;
use Validator;
use DB;

class PostStatusController extends Controller
{
    
    public function displayPosts(Request $request){
        $id = Auth::id();
        $posts = PostStatus::where('post_user_id',$id)->get();
        return $posts;
        return response($posts,200);
        return view('display',compact('posts'));
        // $userID = Token::where("token", $request['token'])->value('token_user_id');
        // $posts = PostStatus::where("post_user_id",$userID)->orderBy('post_id','desc')->get();
        // $postFeelings = [];
        // foreach($posts as $post){
        //     $temp = DB::table('poststatus')
        //         ->join('userspostfeelings','poststatus.post_id','=','userspostfeelings.post_id')
        //         ->join('postfeelings','userspostfeelings.post_feeling_id','=','postfeelings.post_feeling_id')
        //         ->select('userspostfeelings.post_id', 'userspostfeelings.post_feeling_id','postfeelings.post_feeling_name')
        //         ->where('poststatus.post_id',$post['post_id'])
        //         ->get();
        //     array_push($postFeelings,$temp);
        // }
        // return response()->json([
        //     'posts' => $posts,
        //     'feelings' => $postFeelings
        // ]);
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
        // return $request;
        $feelingID = ' ';
        // $id = Token::where('token',$request['token'])->value('token_user_id');
        $id = Auth::id();
        $post = new PostStatus();
        // return $id;
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
        // return 'true';
        $feelings = PostFeeling::get();
        $words = explode(' ',$request->post);
        $similar = [];

        // compare words sa db keywords, group by categoryID and add its counter
        for( $j = 0 ; $j < count($words) ; $j++ ){
            $cid = ' ';
            $kw_count = 0;
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$j])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                if(empty($similar)){
                    foreach($ss as $row){
                        $temp = [ 
                            'category' => $row->categoryID,
                            'counter' => $row->cnt_keyword,
                        ];
                        array_push($similar,$temp);
                    }   
                }
                else{
                    foreach($ss as $row){
                        $true = 0;
                        for($i = 0 ; $i < count($similar); $i++){
                            if ($similar[$i]['category'] == $row->categoryID){
                                $similar[$i]['counter'] = $similar[$i]['counter'] + $row->cnt_keyword;
                                $true++;
                            }
                        }
                        if($true == 0){
                            $temp = [ 
                                        'category' => $row->categoryID,
                                        'counter' => $row->cnt_keyword,
                                    ];
                            array_push($similar,$temp);
                        }
                    }
                }
            }
        }
        $quotes = [];
        $arr = (array)$similar;
        $countSimilar = 0;
        foreach($arr as $row){
            if (!empty($row)){
                $countSimilar++;
            }
        }
        //sort by highest counter
        usort($similar, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        $newTotal = $similar;
        // return top 3 highest counter
        foreach(array_splice($similar,0,3) as $value){
            $quotes = DB::table('matchquote')
                    ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
                    ->select('quotes.*')
                    ->where('matchquote.categoryID',$value['category'])
                    ->get();
        }
        //store quotes that matches post
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
        //if way match kwords sa db, random quotes and store
        if($countSimilar == 0 ){
            $temp1 = Quote::orderByRaw("RAND()")->take(30)->get();
            foreach($temp1 as $row1){
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
                $match->quoteID = $row1->quoteID;
                $match->save();
            }
        }
        // store top 3 categories sa user's post
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
// $quotes = [];
//         $n_quotes = [];
//         $videos = [];
//         $result = [];
//         $comp = [];
//         $n_comp = [];
//         $usersPost = PostStatus::where('post_user_id',$id)->orderBy('post_id','desc')->get();
//         $catPost = TopCategoriesForPost::get();

//         foreach($usersPost as $post){ //selects quotes for posts
//             $temp = MatchPostQuote::where('post_id', $post['post_id'])->orderByRaw("RAND()")->take(3)->get();
//             array_push($quotes,$temp);
//             foreach($catPost as $row){ // gets Top 3 Categories based on PostID which will be used in slecting video
//                 if ($post->post_id == $row->post_id){
//                     array_push($result,$row);
//                 }
//             }
//         }
//         foreach($result as $row){ //selecting videos based on categoryID
//             $temp = MatchVideo::where('categoryID', $row['categoryID'])->orderByRaw("RAND()")->take(2)->get();
//             foreach($temp as $row1){ // storing postID and videoID for comparing sa view
//                 $tem = [
//                     'post_id' => $row['post_id'],
//                     'videoID' => $row1->videoID,
//                 ];
//                 array_push($comp,$tem);
//             }
//             array_push($videos,$temp);
//         }
// return view("user.postList",compact('usersPost','quotes','videos','comp'));
    }   

    public function update($postid){
        $record = PostStatus::where("post_id",$postid)->first();
        $feelings = PostFeeling::get();
        $problems = Problem::get();
        return view('user.editPost',compact('record','feelings','problems'));
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
        // else {
        //     $feeling->delete();
        // }
        $words = explode(' ',$request->post);
        $similar = [];
        for( $i = 0 ; $i < count($words) ; $i++ ){
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$i])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                if(empty($similar)){
                    foreach($ss as $row){
                        $temp = [ 
                            'category' => $row->categoryID,
                            'counter' => $row->cnt_keyword,
                        ];
                        array_push($similar,$temp);
                    }   
                }
                else{
                    foreach($ss as $row){
                        $true = 0;
                        for($i = 0 ; $i < count($similar); $i++){
                            if ($similar[$i]['category'] == $row->categoryID){
                                $similar[$i]['counter'] = $similar[$i]['counter'] + $row->cnt_keyword;
                                $true++;
                            }
                        }
                        if($true == 0){
                            $temp = [ 
                                        'category' => $row->categoryID,
                                        'counter' => $row->cnt_keyword,
                                    ];
                            array_push($similar,$temp);
                        }
                    }
                }
            }
        }
        $quotes = [];
        $arr = (array)$similar;
        $countSimilar = 0;
        foreach($arr as $row){
            if (!empty($row)){
                $countSimilar++;
            }
        }
        //sort by highest counter
        usort($similar, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        $newTotal = $similar;
        // return top 3 highest counter
        foreach(array_splice($similar,0,3) as $value){
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

    // public function deletePost($postid){
    //     $userid = Auth::id();
    //     $record = PostStatus::where("post_id",$postid);
    //     $record->delete();
    //     $usersPost = PostStatus::where('post_user_id',$userid)->orderBy('post_id','desc')->get();
    //     $feelings = PostFeeling::get();
    //     return redirect(url('/wall'));
    // }

    public function deletePost(Request $request){
        // return $request;
        // $userid = Auth::id();
        $record = PostStatus::where("post_id",$request['post_id'])->first();
        $record->delete();
        return response()->json([
            'data' => 'Successful',
        ]);
        // $usersPost = PostStatus::where('post_user_id',$userid)->orderBy('post_id','desc')->get();
        // $feelings = PostFeeling::get();
        // return redirect(url('/wall'));
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

    public function getUserPost(Request $request){
        $userID = Token::where("token", $request['token'])->value('token_user_id');
        $posts = PostStatus::where("post_user_id",$userid)->get();
        return response()->json([
                'data' => $posts
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getComments(Request $request){
        $postid = $request['post_id'];
        $commentDetails = DB::table('commentpost')
                        ->join('systemusers','commentpost.user_id','=','systemusers.user_id')
                        ->select('commentpost.commentID','commentpost.comment_content','systemusers.user_id','systemusers.first_name','systemusers.last_name')
                        ->where('commentpost.post_id',$postid)
                        ->get();
        return response()->json([
            'data' => $commentDetails
        ]);
    }

    public function savePost1(Request $request){
        $feelingID = ' ';
        $id = Token::where('token',$request['token'])->value('token_user_id');
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
        if($request->feeling != "null") {
            return $request->feeling;
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
        $words = explode(' ',$request->post);
        $similar = [];
        // return $words;

        // compare words sa db keywords, group by categoryID and add its counter
        for( $j = 0 ; $j < count($words) ; $j++ ){
            $cid = ' ';
            $kw_count = 0;
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$j])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                if(empty($similar)){
                    foreach($ss as $row){
                        $temp = [ 
                            'category' => $row->categoryID,
                            'counter' => $row->cnt_keyword,
                        ];
                        array_push($similar,$temp);
                    }   
                }
                else{
                    foreach($ss as $row){
                        $true = 0;
                        for($i = 0 ; $i < count($similar); $i++){
                            if ($similar[$i]['category'] == $row->categoryID){
                                $similar[$i]['counter'] = $similar[$i]['counter'] + $row->cnt_keyword;
                                $true++;
                            }
                        }
                        if($true == 0){
                            $temp = [ 
                                        'category' => $row->categoryID,
                                        'counter' => $row->cnt_keyword,
                                    ];
                            array_push($similar,$temp);
                        }
                    }
                }
            }
        }
        $quotes = [];
        $arr = (array)$similar;
        $countSimilar = 0;
        foreach($arr as $row){
            if (!empty($row)){
                $countSimilar++;
            }
        }
        return $similar;
        //sort by highest counter
        usort($similar, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        $newTotal = $similar;
        // store top 3 categories sa user's post
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


        
        // return $top;
        // return $newTotal;
        // // return top 3 highest counter
        // foreach(array_splice($similar,0,3) as $value){
        //     $quotes = DB::table('matchquote')
        //             ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
        //             ->select('quotes.*')
        //             ->where('matchquote.categoryID',$value['category'])
        //             ->get();
        // }
        // //store quotes that matches post
        // foreach($quotes as $quote){
        //     $match = new MatchPostQuote();
        //     if (MatchPostQuote::get() == EmptyMuch::get()){
        //         $match->matchID = "M00000000001";
        //     }
        //     else {
        //         $row = MatchPostQuote::orderby('matchID','desc')->first();
        //         $temp = substr($row["matchID"],1);
        //         $temp = (int)$temp + 1;
        //         $newPostID = "M".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
        //         $match->matchID = $newPostID;
        //     }
        //     $match->post_id = $pID;
        //     $match->quoteID = $quote->quoteID;
        //     $match->save();
        // }
        // //if way match kwords sa db, random quotes and store
        // if($countSimilar == 0 ){
        //     $temp1 = Quote::orderByRaw("RAND()")->take(30)->get();
        //     foreach($temp1 as $row1){
        //         $match = new MatchPostQuote();
        //         if (MatchPostQuote::get() == EmptyMuch::get()){
        //             $match->matchID = "M00000000001";
        //         }
        //         else {
        //             $row = MatchPostQuote::orderby('matchID','desc')->first();
        //             $temp = substr($row["matchID"],1);
        //             $temp = (int)$temp + 1;
        //             $newPostID = "M".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
        //             $match->matchID = $newPostID;
        //         }
        //         $match->post_id = $pID;
        //         $match->quoteID = $row1->quoteID;
        //         $match->save();
        //     }
        // }
    }

}
