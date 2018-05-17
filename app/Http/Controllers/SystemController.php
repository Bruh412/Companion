<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemUser;
use App\QueueTalkCircle;
use App\EmptyMuch;
use App\customClasses\QueueScore;
use App\customClasses\QueueScoreContainer;


class SystemController extends Controller
{
    public function addUserToTalkCircleQueue($userID, $feeling){
        
        // groups are based on 3 things: CATEGORIES/INTERESTS, PROBLEMS, AND LOCATION
        //                                          3             1             2      
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
            $queue->feeling = $feeling;
            $queue->save();
            
            
            return response("Added to Queue!", 200);
        }
        else{
            //IN THE QUEUE
            // dd("Hi");
            $queue = QueueTalkCircle::where("user_id",$userID)->delete();
            // $queue->delete();
            return response("Removed from Queue!", 200);
        }
    }

    public function checkQueue($id){
        $queue = QueueTalkCircle::where("user_id", $id)->get();
        $list = QueueTalkCircle::where([["feeling", $queue[0]->feeling]])->orderBy('feeling', 'asc')->orderBy('queueID', 'asc')->get();
        //  dd($list);
        if(count($list) >= 4){
            for ($i=0; $i < 3; $i++) { 
                // $list[$i]->delete();
                print_r($list[$i]->user_id);
            }
            return response("Group found!", 200);
        }
        else{
            return response("Group not yet found", 200);
        }
    }

    public function checkQueue1($id){
        $scoreslist = new QueueScoreContainer;
        // dd(SystemUser::findOrFail($id)->interests);
        $userinQueue = QueueTalkCircle::where("user_id", $id)->get();
        $mainUser = SystemUser::findOrFail($id);
        $list = QueueTalkCircle::get();
        
        foreach ($list as $row) {
            // dd($userinQueue[0]->queueID);
            if($row->queueID != $userinQueue[0]->queueID){
                
                $score = new QueueScore();
                $score->setUserID($row->queueID);
                $points = 0;

                if($row->feeling == $userinQueue[0]->feeling)
                    $points++;
                $otherUser = SystemUser::findOrFail($row->user_id);
                foreach ($otherUser->interests as $key) {
                    // if($key->interestName == $mainUser->interest->interestName){
                    //     dd("Hello");
                    //     $points++;
                    // }
                    foreach ($mainUser->interests as $key_1) {
                        if($key['interestID'] == $key_1['interestID']){
                                $points++;
                            }
                    }
                }
                
                $score->setScore($points);
                $scoreslist->addToContainer($score);
            }
        }
        // dd($scoreslist);
        // ---- SORTING
        $sortedArr = array();

        foreach ($scoreslist->getContainer() as $score) {
            echo($score->getUserID()." --- ".$score->getScore()."<br>");
            
        }
    }
}
