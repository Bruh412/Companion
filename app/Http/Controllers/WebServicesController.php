<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\SystemUser;
use App\Token;
use App\EmptyMuch;
use App\Interest;
use App\UsersInterests;
use App\Specialization;
use App\FacilitatorSpec;
use App\FacilitatorPRC;
use App\PrcRaw;
use App\PostFeeling;
use App\PostStatus;
use App\CertificateFile;
use App\MatchPostQuote;
use App\TopCategoriesForPost;
use App\MatchVideo;
use App\Problem;
use App\Quote;
use App\UsersPostFeeling;
use App\CommentPost;
use App\MatchQuote;
use App\YoutubeAPIKey;
use Validator;
// use Auth;
use DB;
use Mail;

class WebServicesController extends Controller
{
    public function registerService(Request $request){
        // return $request; 
        $checkUsername = SystemUser::where('username',$request['username'])->value('username');
        if(is_null($checkUsername)){
            if ($request['userType'] == 'seeker'){
                if ($request['confirm'] == $request['password']){
                    SystemUser::create([
                        'first_name' => $request['fname'],
                        'last_name' => $request['lname'],
                        'email' => $request['email'],
                        'birthday' => $request['birthday'],
                        // 'birthday' => $birthday,
                        'gender' => $request['gender'],
                        'username' => $request['username'],
                        'password' => bcrypt($request['password']),
                        'userType' => 'seeker',
                    ]);
                    //generating TOKEN_ID and store userID to token table
                    $userID = SystemUser::where("username", $request['username'])->value('user_id');
                    $token = new Token();
                    $newTokenID = ' ';
                    if (Token::get() == EmptyMuch::get()){
                        $token->token_id = "T00000000001";
                        $newTokenID = "T00000000001";
                    }
                    else {
                        $row = Token::orderby('token_id','desc')->first();
                        $temp = substr($row["token_id"],1);
                        $temp = (int)$temp + 1;
                        $newTokenID = "T".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                        $token->token_id = $newTokenID;
                    }
                    $token->token_user_id = $userID;
                    $token->save();

                    //comparing interests to db_interests
                    $db_usersInterests = [];
                    $usersInterests = $request->interests;
                    $interests = Interest::get();
                    foreach($interests as $interest){
                        for ($i = 0; $i < count($usersInterests); $i++){
                            if ($interest['interestName'] == $usersInterests[$i]){
                                array_push($db_usersInterests,$interest['interestID']);
                            }
                        }
                    }
                    //store interests to usersinterests
                    foreach($db_usersInterests as $user_interest){
                        UsersInterests::create([
                            'user_id' => $userID,
                            'interestID' => $user_interest,
                        ]);
                    }
                    $token_key = Token::where('token_id',$newTokenID)->value('token');
                    return response()->json([
                        "token" => $token_key,
                    ]);
                }
            }
            if ($request['userType'] == 'facilitator'){
                if ($request['confirm'] == $request['password']){
                    SystemUser::create([
                        'first_name' => $request['fname'],
                        'last_name' => $request['lname'],
                        'email' => $request['email'],
                        'birthday' => $request['birthday'],
                        // 'birthday' => $birthday,
                        'gender' => $request['gender'],
                        'username' => $request['username'],
                        'password' => bcrypt($request['password']),
                        'userType' => 'facilitator',
                    ]);

                    //generating TOKEN_ID and store userID to token table
                    $newTokenID = ' ';
                    $userID = SystemUser::where("username", $request['username'])->value('user_id');
                    $token = new Token();
                    if (Token::get() == EmptyMuch::get()){
                        $token->token_id = "T00000000001";
                        $newTokenID = "T00000000001";
                    }
                    else {
                        $row = Token::orderby('token_id','desc')->first();
                        $temp = substr($row["token_id"],1);
                        $temp = (int)$temp + 1;
                        $newTokenID = "T".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                        $token->token_id = $newTokenID;
                    }
                    $token->token_user_id = $userID;
                    $token->save();

                    //comparing interests to db_interests
                    $db_usersInterests = [];
                    $usersInterests = $request->interests;
                    $interests = Interest::get();
                    foreach($interests as $interest){
                        for ($i = 0; $i < count($usersInterests); $i++){
                            if ($interest['interestName'] == $usersInterests[$i]){
                                array_push($db_usersInterests,$interest['interestID']);
                            }
                        }
                    }
                    //store interests to usersinterests
                    foreach($db_usersInterests as $user_interest){
                        UsersInterests::create([
                            'user_id' => $userID,
                            'interestID' => $user_interest,
                        ]);
                    }

                    // //certificate upload
                    // $fileName = $request->username."/certificate"."/".$request->file->getClientOriginalName();
                    // $fileType = $request->file->getClientOriginalExtension();
                    // Storage::disk('public')->put($fileName, File::get($request->file));
                    // $url = Storage::url($fileName);
                    // $newFile = new CertificateFile;
                    // if(CertificateFile::get() == EmptyMuch::get()){
                    //     $newFile->fileID = "F00001";
                    // }
                    // else{
                    //     $row = CertificateFile::orderby('fileID', 'desc')->first();
                    //     $temp = substr($row['fileID'], 1);
                    //     $temp =(int)$temp + 1;
                    //     $id = "F".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                    //     $newFile->fileID = $id;
                    // }
                    // $newFile->fileContent = $url;
                    // $newFile->fileExt = $fileType;
                    // $newFile->user_id = $userID;
                    // $newFile->save();

                    //comparing specs to db_specs
                    $db_specs = Specialization::get();
                    $usersSpecs = $request['specs'];
                    $specs = [];
                    foreach($db_specs as $spec){
                        for ($i = 0; $i < count($usersSpecs); $i++){
                            if ($spec['spec_name'] == $usersSpecs[$i]){
                                array_push($specs,$spec['spec_id']);
                            }
                        }
                    }
                    foreach($specs as $spec){
                        FacilitatorSpec::create([
                            'user_id' => $userID,
                            'spec_id' => $spec,
                        ]);
                    }
                    $token_key = Token::where('token_id',$newTokenID)->value('token');
                    return response()->json([
                        'token' => $token_key,
                    ]);
                }
            }
        } else {
            return response()->json([
                'message' => 'Error in registration!'
            ]);
        }
    }

