<?php

namespace App\customClasses;
use App\customClasses\QueueScore;


class QueueScoreContainer
{
    private $container = array();
    
    public function __constructor(){}

    public function getContainer(){
        return $this->container;
    }

    public function addToContainer(QueueScore $item){
        array_push($this->container,$item);
    }
}
?>