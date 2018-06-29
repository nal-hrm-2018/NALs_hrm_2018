<?php

return [
    'path'=>[
       'home' => 'Trang chủ',    
       'list_absence' => 'Danh sách vắng nghỉ',
       'add_absence' => 'Đăng ký vắng nghỉ',
       'select_year' => 'Chọn năm'
    ],  

    'absence'=>[
        'total_date_absences' => 'Số ngày phép có thể nghỉ',
        'number_of_days_off'=>'Số ngày đã nghỉ',
        'absented_date'=>'Số ngày nghỉ phép',
        'remaining_date'=>'Số ngày nghỉ phép còn lại',
        'subtract_salary_date'=>'Số ngày nghỉ trừ lương',
        'insurance_date'=>'Số ngày nghỉ bảo hiểm',
        'non_salary_date'=>'Số ngày nghỉ không lương',
        'last_year_absences_date'=> 'Số ngày phép năm ngoái',
    ],
    'list_absence' => [
        
        'status'=>[
            config('settings.status_common.absence.waiting')=>'Đang xử lý',
            config('settings.status_common.absence.accepted')=>'Được Nghỉ',
            config('settings.status_common.absence.rejected')=>'Không Được Nghỉ',
            'accepted_done'=>'Đồng ý nghỉ',
//            'accepted_deny'=>'Đồng ý hủy',
            'no_accepted_done'=>'Không được nghỉ',
            'no_accepted_deny'=>'Không được hủy',
            'just_watching'=>'Chỉ được xem',
            'absence_accepted'=>'Được Nghỉ',
            'absence_rejected'=>'Không Được Nghỉ',
//            'no_accepted_deny'=>'Không được hủy',
            'just_watching'=>'Chỉ được xem'
        ],
        'type'=>[
            config('settings.status_common.absence_type.non_salary_date')=>'Nghỉ không lương',
            config('settings.status_common.absence_type.salary_date')=>'Nghỉ phép',
            config('settings.status_common.absence_type.subtract_salary_date')=>'Nghỉ trừ lương',
            config('settings.status_common.absence_type.insurance_date')=>'Nghỉ theo bảo hiểm',
            config('settings.status_common.absence_type.absented_date')=>'Nghỉ phép',
        ],
    ]
];