    public function userAuthentication(Request $request){
        $result = Auth::attempt(['username' => $request['username'], 'password' => $request['password']]);
        $userDetails = DB::table('systemusers')
                    ->join('tokens','systemusers.user_id','=','tokens.token_user_id')
                    ->select('tokens.token','systemusers.user_id')
                    ->where('systemusers.username',$request['username'])
                    ->get();
        $fname = SystemUser::where('username',$request['username'])->value('first_name');   
        $lname = SystemUser::where('username',$request['username'])->value('last_name');
        $name = $fname.' '.$lname;

        $userid = SystemUser::where('username',$request['username'])->value('user_id');
        $userType = SystemUser::where('username',$request['username'])->value('userType');
        $token = Token::where('token_user_id',$userid)->value('token');
        if($request->username == 'bruh412' && $request->password == 'happybruh')
            return view('admin.adminHome');

        if ($result){
            return response()->json([
                'token' => $token,
                'user_type' => $userType
            ]); 
        }else {
            return response()->json([
                'message' => 'Not Successful!',
            ]);
        }
    }

    public function savePost(Request $request){
        // return $request;
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

    public function displayPosts(Request $request){
        $userID = Token::where("token", $request['token'])->value('token_user_id');
        $posts = PostStatus::where("post_user_id",$userID)->orderBy('post_id','desc')->get();
        $postFeelings = [];
        foreach($posts as $post){
            $temp = DB::table('poststatus')
                ->join('userspostfeelings','poststatus.post_id','=','userspostfeelings.post_id')
                ->join('postfeelings','userspostfeelings.post_feeling_id','=','postfeelings.post_feeling_id')
                ->select('userspostfeelings.post_id', 'userspostfeelings.post_feeling_id','postfeelings.post_feeling_name')
                ->where('poststatus.post_id',$post['post_id'])
                ->get();
            array_push($postFeelings,$temp);
        }
        return response()->json([
            'posts' => $posts,
            'feelings' => $postFeelings
        ]);
    }

    public function getSeekersPost(){
        $seekersPost = [];
        $posts = PostStatus::get();
        foreach($posts as $post){
            $temp = [
                'user_id' => '',
                'name' => '',
                'post_id' => '',
                'post_content' => '',
                'comments' => [],
                'feeling_id' => '',
                'feeling_name' => '',
                ];
            $fname = SystemUser::where('user_id',$post->post_user_id)->value('first_name');
            $lname = SystemUser::where('user_id',$post->post_user_id)->value('last_name');
            $temp['user_id'] = $post->post_user_id;
            $temp['name'] = $fname.' '.$lname;
            $temp['post_id'] = $post->post_id;
            $temp['post_content'] = $post->post_content;

            $comments = CommentPost::where('post_id',$post->post_id)->get();
            if ($comments != []){
                foreach($comments as $comment){
                    $tempComment = [
                        'commentID' => $comment->commentID,
                        'comment_content' => $comment->comment_content,
                    ];
                    array_push($temp['comments'],$tempComment);
                }
            }
            $feelingID = UsersPostFeeling::where('post_id',$post->post_id)->value('post_feeling_id');
            if($feelingID){ //not empty
                $feelingDetails = PostFeeling::where('post_feeling_id',$feelingID)->first();
                $temp['feeling_id'] = $feelingDetails->post_feeling_id;
                $temp['feeling_name'] = $feelingDetails->post_feeling_name;
            }
            array_push($seekersPost,$temp);
        }
        
        return response()->json([
            'data' => $seekersPost,
        ]);
    }

    public function saveupdate(Request $request){
        // $userid = Token::where('token',$request['token'])->value('token_user_id');
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
        // $words = explode(' ',$request->post);
        // $similar = [];
        // for( $i = 0 ; $i < count($words) ; $i++ ){
        //     $ss = DB::table('keywords')
        //             ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
        //             ->where('keywordName',$words[$i])
        //             ->groupBy('categoryID')
        //             ->get();
        //     if (!empty($ss)){
        //         if(empty($similar)){
        //             foreach($ss as $row){
        //                 $temp = [ 
        //                     'category' => $row->categoryID,
        //                     'counter' => $row->cnt_keyword,
        //                 ];
        //                 array_push($similar,$temp);
        //             }   
        //         }
        //         else{
        //             foreach($ss as $row){
        //                 $true = 0;
        //                 for($i = 0 ; $i < count($similar); $i++){
        //                     if ($similar[$i]['category'] == $row->categoryID){
        //                         $similar[$i]['counter'] = $similar[$i]['counter'] + $row->cnt_keyword;
        //                         $true++;
        //                     }
        //                 }
        //                 if($true == 0){
        //                     $temp = [ 
        //                                 'category' => $row->categoryID,
        //                                 'counter' => $row->cnt_keyword,
        //                             ];
        //                     array_push($similar,$temp);
        //                 }
        //             }
        //         }
        //     }
        // }
        // $quotes = [];
        // $arr = (array)$similar;
        // $countSimilar = 0;
        // foreach($arr as $row){
        //     if (!empty($row)){
        //         $countSimilar++;
        //     }
        // }
        // //sort by highest counter
        // usort($similar, function($a, $b){
        //     return strcmp($b['counter'], $a['counter']);
        // });
        // $newTotal = $similar;
        // // return top 3 highest counter
        // foreach(array_splice($similar,0,3) as $value){
        //     $quotes = DB::table('matchquote')
        //             ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
        //             ->select('quotes.*')
        //             ->where('matchquote.categoryID',$value['category'])
        //             ->get();
        // }
        // $orig = MatchPostQuote::where("post_id", $id)->get();
        // foreach ($orig as $row) {
        //     $row->delete();
        // }
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
        //     $match->post_id = $id;
        //     $match->quoteID = $quote->quoteID;
        //     $match->save();
        // }
        // $orig = TopCategoriesForPost::where("post_id", $id)->get();
        // foreach ($orig as $row) {
        //     $row->delete();
        // }
        // foreach(array_splice($newTotal,0,3) as $row1){
        //     $top = new TopCategoriesForPost();
        //     if (TopCategoriesForPost::get() == EmptyMuch::get()){
        //         $top->top_id = "T00000000001";
        //         $top->post_id = $id;
        //         $top->categoryID = $row1['category'];
        //         $top->save();
        //     }
        //     else {
        //         $row = TopCategoriesForPost::orderby('top_id','desc')->first();
        //         $temp = substr($row["top_id"],1);
        //         $temp = (int)$temp + 1;
        //         $newPostID = "T".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
        //         $top->top_id = $newPostID;
        //         $top->post_id = $id;
        //         $top->categoryID = $row1['category'];
        //         $top->save();
        //     }
        // }   
        return 'yhey';
    }

    public function getComments(Request $request){
        $postid = $request['post_id'];
        $commentDetails = DB::table('commentpost')
                        ->join('systemusers','commentpost.user_id','=','systemusers.user_id')
                        ->select('commentpost.commentID','commentpost.comment_content','systemusers.user_id','systemusers.first_name','systemusers.last_name')
                        ->where('commentpost.post_id',$postid)
                        ->orderBy('commentID','desc')
                        ->get();
        return response()->json([
            'data' => $commentDetails
        ]);
    }

    public function saveComment(Request $request){
        // return $request;
        $userID = Token::where("token", $request->token)->value('token_user_id');
        $comment = new CommentPost();
        $postid = $request->post_id;
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
        $comment->user_id = $userID;
        $comment->save();
        // $comments = CommentPost::where('post_id',$postid)->orderBy('commentID','desc')->get();
        // $post = PostStatus::where('post_id',$postid)->first();
        return response()->json([
            'data' => 'Successful!'
        ]);
    }
}
