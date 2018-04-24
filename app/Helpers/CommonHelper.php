<?php

 function test(){
    return "test helper";
}

function getProjectStatus($project){
     if(isset($project->status)){
         return $project->status->name;
     }
     return '';
}

function getArraySelectOption(int $max ,int $step){
     $array = [];
     for($i = 5 ; $i<=$max ;$i=$i+$step){
         $array[$i]=$i;
     }
     return $array;
}
