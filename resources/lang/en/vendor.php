<?php

return [
    'title'=>'Vendor Detail',
    'button'=>[
        'add_vendor' => 'ADD'
    ],
    'title_header'=>[
        'title_vendor'=>'Vendor',
        'add_vendor'=>'Add Vendor',
    ],

    'label'=>[
        'avatar'=>'Avatar'
    ],
    'drop_box'=>[
        'placeholder-default' => 'Please Select',
        'gender-'.config('settings.Gender.male').'' => 'Male',
        'gender-'.config('settings.Gender.female').'' => 'Female',
        'gender-'.config('settings.Gender.n_a').'' => 'N/A'
    ],
    'marital_status'=>[
        'title'=>'Marital Status',
        config('settings.Married.single')=>'Single',
        config('settings.Married.married')=>'Married',
        config('settings.Married.separated')=>'Separated',
        config('settings.Married.devorce')=>'Divorced'
    ],
    'basic'=>'Basic',
    'profile_info'=>[
        'id'=>'Vendor ID',
        'title'=>'Profile Information',
        'name'=>'Name',
        'email'=>'Email',
        'status'=>'Status',
        'password'=>'Password',
        'confirm_password'=> 'Confirm password',
        'company'=>'Company',
        'cv'=>'CV',
        'married'=>'Married',
        'start_work_date'=>'Start work date',
        'end_work_date'=>'End work date',
        'work_status'=>[
            'active'=>'Active',
            'inactive'=>'Inactive',
        ],
        'gender'=>[
            'title'=>'Gender',
            'male'=>'Male',
            'female'=>'Female',
            'na'=>'N/A'
        ],
        'position'=>[
            'position'=>'Position'
        ],
        'birthday'=>'Birthday',
        'phone'=>'Phone',
        'address'=>'Address',
        'employee_type'=>[
            config('settings.EmployeeType.FullTime')=>'FullTime',
            config('settings.EmployeeType.PartTime')=>'PartTime',
            config('settings.EmployeeType.InterShip')=>'InterShip',
            config('settings.EmployeeType.Contractual Employee')=>'Contractual Employee'
        ],
        'team'=>'Team',
        'role'=>'Role',
        'role_in_team'=>'Role',
        'policy_date'=>'Policy Date',
        'policy_status'=>[
            'title'=>'Policy Status',
            'unexpired'=>'Unexpired',
            'expired'=>'Expired'
        ],
    ],

    'msg_fails' => 'msg_fails',
    'msg_success' => 'msg_success',
    'msg_error' => 'msg_error',

    'msg_content' => [
        'msg_add_success'=>'Vendor successfully added!!!',
        'msg_add_fail'=>'Add Vendor fail!!!',
        'msg_error_add_team'=> 'Has error in process',
        'msg_download_template'=>'Are you want to download the Vendor Template?',
        'msg_download_vendor_list'=>'Are you want to download the Vendor List?'
    ],
];
