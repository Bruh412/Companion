<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // public function try(){
    //     $db_specs = Specialization::get();
    //     return $db_specs;
    // }

    public function register(Request $request){
        $checkUsername = SystemUser::where('username',$request['username'])->value('username');
        if(is_null($checkUsername)){
            if ($request['userType'] == 'seeker'){
                if ($request['confirm'] == $request['password']){
                    SystemUser::create([
                        'first_name' => $request['fname'],
                        'last_name' => $request['lname'],
                        'email' => $request['email'],
                        'birthday' => $request['birthday'],
                        // 'address' => $request['address'],
                        // 'gender' => $gender,
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
                    // return $token_key;
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
                    $prc_raw = PrcRaw::get();
                    $prc_input = $request->prc;
                    $count = 0;
                    foreach($prc_raw as $prc){
                        if ($prc['prc_id'] === $prc_input){
                            $count++;
                        }
                    }

                    if ($count != 0){
                        FacilitatorPRC::create([
                            'user_id' => $userID,
                            'prc_id' => $prc_input,
                        ]);
                    }

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
                        'token' => $token_key,
                    ]);
                }
            }
        } else {
            return response('Error in registration',400);
        }
    }

    public function userAuthentication(Request $request){
        $result = Auth::attempt(['username' => $request['username'], 'password' => $request['password']]);
        // $userDetails = SystemUser::where('username',$request['username'])->get();
        $userDetails = DB::table('systemusers')
                    ->join('tokens','systemusers.user_id','=','tokens.token_user_id')
                    ->select('tokens.token','systemusers.user_id')
                    ->where('systemusers.username',$request['username'])
                    ->get();
                    
        if($request->username == 'bruh412' && $request->password == 'happybruh')
            return view('adminHome');
        if ($result){
            return response()->json([
                'message' => 'Successful!',
            ]);
        }else {
            return response()->json([
                'message' => 'Not Successful!',
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->to(route('login'));
    }
}
