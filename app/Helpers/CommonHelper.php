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
