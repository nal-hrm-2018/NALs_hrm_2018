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

function getArraySelectOption(){
     $array = ['10'=>'10','25'=>'25','50'=>'50','100'=>'100'];

     return $array;
}
