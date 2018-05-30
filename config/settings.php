<?php
return [

    'paginate' => 20,

    'project_status'=>[
        'kick_off'=> 'kick off',
        'pending'=>'pending',
        'in_progress'=>'in-progress',
        'releasing'=>'releasing',
        'complete'=>'complete',
        'planing'=>'planning'
    ],

    'Roles'=>[
        'PO'=>'PO',
        'TeamDev'=>'TeamDev',
        'BA'=>'BA',
        'ScrumMater'=>'ScrumMater'
    ],

    'Employees'=>[
        'is_employee' => 1,
        'not_employee' => 0,
    ],
    'Gender'=>[
        'male'=>'Male',
        'female'=>'Female',
        'n_a'=>'N/A'
    ],
    'Married'=>[
        'single'=>'Single',
        'married'=>'Married',
        'separated'=>'Separated',
        'devorce'=>'Devorce',
    ],
    'delete_flag'=>[
        'deleted'=>1,
        'not_deleted'=>0
    ],
    'work_status'=>[
        'active'=>0,
        'unactive'=>1
    ]


];