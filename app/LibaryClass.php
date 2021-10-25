<?php

namespace App;

use App\Management\SchoolSession as Setup;
use App\Management\SchoolDepartment as Department;
use App\Management\SchoolDegree as Program;
use App\Management\Configuration as Config;
use App\Management\Lecturer as Lecturer;
use App\Management\CourseStudy as Course;
use App\User;


class LibaryClass {

    public static function generateMatricNumber($user, $session){
        // $user = User::find($user);
        $config =  Config::where('name', 'matric')->first();
        $session = Setup::find($session);
        $department = $user->admission->department;
        $degree = $user->admission->degree;
        $sesid = ''; $deptid = '';$degid = '';
        $id = str_pad($user->id, 3,0, STR_PAD_LEFT);
        if($config->param1 == 2 && $session){
            $sesid = $session->shortname;
        }else if($config->param1 == 3 && $session){
            $sesid = str_pad($session->id, 3, 0, STR_PAD_LEFT);
        }
        if($config->param2 == 4 && $department){
            $deptid = $department->shortname."-";
        }else if($config->param2 == 5 && $department){
            $deptid = str_pad($department->id, 3, 0, STR_PAD_LEFT);
        }
        if($config->param3 == 6 && $degree){
            $degid = $degree->shortname."-";
        }else if($config->param3 == 7 && $degree){
            $degid = str_pad($degree->id, 3,0, STR_PAD_LEFT);
        }

        $matric = $sesid.$deptid.$degid.$id;
        return $matric;
    }

    public static function adminDashboard($session){
        $prospective = User::where('prospective', '0')->orWhere('prospective', '1')->count();
        $lecturer = Lecturer::count();
        $degree = Program::count();
        $department = Department::count();
        $course = Course::count();
        $student = null;
        if($session) $student = User::where('session_id', $session)->count();
        return [
            'prospective' => $prospective , 'lecturer' => $lecturer,
            'degree' => $degree , 'department' => $department,
            'course' => $course , 'student' => $student
        ];
    }
}