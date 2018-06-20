<?php
/**
 * Created by PhpStorm.
 * User: Ngoc Quy
 * Date: 6/18/2018
 * Time: 2:28 PM
 */

return [
    'list_po' => [
        'path'=>'Danh sách xin vắng làm',
        'modal'=>[
            'reason'=>'Lý do từ chối',
            'done'=>'Đồng ý',
            'close'=>'Đóng',
            'send'=>'Gửi',
            'cancel'=>'Từ chối'
        ],
        'profile_info'=>[
            'start_date'=>'Ngày bắt đầu',
            'end_date'=>'Ngày kết thúc',
            'type' => 'Loại',
            'reason'=>'Lý do',
            'note'=>'Ghi chú',
            'status'=>'Tình trạng',
            'note_po'=>'Ghi chú của PO'
        ],
        'status'=>[
            config('settings.status_common.absence.waiting')=>'Đang xử lý',
            config('settings.status_common.absence.accepted')=>'Đã đồng ý',
            config('settings.status_common.absence.rejected')=>'Đã từ chối',
        ],
        'type'=>[
            config('settings.status_common.absence_type.non_salary_date')=>'Nghỉ không lương',
            config('settings.status_common.absence_type.subtract_salary_date')=>'Nghỉ trừ lương',
            config('settings.status_common.absence_type.insurance_date')=>'Nghỉ theo bảo hiểm',
        ]
    ]
];