<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemUser;
use App\QueueTalkCircle;
use App\EmptyMuch;
use App\UsersInterests;
use App\PostFeeling;
use App\Interest;
use App\QueueUsersProblem;
use App\SystemConfig;
use App\Problem;
use App\Specialization;
use App\FacilitatorSpec;
use App\SpecMatchProblem;

class SystemController extends Controller
{
    public function viewConfig(){
        $config = SystemConfig::findOrFail(1);
        return view('SystemConfig')->with(['config'=>$config->toArray()]);
    }

    public function editConfig($field){
        return view('editConfigPage')->with(['field'=>$field]);
    }

    public function saveEditConfig($field, Request $req){
        $config = SystemConfig::findOrFail(1);
        if($req->newValue != null){
            $config[$field] = $req->newValue;
            $config->save();
        }
        return view('SystemConfig')->with(['config'=>$config->toArray()]);
    }

    public function addUserToTalkCircleQueue($userID, Request $req){ 
        // dd($req);

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
            $QID = $queue->queueID;
            $SID = $user->user_id;

            $queue->user_id = $user->user_id;
            $queue->longitude = $req->long;
            $queue->latitude = $req->lat;
            $queue->save();
        
            foreach ($req->problems as $problemID) {
                $queueUserProblem = new QueueUsersProblem;
                $queueUserProblem->queueID = $QID;
                $queueUserProblem->problem_id = Problem::findOrFail($problemID)->problem_id;
                $queueUserProblem->save();
            }
            
            // dd(url('/checkQueue'.'/'.$SID));
            // dd("hello");
            // return response("Added to Queue!", 200);
            return redirect(url('/checkQueue'.'/'.$SID));
        }
        else{
            //IN THE QUEUE
            // dd("Hi");
            $queue = QueueTalkCircle::where("user_id",$userID)->delete();
            // $queue->delete();
            return response("Removed from Queue!", 200);
        }
    }

    public function addFaciToTalkCircleQueue($userID, Request $req){ 
        // dd($req->long);

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
            $queue->longitude = $req->long;
            $queue->latitude = $req->lat;
            $queue->save();

            // return redirect(url('/checkQueue'.'/'.$SID));
            return redirect()->back();
        }
        else{
            //IN THE QUEUE
            // dd("Hi");
            $queue = QueueTalkCircle::where("user_id",$userID)->delete();
            // $queue->delete();
            return response("Removed from Queue!", 200);
        }
    }

    private function createProblemNode($id){
        $node = [];
        //making the node's index
        $node['user_id'] = $id;
        // --- TEMPORARY PLACEMENT OF POSTFEELING // REMOVE WHEN PROBLEMS ARE AVAILABLE
        foreach (Problem::get() as $problem) {
            $node[$problem['problem_name']] = 0;
        }

        return $node;
    }

    private function createSpecNode($id){   
        $node = [];
        //making the node's index
        $node['user_id'] = $id;
       
        foreach (Specialization::get() as $spec) {
            $node[$spec['spec_name']] = 0;
        }

        return $node;
    }

    private function createLongLatIntNode(){
        $node = [];
        //making the node's index
        
        $node['Longitude'] = 0;
        $node['Latitude'] = 0;
        foreach (Interest::get() as $interest) {
            $node[$interest['interestName']] = 0;
        }

        return $node;
    }

    private function createNode($id){
            $node = [];
            //making the node's index
            $node['user_id'] = $id;
            // --- TEMPORARY PLACEMENT OF POSTFEELING // REMOVE WHEN PROBLEMS ARE AVAILABLE
            foreach (Problem::get() as $problem) {
                $node[$problem['problem_name']] = 0;
            }
            $node['Longitude'] = 0;
            $node['Latitude'] = 0;
            foreach (Interest::get() as $interest) {
                $node[$interest['interestName']] = 0;
            }
            $node['Cluster'] = null;

            return $node;
    }

    private function createFaciNode($id){   
        $node = [];
        //making the node's index
        $node['user_id'] = $id;
       
        foreach (Specialization::get() as $spec) {
            $node[$spec['spec_name']] = 0;
        }
        $node['Longitude'] = 0;
        $node['Latitude'] = 0;
        foreach (Interest::get() as $interest) {
            $node[$interest['interestName']] = 0;
        }
        $node['Score'] = 0;

        return $node;
    }

    //not done
    public function checkQueue3($id){
        $userQueue = QueueTalkCircle::where("user_id", $id)->get()[0];
        $allQueueUsers = [];
        foreach (QueueTalkCircle::get() as $user) {
            if($user->user['userType'] == 'seeker')
                array_push($allQueueUsers, $user);
        }
        // dd($allQueueUsers);
        // $allQueueUsers = QueueTalkCircle::get();
        // $sameProblemUsers = QueueTalkCircle::where("problem", $userQueue->problem)->get();
           
        
        $config = SystemConfig::findOrFail(1);
        //identifying number of clusters
        $centroidCount = count($allQueueUsers)/(int)$config->numberOfUsersToGroup;
                // add config for users
                //convert -> choose centroid -> compute euclidean -> group until then

        //nodes container // used for comparion
        $main = [];
        
        //centroid container // used to compare with nodes
        $bin = [];

        $clusters = array();
        for ($i=0; $i < $centroidCount; $i++) { 
            $temp = array();
            array_push($clusters, $temp);
        }

        // assigning centroids
        // assigning first x of sameProblemUsers to be centroids
        for ($i=0; $i < $centroidCount; $i++) {
            // $bin[$i] = [];                        
                        
            //making binary node

            $node = $this->createNode($allQueueUsers[$i]->user_id);

            //initializing centroids
            $count = 0;
            foreach ($node as $field => $value) {
                if(!$count == 0){
                    foreach ($allQueueUsers[$i]->problems as $problem) {
                            if($field == $problem->problem['problem_name']){
                                $node[$field] = 1;
                            }
                    }
                    if($field == 'Longitude'){
                        $node[$field] = $allQueueUsers[$i]->longitude;
                    }
                    if($field == 'Latitude'){
                        $node[$field] = $allQueueUsers[$i]->latitude;
                    }
                    $Userinterests = UsersInterests::where("user_id", $allQueueUsers[$i]['user_id'])->get();
                    foreach ($Userinterests as $interest) {
                        if($field == $interest->interest['interestName']){
                            $node[$field] = 1;
                        }
                    }
                }
                $count++;
            }
            // dd($node);
            array_push($bin, $node);
            // array_push($clusters[$i], $node);
        }


        // -- initialization
        foreach ($allQueueUsers as $user) {  
            $node = $this->createNode($user->user_id);

            //initializing values for each node
            $count = 0;
            foreach ($node as $field => $value) {
                if(!$count == 0){
                    foreach ($user->problems as $problem) {
                        if($field == $problem->problem['problem_name']){
                            $node[$field] = 1;
                        }
                    }
                    if($field == 'Longitude'){
                        $node[$field] = $user->longitude;
                    }
                    if($field == 'Latitude'){
                        $node[$field] = $user->latitude;
                    }
                    $Userinterests = UsersInterests::where("user_id", $node['user_id'])->get();
                    foreach ($Userinterests as $interest) {
                        if($field == $interest->interest['interestName']){
                            $node[$field] = 1;
                        }
                    }
                }
                $count++;
            }
            array_push($main, $node);
        }

        // dd($main);

        $basis = $this->createNode("sample");
        $clustersTemp = $clusters;
        $dumpCount = 0;
        // ---  COMPARISON AND ASSIGNING OF CLUSTERS

        do {
            
            $dumpCount++;                

            $clusters = $clustersTemp;
            $oldMain = $main;

            foreach ($main as $node => $nodeValue) {
                    $scores = [];

                    foreach ($bin as $centroid => $centroidValue) {
                        $tempTotal = 0;
                        foreach ($basis as $field => $fieldValue) {
                            if($field != 'user_id' && $field != 'Cluster'){
                                // echo $field;
                                // if($dumpCount == 2)
                                //     echo $field."|| bin = ".$bin[$centroid][$field]."|| main = ".$main[$node][$field]."<br>";
                                $temp = pow($bin[$centroid][$field]-$main[$node][$field], 2);
                                $tempTotal += $temp;
                                // echo $temp."<br>";
                            }
                        }
                        array_push($scores, sqrt($tempTotal));
                    }   
                    
                    $index = 0;
                    $lowest = 0;
                    for ($i=0; $i < count($scores); $i++) { 
                        if($i == 0){
                            $lowest = $scores[$i];
                            $index = array_keys($scores)[$i];
                        }
                        
                        if($scores[$i] < $lowest){
                            $lowest = $scores[$i];
                            $index = array_keys($scores)[$i];
                        }
                    }
                    $main[$node]['Cluster'] = $index;
                    array_push($clusters[$index], $main[$node]);
                }     
            // if($dumpCount == 2)
            //     dd($clusters);
            $newMain = $main;

            //checking for changes in clusters
            $changeCount = 0;
            foreach ($newMain as $newNode => $newValue) {
                if($newValue['Cluster'] != $oldMain[$newNode]['Cluster']){
                    $changeCount++;
                } 
            }

            // //assigning new centroids
            if($changeCount != 0){
                // dd($clusters);
                    foreach ($clusters as $index => $cluster) {
                        $newCentroid = $this->createNode("summation");
                        foreach ($cluster as $clusterNumber => $node) {
                            foreach ($node as $nodeField => $value) {
                                // dd($nodeField);
                                if($nodeField != 'user_id'){
                                    $newCentroid[$nodeField] += $value;
                                }
                            }
                        }
                        foreach ($newCentroid as $field => $value) {
                            if($field != 'user_id'){
                                $newCentroid[$field] = $value/count($cluster);
                            }
                            if($field == 'Longitude' || $field == 'Latitude'){
                                $newCentroid[$field] = $value/count($cluster);
                            }
                            if($field == 'Cluster'){
                                $newCentroid[$field] = $index;
                            }
                        }   
                        // dd($newCentroid);
                        $bin[$index] = $newCentroid;
                    }
                // dd($bin);
            }


        } while ($changeCount != 0);

        // dd($bin);

        $clusterPrint = 0;
        foreach ($clusters as $cluster => $nodes) {
            foreach ($nodes as $node) {
                if($node['user_id'] == $userQueue['user_id'])
                    $clusterPrint = $cluster;
            }
        }
        // dd($clusters);

        if(count($clusters[$clusterPrint]) < (int)$config->numberOfUsersToGroup)
            dd("not in group");
        else{
            // dd("in group"); 

            $faciCentroid = $bin[$clusterPrint];
            // dd($faciCentroid);

            //assigning facilitator
            $facilitators = [];
            foreach (QueueTalkCircle::get() as $queuedUser) {
                if($queuedUser->user['userType'] == 'facilitator')
                    array_push($facilitators, $queuedUser->user);
            }
            // dd($facilitators);

            $faciDecode = [];
            foreach ($facilitators as $faci) {
                $node = $this->createFaciNode($faci->user_id);
                // dd($node);
                //initializing values for each node
                $count = 0;
                foreach ($node as $field => $value) {
                    $faciQueue = QueueTalkCircle::where('user_id', $faci->user_id)->get()[0];
                    if(!$count == 0){
                        foreach (FacilitatorSpec::where('user_id', $faci->user_id)->get() as $userSpec) {
                            if($field == $userSpec->spec['spec_name']){
                                $node[$field] = 1;
                            }
                        }
                        if($field == 'Longitude'){
                            $node[$field] = $faciQueue->longitude;
                        }
                        if($field == 'Latitude'){
                            $node[$field] = $faciQueue->latitude;
                        }
                        $Userinterests = UsersInterests::where('user_id', $faci->user_id)->get();
                        foreach ($Userinterests as $interest) {
                            if($field == $interest->interest['interestName']){
                                $node[$field] = 1;
                            }
                        }
                    }
                    $count++;
                }
                array_push($faciDecode, $node);
            }
            // dd($faciDecode);    
            
            //comparison
            
            // foreach ($faciDecode as $faci => $faciValue) {
            //     //each faci 
            //     foreach ($faciValue as $field => $value) {
            //         //each field for faci
            //         if($field != 'user_id' && $field != 'Score'){
            //             // not user_id and scor
            //             if(Specialization::where('spec_name', $field)->get() != EmptyMuch::get()){
            //                 // checks if specialization
            //                 $count = 0;
            //                 foreach ($faciCentroid as $centroidField => $centroidValue) {
            //                     // each field for centroid
            //                     if($field != 'user_id' && $field != 'Cluster'){
            //                         // not user_id and cluster
            //                         if(Problem::where('problem_name', $centroidField)->get() != EmptyMuch::get()){
            //                             // checks if problem
            //                             $specialization = Specialization::where('spec_name', $field)->get()[0];
            //                             $matches = SpecMatchProblem::where('spec_id', $specialization['spec_id'])->get();
                                        
            //                             foreach ($matches as $match) {
            //                                 $problem = Problem::findOrFail($match['problem_id']);
            //                                 if($centroidField == $problem['problem_name']){
            //                                     // echo $centroidField ." and ".$problem['problem_name']."<br>";
            //                                     // echo $problem['problem_name']."true<br>";
            //                                     // $faciDecode[$faci]['Score'] += 1;
            //                                     // $temp += 1;
            //                                 }
            //                             }
            //                         }
            //                     }
                            
            //                 }
            //                 // dd("hello");
            //             }   
            //         }
            //     }
            // }
            $problemBasis = $this->createProblemNode("problemBasis");
            $specBasis = $this->createSpecNode("specBasis");
            $longlatBasis = $this->createLongLatIntNode();

            foreach ($faciDecode as $faci => $faciValue) {
                foreach ($faciValue as $field => $fieldValue) {
                    $problCount = 0;
                    $specScore = 0;   
                    if ($field != 'user_id' && $field != 'Score' && Specialization::where('spec_name', $field)->get() != EmptyMuch::get() && $fieldValue > 0){
                        $spec = Specialization::where('spec_name', $field)->get()[0];
                        foreach ($faciCentroid as $centroidField => $value) {
                            if ($field != 'user_id' && $field != 'Score' && Problem::where('problem_name', $centroidField)->get() != EmptyMuch::get() && $value > 0){
                                $prob = Problem::where('problem_name', $centroidField)->get()[0];

                                foreach (SpecMatchProblem::where('spec_id', $spec['spec_id'])->get() as $match) {
                                    $problCount = count(SpecMatchProblem::where('spec_id', $spec['spec_id'])->get());
                                    if($match['problem_id'] == $prob['problem_id']){
                                         $specScore += $value;
                                    }
                                }
                            }

                        }
                        $temp = $specScore/$problCount;
                        $faciDecode[$faci]['Score'] += $temp;
                    }
                    else{
                        foreach ($longlatBasis as $field => $value) {
                            // if($field == "Latitude")
                            //     dd(pow($faciCentroid[$field]-$faciDecode[$faci][$field],2));
                            $faciDecode[$faci]['Score'] += pow($faciCentroid[$field]-$faciDecode[$faci][$field],2);
                        }
                        $faciDecode[$faci]['Score'] = sqrt($faciDecode[$faci]['Score']);
                    }
                }
            }
            // dd($faciDecode);
            $index = 0;
            $lowest = 0;
            // for ($i=0; $i < count($scores); $i++) { 
            foreach ($faciDecode as $faciIndex => $faciValue) {
                if($lowest == 0){
                    $lowest = $faciDecode[$faciIndex]['Score'];
                    $index = $faciIndex;
                }
                
                if($faciDecode[$faciIndex]['Score'] < $lowest){
                    $lowest = $faciDecode[$faciIndex]['Score'];
                    $index = $faciIndex;
                }
            }
            $mainFaci = $faciDecode[$faciIndex];
            // dd($mainFaci);

            //grouping
            $group = [];
            array_push($group, SystemUser::findOrFail($mainFaci['user_id']));
            echo "<h1>Meet your members!</h1>";
            $mainUser = SystemUser::findOrFail($userQueue['user_id']);
            array_push($group, $mainUser);
            // echo "<b>".$mainUser['first_name']." ".$mainUser['last_name']."<br></b>";

            for ($i=0; count($group) <= (int)$config->numberOfUsersToGroup; $i++) { 
                $orig = SystemUser::findOrFail($clusters[$clusterPrint][$i]['user_id']);
                if($group == [])
                    array_push($group, $orig);
                else{
                    $count = 0;
                    foreach ($group as $member) {
                        if($orig['user_id'] == $member['user_id'])
                            $count++; 
                    }
                    if($count == 0)
                        array_push($group, $orig);
                }
                // echo $orig['first_name']." ".$orig['last_name']."<br>";
            }

            foreach ($group as $member) {
                if($member['userType'] == 'facilitator')
                    echo "<b>".$member['first_name']." ".$member['last_name']."</b><br>";
                else
                    echo $member['first_name']." ".$member['last_name']."<br>";
            }

        }
            
        
    // end function
    }
}

