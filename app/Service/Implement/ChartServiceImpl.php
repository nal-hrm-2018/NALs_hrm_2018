<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/24/2018
 * Time: 1:58 PM
 */

namespace App\Service\Implement;


use App\Models\Employee;
use App\Models\Project;
use App\Service\ChartService;
use App\Service\CommonService;

class ChartServiceImpl extends CommonService implements ChartService
{
    public function getValueOfEmployee(Employee $employee, $currentMonth){
        $projects = $employee->projects;
        $totalOnMonth = 0;
        foreach ($projects as $project)
        {
            $totalOnMonth += $this->getValueOfProject($project, $employee, $currentMonth);
        }
        return round($totalOnMonth,1);
    }
    public function getValueOfProject(Project $project, Employee $currentEmployee, $currentMonth){
        //x
        $income = $project->income;
        $estimateTime = $this->calculateTime($project->estimate_end_date, $project->start_date);
        $currentTime = $this->calculateTime('Y-m-d', $project->start_date);
        if(!isset($project->end_date)){
            $income = ($income / $estimateTime) * $currentTime;
        }

        //y
        $processes = $project->processes;
        $powerAllEmployeeOnProject = 0;
        foreach ($processes as $process){
            if(!isset($process->end_date)){
                $powerAllEmployeeOnProject += $this->calculateTime('Y-m-d', $process->start_date) * $process->man_power;
            } else {
                $powerAllEmployeeOnProject += $this->calculateTime($process->end_date, $process->start_date) * $process->man_power;
            }
        }


        //z
        //man power of current employee in this project
        $manPower = $currentEmployee->processes->where('project_id', $project->id)->first()->man_power;
        //start date of current employee in this project
        $currentEmployeeStartDate = $currentEmployee->processes->where('project_id', $project->id)->first()->start_date;
        //start date of current employee in this project
        $currentEmployeeEndDate = date('Y-m-d');

        if(isset($currentEmployee->processes->where('project_id', $project->id)->first()->end_date)){
            $currentEmployeeEndDate = $currentEmployee->processes->where('project_id', $project->id)->first()->end_date;
        }

        if(strtotime($currentMonth) < strtotime(date('Y-m-01', strtotime($currentEmployeeStartDate))) || strtotime($currentMonth) > strtotime(date('Y-m-01', strtotime($currentEmployeeEndDate)))){
            $manPowerOnMonth = 0;
        } else if(strtotime($currentMonth) == strtotime(date('Y-m-01', strtotime($currentEmployeeStartDate)))) {
            $manPowerOnMonth = $this->calculateTime(date('Y-m-t', strtotime($currentEmployeeStartDate)), $currentEmployeeStartDate) * $manPower;
        } else if(strtotime($currentMonth) == strtotime(date('Y-m-01', strtotime($currentEmployeeEndDate)))){
            $manPowerOnMonth = $this->calculateTime($currentEmployeeEndDate, $currentMonth) * $manPower;
        } else {
            $manPowerOnMonth = 30 * $manPower;
        }

        //value of current employee in this project on month
        $total = 0;
        if($powerAllEmployeeOnProject != 0){
            $total = ($income / $powerAllEmployeeOnProject) * $manPowerOnMonth;
        }
//        echo "currentEmployeeStartDate=".$currentEmployeeStartDate."--currentEmployeeEndDate=".$currentEmployeeEndDate.'--income=' .$income ."--powerAllEmployeeOnProject= " .$powerAllEmployeeOnProject ."--manPowerOnMonth=" .$manPowerOnMonth. "--total=" .$total ."-------------------";
        return $total;
    }
    public function calculateTime($time1, $time2){
        return (strtotime(date($time1)) - strtotime(date($time2))) / (60 * 60 * 24);
    }
    public function getListValueOfMonth(Employee $employee, $year){
        $listValue = array($year, $this->getValueOfEmployee($employee, $year.'-01-01'), $this->getValueOfEmployee($employee, $year.'-02-01')
        , $this->getValueOfEmployee($employee, $year.'-03-01'), $this->getValueOfEmployee($employee, $year.'-04-01')
        , $this->getValueOfEmployee($employee, $year.'-05-01'), $this->getValueOfEmployee($employee, $year.'-06-01')
        , $this->getValueOfEmployee($employee, $year.'-07-01'), $this->getValueOfEmployee($employee, $year.'-08-01')
        , $this->getValueOfEmployee($employee, $year.'-09-01'), $this->getValueOfEmployee($employee, $year.'-10-01')
        , $this->getValueOfEmployee($employee, $year.'-11-01'), $this->getValueOfEmployee($employee, $year.'-12-01'));
        return  $listValue;
    }
    public function getListYear(Employee $employee){
        $processes = $employee->processes;
        $listYears = array();
        $i = 0;
        foreach ($processes->sortByDesc('start_date') as $process){
            $start_year = date('Y', strtotime($process->start_date));
            if(isset($process->end_date)) {
                $end_year = date('Y', strtotime($process->end_date));
            } else {
                $end_year = date('Y');
            }
            while ($start_year != $end_year + 1){
                $listYears[$i++] = $start_year++;
            }
        }
        $listYears = array_unique($listYears);
        rsort($listYears);
        return $listYears;
    }
}