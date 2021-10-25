<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Management\CourseStudy as Course;
use App\Management\SchoolDepartment as Department;

class CourseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $dept = $req->input('dept');
        $lev = $req->input('lev');
        $deg = $req->input('deg');
        
        $courses =    Course::where('level',$lev)->where('programme_id',$deg)
            ->when(($dept), function($q) use ($dept){
                return $q->where('department_id',$dept);
            })->latest()->get();
            
        foreach ($courses  as $course) {
            $course->programme;
        }
        return $courses;        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

        ]);
        $sname = str_replace(" ","-",$request->shortname);

        $course = new Course();
        $course->name = $request->name;
        // $course->unit = $request->unit;
        $course->level = $request->level;
        $course->shortname = $sname;
        $course->note = $request->note;
        $course->department_id = $request->department;
        $course->programme_id = $request->degree;
        // $course->extra = json_encode($request->departments);
        $course->save();

        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::where('shortname', $id)->first();
        $course->department;  
        $course->programme;
        $extra = []; 
        return $course;
        $course->extra = json_decode($course->extra);
        foreach ($course->extra as $i => $dept) {
            $c = Department::find($dept->dept);
            array_push($extra, $c);
        }
        $course->departments = $extra;
        // var_dump($course->extra[0]->dept);
        return $course;
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
