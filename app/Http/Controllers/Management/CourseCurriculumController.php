<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Management\CourseCurriculum as Curriculum;
use App\Management\CourseStudy as Course;

class CourseCurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        return Curriculum::all();
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
            'department' => 'required|integer',
            'degree' => 'required|integer',
            'level' => 'required|integer',
        ]);

        $cur = new Curriculum();
        $cur->level = $request->level;
        $cur->department_id = $request->department;
        $cur->programme_id = $request->degree;
        $cur->courses = json_encode($request->courses);
        $cur->save();
        return $cur;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $req)
    {
        $lev = $req->input('lev');
        $deg = $req->input('deg');
        
        $cur = Curriculum::where('department_id', $id)->where('programme_id', $deg)
                    ->where('level', $lev)->first();
        
        if ($cur && $cur->courses){
            $cur->courses = json_decode($cur->courses);
            foreach ($cur->courses as $cu) {
                $cu->course = Course::select('name', 'shortname')->find($cu->dept);
                $cu->select = true;
            }
        }else{
            $courses = Course::where('department_id',$id)->where('level',$lev)
                        ->where('programme_id',$deg)->latest()->get();
             $cur = $courses;
        } 
        return $cur;
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
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $cur = Curriculum::find($id);
        // $cur->level = $request->level;
        // $cur->department_id = $request->department;
        // $cur->programme_id = $request->degree;
        $cur->courses = json_encode($request->courses);
        $cur->save();
        return $cur;
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
