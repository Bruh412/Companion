<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemUser;
use App\QueueTalkCircle;
use App\EmptyMuch;
use App\UsersInterests;

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

    ///////////////////////////////////////////////////////

        private function validateDuplicates($valueToBeChecked, $array){
            foreach ($array as $key) {
                if($key == $valueToBeChecked)
                    return true;
            }
            return false;
        }

        private function checkClusterChange($oldClusters, $newClusters){
            foreach ($oldClusters as $row) {
                foreach ($newClusters as $newRow) {
                    if($row != $newRow)
                        return true;
                }
            }

            return false;
        }   

        public function checkQueue2($id){
            $userQueue = QueueTalkCircle::where("user_id", $id)->get()[0];
            $sameProblemUsers = QueueTalkCircle::where("problem", $userQueue->problem)->get();
            
            // ----- K-Means Section
            $clusterContainer = array();
            $centroidCount = count($sameProblemUsers)/4;
                // assigning centroids
                for ($i=0; $i < $centroidCount; $i++) {
                    $random = rand(0,$centroidCount);
                    if(!$this->validateDuplicates($sameProblemUsers[$random], $clusterContainer)){
                        $clusterContainer[$i] = array();                        
                        $clusterContainer[$i][0] = $sameProblemUsers[$random];
                    }
                }

                // cluster iterations
            // $oldContainer = array();
            // $newContainer = array();

            // for ($i=0; $oldContainer == $newContainer ; $i++) { 
            //     $oldContainer = $clusterContainer;
                foreach ($clusterContainer as $cluster) {
                    for ($j=0; $j < count($sameProblemUsers); $j++) { 
                       $eucLat = pow($cluster[0]->latitude - $sameProblemUsers[$j]->latitude, 2);
                       $eucLong = pow($cluster[0]->longitude - $sameProblemUsers[$j]->longitude, 2);
                       var_dump($eucLat + $eucLong);
                       echo "<br><br><br>";

                       $clusterInterests = UsersInterests::where("user_id",$cluster[0]->user_id)->get();
                       $sameProblemUsersInterests = UsersInterests::where("user_id",$sameProblemUsers[$j]->user_id)->get();

                       dd($clusterInterests);

                    //    foreach ($ as $key => $value) {
                    //        # code...
                    //    }
                    }
                }
            // }
            // var_dump('yeet');
            // ----- end of section

            // dd($clusterContainer);
        }
}

