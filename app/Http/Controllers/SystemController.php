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
use App\Group;
use App\GroupActivities;
use App\GroupDetails;
use App\GroupDetailsInterests;
use App\GroupMember;
use App\Activity;
use Auth;

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
            $SID = $user->user_id;

            $queue->user_id = $user->user_id;
            $queue->longitude = $req->long;
            $queue->latitude = $req->lat;
            $queue->save();

            return redirect(url('/checkQueue'.'/'.$SID));
            // return redirect()->back();
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

    // GROUPING
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
        // dd($clusterPrint);

        if(count($clusters[$clusterPrint]) < (int)$config->numberOfUsersToGroup)
            dd("not in group");
        else{
            // dd("in group"); 

            $faciCentroid = $bin[$clusterPrint];
            // dd($faciCentroid);

            if(Auth::user()->userType == 'seeker'){
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
                                // dd($faciCentroid);
                                if ($field != 'user_id' && $field != 'Score' && Problem::where('problem_name', $centroidField)->get() != EmptyMuch::get() && $value > 0){
                                    $prob = Problem::where('problem_name', $centroidField)->get()[0];
                                    // dd($prob);

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
            }
            else{
                $mainFaci = SystemUser::findOrFail(Auth::user()->user_id);
            }
                // dd($mainFaci);

                //grouping
                $group = [];
                $groupDB = new Group;
                $groupFaci = SystemUser::findOrFail($mainFaci['user_id']);
                array_push($group, $groupFaci);
                if(Auth::user()->userType == 'seeker'){
                    $mainUser = SystemUser::findOrFail($userQueue['user_id']);
                    array_push($group, $mainUser);
                }

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
                }

                // --- MAKING GROUP IN DB
                if(Group::get() == EmptyMuch::get()){
                    $groupDB->groupID = "G00001";
                }
                else{
                    $row = Group::orderby('groupID', 'desc')->first();
                    $temp = substr($row['groupID'], 1);
                    $temp =(int)$temp + 1;
                    $id = "G".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                    // dd($id);
                    $groupDB->groupID = $id;
                }
                $mainGroupID = $groupDB->groupID;
                $groupDB->groupName = $groupFaci['first_name']." ".$groupFaci['last_name']."'s Group";
                
                $groupDB->save();

                // --- ADDING MEMBERS TO GROUP
                foreach ($group as $groupMem) {
                    $gm = new GroupMember;

                    if(GroupMember::get() == EmptyMuch::get()){
                        $gm->groupMemberID = "GM0001";
                    }
                    else{
                        $row = GroupMember::orderby('groupMemberID', 'desc')->first();
                        $temp = substr($row['groupMemberID'], 2);
                        $temp =(int)$temp + 1;
                        $id = "GM".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                        $gm->groupMemberID = $id;
                    }
                    $gm->memberID = $groupMem->user_id;
                    $gm->fname = $groupMem->first_name;
                    $gm->lname = $groupMem->last_name;
                    $gm->groupID = $mainGroupID;

                    $gm->save();
                }

                // --- ADDING DETAILS TO GROUP
                
                // IMPORTANT NOTES -- STARTED NOT DONE
                
                // PLEASE SOLVE AVERAGE FOR GROUP BY MAKING A NEW 'CENTROID' LAYOUT
                // VALUES GREATER THAN 0 WILL BE ADDED TO DETAILS DB
                // THIS IS POSSIBLY THE END FOR THE FUNCTION

                $groupAve = $this->createNode("groupAve");   

                
                foreach ($groupAve as $row => $rowValue) {
                    if($row != 'user_id' && $row != 'Cluster'){

                        if(Problem::where("problem_name", $row)->get() != EmptyMuch::get()){
                            $score = 0;
                            foreach ($group as $member) {
                                if ($member->userType != 'facilitator'){
                                    // print_r($member->first_name);
                                    $userInQueue = QueueTalkCircle::where("user_id", $member->user_id)->get()[0];
                                    
                                    $problems = QueueUsersProblem::where("queueID", $userInQueue->queueID)->get();
                                    
                                    foreach ($problems as $problem) {
                                        $temp = Problem::findOrFail($problem->problem_id);
                                        if($temp->problem_name == $row){
                                            $score += 1;
                                        }
                                    }


                                }
                            }
                            // dd($score);
                            $score = $score/(count($group)-1);
                            $groupAve[$row] = $score;
                        }
                        else{
                            $score = 0;
                            foreach ($group as $member) {
                                if ($member->userType != 'facilitator'){
                                    // print_r($member->first_name);
                                    // $userInQueue = QueueTalkCircle::where("user_id", $member->user_id)->get()[0];
                                    
                                    $interests = UsersInterests::where("user_id", $member->user_id)->get();
                                    
                                    foreach ($interests as $inter) {
                                        $temp = Interest::findOrFail($inter->interestID);
                                        if($temp->interestName == $row){
                                            $score += 1;
                                        }
                                    }


                                }
                            }
                            // dd($score);
                            $score = $score/(count($group)-1);
                            $groupAve[$row] = $score;
                        }



                    }
                }

                
                // dd($groupAve); // <-- GROUP AVERAGE

                foreach ($groupAve as $field => $fieldValue) {
                    if($field != 'user_id' && $field != 'Cluster'){
                        if($fieldValue > 0){
                            if(Problem::where("problem_name", $field)->get() != EmptyMuch::get()){
                                $gd = new GroupDetails;
                                
                                if(GroupDetails::get() == EmptyMuch::get()){
                                    $gd->groupDetailID = "GD0001";
                                }
                                else{
                                    $row = GroupDetails::orderby('groupDetailID', 'desc')->first();
                                    $temp = substr($row['groupDetailID'], 2);
                                    $temp =(int)$temp + 1;
                                    $id = "GD".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                                    $gd->groupDetailID = $id;
                                }
                                $problem = Problem::where("problem_name", $field)->get()[0];
                                $gd->problemID = $problem->problem_id;
                                $gd->groupID = $mainGroupID;

                                $gd->save();
                            }
                            else{
                                $gdi = new GroupDetailsInterests;

                                if(GroupDetailsInterests::get() == EmptyMuch::get()){
                                    $gdi->groupDetailID = "GD0001";
                                }
                                else{
                                    $row = GroupDetailsInterests::orderby('groupDetailID', 'desc')->first();
                                    $temp = substr($row['groupDetailID'], 2);
                                    $temp =(int)$temp + 1;
                                    $id = "GD".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                                    $gdi->groupDetailID = $id;
                                }

                                $interest = Interest::where("interestName", $field)->get()[0];
                                $gdi->interestID = $interest->interestID;
                                $gdi->groupID = $mainGroupID;

                                $gdi->save();
                            }
                            
                        }
                    }
                }

                // dd("done");
                $dbgroup = Group::findOrFail($mainGroupID);

                return view('user.meetYourGroup')->with(['group'=>$group, 'dbgroup'=>$dbgroup]);
            }
        // end function
    }

    public function recommendActivities($id){
        $config = SystemConfig::findOrFail(1);
        $probDetails = GroupDetails::where("groupID", $id)->get();
        $intDetails = GroupDetailsInterests::where("groupID", $id)->get();

        // YOU LEFT HERE --- MATCHING DETAILS WITH ACTIVITIES AND LISTING THEM IN PROFESSIONAL SIDE
        
        // CAUTION --- ALGORITHM INCOMING --- CAUTION

        $activities = Activity::get();

        // dd($activities[0]->activityTags[0]->interest);

        $activityArray = [];

        foreach ($activities as $activity) {

            $score = 0;

            foreach ($probDetails as $problem) {
                foreach ($activity->problems as $actProb) {
                    if($problem->problem == $actProb->problem)
                        $score += 1;
                }
            }

            foreach ($intDetails as $interest) {
                foreach ($activity->activityTags as $actTag) {
                    if($interest->interest == $actTag->interest)
                        $score += 1;
                }
            }

            $actFormat = [
                'activity' => $activity,
                'score' => $score
            ];

            array_push($activityArray, $actFormat);
        }

        $sortedActArray = [];
        
        foreach (array_sort($activityArray, 'score', SORT_ASC) as $act) {
            array_push($sortedActArray, $act);
        }

        // for ($index=count($sortedActArray)-1; $index >= 0; $index--) { 
        //     print_r($sortedActArray[$index]['activity']->title);\
        //     print_r($sortedActArray[$index]['score']);
        //     echo "<br>";
        // }
        
        // for ($index=count($sortedActArray)-1, $count=0; $index >= 0 && $count <= (int)$config->numberOfTopActToBeSuggested; $index--, $count++) { 
        //     print_r($sortedActArray[$index]['activity']->title);\
        //     print_r($sortedActArray[$index]['score']);
        //     echo "<br>";
        // }


        return view('user.selectActivities')->with(['activities'=>$sortedActArray, 'groupID'=>$id]);

    }

    public function saveActivities($groupid, Request $req){
        
        foreach ($req->selected as $activity) {
            $groupAct = new GroupActivities();

            if(GroupActivities::get() == EmptyMuch::get()){
                $groupAct->groupActID = "GA0001";
            }
            else{
                $row = GroupActivities::orderby('groupActID', 'desc')->first();
                $temp = substr($row['groupActID'], 2);
                $temp =(int)$temp + 1;
                $id = "GA".(string)str_pad($temp, 4, "0", STR_PAD_LEFT);
                $groupAct->groupActID = $id;
            }
            $groupAct->actID = $activity;
            $groupAct->groupID = $groupid;
            $groupAct->save();
        }


    }
}

