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

    public function registerSeeker(Request $request){
        if ($request['female']){
            $gender = $request['female'];
        } else {
            $gender = $request['male'];
        }

        if ($request['confirm'] == $request['password']){
            SystemUser::create([
                'first_name' => $request['fname'],
                'last_name' => $request['lname'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'gender' => $gender,
                // 'gender' => $request['gender'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'userType' => 'seeker',
            ]);
            //generating TOKEN_ID and store userID to token table
            $userID = SystemUser::where("username", $request['username'])->value('user_id');
            $token = new Token();
            if (Token::get() == EmptyMuch::get()){
                $token->token_id = "T00000000001";
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
            $interests = Interests::get();
            foreach($interests as $interest){
                for ($i = 0; $i < count($usersInterests); $i++){
                    if ($interest['interestName'] == $usersInterests[$i]){
                        array_push($db_usersInterests,$interest['interestName']);
                    }
                }
            }
            //store interests to usersinterests
            foreach($db_usersInterests as $user_interest){
                UsersInterests::create([
                    'user_ID' => $userID,
                    'interestID' => $user_interest,
                ]);
            }
            return response(200);
        }
    }

    public function registerFacilitator(Request $request){
        if ($request['female']){
            $gender = $request['female'];
        } else {
            $gender = $request['male'];
        }

        if ($request['confirm'] == $request['password']){
            SystemUser::create([
                'first_name' => $request['fname'],
                'last_name' => $request['lname'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'gender' => $gender,
                // 'gender' => $request['gender'],
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'userType' => 'facilitator',
            ]);

            $userID = SystemUser::where("username", $request['username'])->value('user_id');
            $token = new Token();
            if (Token::get() == EmptyMuch::get()){
                $token->token_id = "T00000000001";
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
            $interests = Interests::get();
            foreach($interests as $interest){
                for ($i = 0; $i < count($usersInterests); $i++){
                    if ($interest['interestName'] == $usersInterests[$i]){
                        array_push($db_usersInterests,$interest['interestName']);
                    }
                }
            }
            //store interests to usersinterests
            foreach($db_usersInterests as $user_interest){
                UsersInterests::create([
                    'user_ID' => $userID,
                    'interestID' => $user_interest,
                ]);
            }
            return response(200);
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
        foreach($userDetails as $detail){
            $user_token = $detail->token;
            $userID = $detail->user_id;
        }
        if ($result){
            return response()->json([
                'token' => $user_token,
                'user_id' => $userID,
                ]);
        }else {
            return response("Not Successful",500);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->to(route('login'));
    }
}
