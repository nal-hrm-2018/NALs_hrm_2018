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
            'email' => 'Địa chỉ email',
            'name' => 'Họ tên',
            'start_date'=>'Ngày bắt đầu',
            'end_date'=>'Ngày kết thúc',
            'type' => 'Loại nghỉ phép',
            'type_time' => 'Loại giờ phép',
            'reason'=>'Lý do',
            'action'=>'Hành động',
            'note'=>'Ghi chú',
            'status'=>'Tình trạng',
            'note_po'=>'Ghi chú của PO'
        ],
        'note'=>[
            'absence_new'=>'Xin nghỉ',
            'absence_deny'=>'Xin hủy'
        ],
        'status'=>[
            config('settings.status_common.absence.waiting')=>'Đang xử lý',
            config('settings.status_common.absence.accepted')=>'Được nghỉ',
            config('settings.status_common.absence.rejected')=>'Không được nghỉ',
            'accepted_done'=>'Đồng ý nghỉ',
//            'accepted_deny'=>'Đồng ý hủy',
            'no_accepted_done'=>'Không được nghỉ',
            'no_accepted_deny'=>'Không được hủy',
            'just_watching'=>'Chỉ được xem',
            'absence_accepted'=>'Được nghỉ',
            'absence_rejected'=>'Không được nghỉ',
//            'no_accepted_deny'=>'Không được hủy',
            'just_watching'=>'Chỉ được xem'
        ],
        'type'=>[
            config('settings.status_common.absence_type.non_salary_date')=>'Nghỉ không lương',
            config('settings.status_common.absence_type.salary_date')=>'Nghỉ phép',
            config('settings.status_common.absence_type.subtract_salary_date')=>'Nghỉ trừ lương',
            config('settings.status_common.absence_type.insurance_date')=>'Nghỉ theo bảo hiểm',
            config('settings.status_common.absence_type.absented_date')=>'Nghỉ phép',
            config('settings.status_common.absence_type.marriage_leave')=>'Nghỉ cưới',
            config('settings.status_common.absence_type.maternity_leave')=>'Nghỉ thai sản',
            config('settings.status_common.absence_type.bereavement_leave')=>'Nghỉ tang',
        ],
        'msg'=>[
            'confirm_export'=>'Bạn có muốn tải về danh sách xác nhận vắng nghỉ không?',
        ],
        'message'=>[
            'export_msg'=>'Bạn có muốn tải xuống danh sách xin vắng làm?'
        ]
    ]
];