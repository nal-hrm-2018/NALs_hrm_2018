<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 5/8/2018
 * Time: 9:18 AM
 */

namespace App\Service\Implement;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\AbsenceStatus;
use App\Models\AbsenceService;
use Exception;

class NumberAbsenceServiceImpl extends CommonService implements NumberAbsenceService
{
    public  function getNumberAbsence($id)
    {
        $dateNow = new DateTime;
        $objEmployee = Employee::find($id);
        $startwork_date = (int)date_create($objEmployee->startwork_date)->format("Y");
        $endwork_date = (int)date_create($objEmployee->endwork_date)->format("Y");
        if ((int)$dateNow->format("Y") <= $endwork_date) {
            $endwork_date = (int)$dateNow->format("Y");
        }

        $status = AbsenceStatus::select()->where('name', 'accepted')->first();
        $type = AbsenceType::select()->where('name', 'annual_leave')->first();

        $year = 0;
        if ((int)$dateNow->format('Y') < $endwork_date) {
            $year = $dateNow->format('Y');
        } else {
            $year = $endwork_date;
        }

        $abc = new \App\Absence\AbsenceService();

        $tongSoNgayDuocNghi = $abc->totalDateAbsences($id, $year); // tong ngay se duoc nghi nam nay
        $soNgayPhepDu = $abc->numberAbsenceRedundancyOfYearOld($id, $year - 1); // ngay phep nam ngoai
        if ($soNgayPhepDu > 5) {
            $soNgayPhepDu = 5;
        }
        $soNgayPhepCoDinh = $abc->absenceDateOnYear($id, $year) + $abc->numberAbsenceAddPerennial($id, $year); // tong ngay co the duoc nghi


        $tongSoNgayDaNghi = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);// tong ngay da nghi phep ( bao gom ngay nghi co luong va` tru luong)

        $soNgayTruPhepDu = $abc->subRedundancy($id, $year); // so ngay tru vao ngay phep du nam ngoai
        $soNgayTruPhepCoDinh = $abc->subDateAbsences($id, $year); // so ngay tru vao ngay phep

        if ($year < (int)$dateNow->format('Y') || (int)$dateNow->format('m') > 6) {
            $soNgayPhepConLai = $abc->sumDateExistence($id, $year);
            if ($soNgayPhepConLai < 0) {
                $soNgayPhepConLai = 0;
            }
            $checkMonth = 1;
        } else {
            $soNgayPhepConLai = $abc->sumDateExistence($id, $year) + $abc->sumDateRedundancyExistence($id, $year);
            if ($soNgayPhepConLai < 0) {
                $soNgayPhepConLai = 0;
            }
            $checkMonth = 0;
        }
        $soNgayPhepCoDinhConLai = $abc->sumDateExistence($id, $year);
        if ($soNgayPhepCoDinhConLai < 0) {
            $soNgayPhepCoDinhConLai = 0;
        }
        $soNgayTruPhepDuConLai = $abc->sumDateRedundancyExistence($id, $year);
        if ($soNgayTruPhepDuConLai < 0) {
            $soNgayTruPhepDuConLai = 0;
        }

        $type = AbsenceType::select()->where('name', 'subtract_salary_date')->first();
        $soNgayNghiTruLuong = $abc->subtractSalaryDate($id, $year) + $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $type = AbsenceType::select()->where('name', 'unpaid_leave')->first();
        $soNgayNghiKhongLuong = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $type = AbsenceType::select()->where('name', 'insurance_date')->first();
        $soNgayNghiBaoHiem = $abc->numberOfDaysOff($id, $year, 0, $type->id, $status->id);

        $absences = [
            "soNgayDuocNghiPhep" => $tongSoNgayDuocNghi,
            "soNgayNghiPhepCoDinh" => $soNgayPhepCoDinh,
            "soNgayPhepDu" => $soNgayPhepDu,
            "soNgayDaNghi" => $tongSoNgayDaNghi,
            "truVaoPhepCoDinh" => $soNgayTruPhepCoDinh,
            "truVaoPhepDu" => $soNgayTruPhepDu,
            "soNgayConLai" => $soNgayPhepConLai,
            "phepCoDinh" => $soNgayPhepCoDinhConLai,
            "phepDu" => $soNgayTruPhepDuConLai,
            "soNgayNghiTruLuong" => $soNgayNghiTruLuong,
            "soNgayNghiKhongLuong" => $soNgayNghiKhongLuong,
            "soNgayNghiBaoHiem" => $soNgayNghiBaoHiem,
            "checkMonth" => $checkMonth
        ];

        return $absences;
    }
}