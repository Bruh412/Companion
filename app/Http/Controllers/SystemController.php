<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemUser;
use App\QueueTalkCircle;
use App\EmptyMuch;


class SystemController extends Controller
{
    public function addUserToTalkCircleQueue($userID){
        // groups are based on 3 things: CATEGORIES/INTERESTS, PROBLEMS, AND LOCATION
        // 
        // dd($user);

        $user = SystemUser::findOrFail($userID);
        // dd(QueueTalkCircle::where("user_id",$userID)->get());
        if(QueueTalkCircle::where("user_id",$userID)->get() == EmptyMuch::get()){
            //NOT IN THE QUEUE
            // dd("Hello");
            $queue = new QueueTalkCircle;
            if(QueueTalkCircle::get() == EmptyMuch::get()){
                $queue->queueID = "Q00001";
            }
            else{
                $row = QueueTalkCircle::orderby('queueID', 'desc')->first();
                $temp = substr($row['queueID'], 1);
                $temp =(int)$temp + 1;
                $id = "Q".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                $queue->queueID = $id;
            }
            $queue->user_id = $user->user_id;
            $queue->save();
            
            return response("Added to Queue!", 200);
        }
        else{
            //IN THE QUEUE
            // dd("Hi");
            $queue = QueueTalkCircle::where("user_id",$userID)->get();
            $queue->delete();
            return response("Removed from Queue!", 200);
        }
    }

    public function checkQueue(){
        
    }
}
