<?php

namespace App\customClasses;


class QueueScore
{
    private $userID;
    private $score;
    
    public function __constructor($id, $score){
        $this->userID = $id;
        $this->score = $score;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function getScore(){
        return $this->score;
    }

    public function setUserID($temp){
        $this->userID = $temp;
    }

    public function setScore($temp){
        $this->score = $temp;
    }
}
?>