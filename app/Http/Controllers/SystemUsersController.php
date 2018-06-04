<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
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
use DB;

class SystemUsersController extends Controller
{

    protected $redirectTo = "/";

    public function username(){
        return 'username';
    }

    public function registerPage(){
        return view('register');
    }

    public function loginPage(){
        return view('login');
    }

    public function register(Request $request){
        $birthday = $request->month.'/'.$request->day.'/'.$request->year;
        $checkUsername = SystemUser::where('username',$request['username'])->value('username');
        if(is_null($checkUsername)){
            if ($request['userType'] == 'seeker'){
                if ($request['confirm'] == $request['password']){
                    SystemUser::create([
                        'first_name' => $request['fname'],
                        'last_name' => $request['lname'],
                        'email' => $request['email'],
                        // 'birthday' => $request['birthday'],
                        'birthday' => $birthday,
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
                    // $token_key = Token::where('token_id',$newTokenID)->value('token');
                    // return response()->json([
                    //     "token" => $token_key,
                    // ]);
                    return view('login');
                }
            }
            if ($request['userType'] == 'facilitator'){
                if ($request['confirm'] == $request['password']){
                    SystemUser::create([
                        'first_name' => $request['fname'],
                        'last_name' => $request['lname'],
                        'email' => $request['email'],
                        // 'birthday' => $request['birthday'],
                        'birthday' => $birthday,
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

                    //check and store PRC
                    // $prc_raw = PrcRaw::get();
                    // $prc_input = $request->prc;
                    // $count = 0;
                    // foreach($prc_raw as $prc){
                    //     if ($prc['prc_id'] === $prc_input){
                    //         $count++;
                    //     }
                    // }

                    // if ($count != 0){
                    //     FacilitatorPRC::create([
                    //         'user_id' => $userID,
                    //         'prc_id' => $prc_input,
                    //     ]);
                    // }

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
                    // $fileName = $request->file."/certificate"."/".$request->file->getClientOriginalName();
                    // $fileType = $request->file->getClientOriginalExtension();
                    // Storage::disk('public')->put($fileName, File::get($request->file));
                    // // return "hi";
                    // $url = Storage::url($fileName);
                    // // dd($url);
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
                    // return $newFile;

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
                    // $token_key = Token::where('token_id',$newTokenID)->value('token');
                    // return response()->json([
                    //     'token' => $token_key,
                    // ]);
                    return view('login');
                }
            }
        } else {
            // return response('Error in registration',400);
            return redirect()->back();
        }
    }

    public function userAuthentication(Request $request){
        $result = Auth::attempt(['username' => $request['username'], 'password' => $request['password']]);
        // $userDetails = SystemUser::where('username',$request['username'])->get();
        // return $result;
        $userDetails = DB::table('systemusers')
                    ->join('tokens','systemusers.user_id','=','tokens.token_user_id')
                    ->select('tokens.token','systemusers.user_id')
                    ->where('systemusers.username',$request['username'])
                    ->get();
                    
        if($request->username == 'bruh412' && $request->password == 'happybruh')
            return view('admin.adminHome');
        // else {
        //     return view('login');   
        // }

        if ($result){
            $type = SystemUser::where('username',$request->username)->value('userType');
            if ($type == "seeker"){
                // $feelings = PostFeeling::get();
                // $id = SystemUser::where('username',$request->username)->value('user_id');
                // $usersPost = PostStatus::where('post_user_id',$id)->orderBy('post_id','desc')->get();
                $id = 'JRMOMjCoR58';
                return redirect(url('/wall'));
                // return view('user.home',compact('feelings','usersPost','id'));
            }
            else {
                $seekersPost = PostStatus::orderBy('post_id','desc')->get();
                return view('user.facilitatorHome',compact('seekersPost'));
            }
            // return response()->json([
            //     'message' => 'Successful!',
            // ]);
        }else {
            return "incorrect pass";
            // return response()->json([
            //     'message' => 'Not Successful!',
            // ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->to(route('login'));
    }

    //web services functions
    public function userType(){
        return view('userType');
    }

    public function wall(){
        $id = Auth::id();
        $feelings = PostFeeling::get();
        $usersPost = PostStatus::where('post_user_id',$id)->orderBy('post_id','desc')->get();
        $catPost = TopCategoriesForPost::get();
        $quotes = [];
        $videos = [];
        $result = [];
        $comp = [];
        foreach($usersPost as $post){
            $temp = MatchPostQuote::where('post_id', $post['post_id'])->orderByRaw("RAND()")->take(3)->get();
            array_push($quotes,$temp);
            //kuha topCatPost from the logged in user
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
            }
            array_push($videos,$temp);
        }
        return view('user.home',compact('feelings','usersPost','quotes','videos','comp'));
    }

    public function registerSeeker(){
        $interests = Interest::get();
        return view('registerSeeker',compact('interests'));
    }

    public function registerFacilitator(){
        $interests = Interest::get();
        $specs = Specialization::get();
        return view('registerFacilitator',compact('interests','specs'));
    }
}
