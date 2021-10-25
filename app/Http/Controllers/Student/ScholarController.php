<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as Student;


class ScholarController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $dept = $req->input('dept');
        $level = $req->input('lev');
        $calendar = $req->input('cal');
        $name = $req->input('name');
        $deg = $req->input('deg');
        $matric = $req->input('matric');
        $session = $calendar;
        if($level > 100){
            $lev = substr($level, 0, 1);
            $session = $calendar - $lev;
        }
        $students = Student::join('admissions', 'admission_id', '=','admissions.id')
                        ->where('admissions.department_id', $dept)
                        ->where('students.prospective', 2)
                        ->when(($level), function($q) use ($session){
                           return $q->where('students.session_id', $session);
                        })
                        ->when(($deg), function($q) use ($deg){
                           return $q->where('admissions.degree_id', $deg);
                        })
                        ->when(($name), function($q) use ($name){
                           return $q->where('students.name', $name);
                        })
                        ->when(($matric), function($q) use ($matric){
                           return $q->where('admissions.matriculation_no', $matric);
                        })
                        ->select('*', 'students.id as id')->paginate(10);
        
        foreach ($students as $student) {
            $student->admission->department;
            $student->admission->degree;
        }
        return $students;
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sect = explode('-', $id);
        $student = Student::find($sect[0]);
        if($student){
            $lev = $student->session_id;
            // $session = $calendar - $lev;
        }
        // return $student->session_id; 
        $student->admisssion;
        $student->admission->department;
        $student->admission->degree;
        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
