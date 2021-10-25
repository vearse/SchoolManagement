<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Management\Timetable;
use App\Management\CourseCurriculum as Curriculum;
use App\Management\CourseStudy as Course;

use function GuzzleHttp\json_decode;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $table = $req->input('table');
        $sect = $req->input('sect');
        $dept = $req->input('dept');
        $lev = $req->input('lev');
        $deg = $req->input('deg');
        // $sect = explode('-', $table);
        // return $dept.$table;

        $timetable = Timetable::where('department_id', $dept)
                    ->where('level', (int)$lev)->where('programme_id', $deg)
                    ->where('school_semester_id', $table)
                    ->first(); 

        $cur = Curriculum::where('department_id', $dept)->where('programme_id', $deg)
                    ->where('level', $lev)->first();

        if(!$timetable){
            $tt = new Timetable();
            $tt->courses = "";//($cur && $cur->courses) ? $cur->courses : json_encode([]) ;
            $tt->department_id = $dept;
            $tt->programme_id = $deg;
            $tt->school_semester_id = $table;
            $tt->level = $lev;
            $tt->save();
            $timetable = $tt;
        }
        $timetable->courses = json_decode($timetable->courses);
        foreach ($timetable->courses  as $cu) {
            $cu->course = Course::select('name', 'shortname')->find($cu->dept);
            // array_push($depts, $courses);
        }
        if($timetable->timetable) $timetable->timetable = json_decode($timetable->timetable);
        
        return ["timetable" => $timetable, 'curriculum' => $cur];
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

        $timetable = Timetable::where('department_id', $request->department)
                    ->where('school_semester_id', $request->semester)
                    ->first();

        $timetable->timetable =  json_encode($request->timetable);
        $timetable->save(); 
        return $timetable;
    }

    public function courseRegistration(Request $request)
    {
        $this->validate($request, [
            'deadline' => 'required',
            // 'semester' => 'required',
            // 'session' => 'required',
            // 'department' => 'required',
        ]);

        // $timetable = Timetable::where('department_id', $request->department)
        //     ->where('school_semester_id', $request->semester)->first();
        $timetable = Timetable::find($request->id);

        $timetable->deadline =  $request->deadline;
        $timetable->save(); 
        return $timetable;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
