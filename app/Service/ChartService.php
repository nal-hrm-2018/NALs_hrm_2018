<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/24/2018
 * Time: 1:54 PM
 */

namespace App\Service;


use App\Models\Employee;
use App\Models\Process;
use App\Models\Project;
use App\Models\Team;

interface ChartService
{
    public function getValueOfEmployee(Employee $employee, $currentMonth);
    public function getValueOfProject(Project $project, Employee $currentEmployee, $currentMonth);
    public function calculateTime($time1, $time2);
    public function getListValueOfMonth(Employee $employee, $year);
    public function getListYear(Employee $employee);
    public function getValueOfTeam(Team $team, $currentMonth);
    public function getValueOfListTeam($currentMonth);
    public function getListMonth();
}