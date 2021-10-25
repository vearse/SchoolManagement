<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Management\SchoolDepartment as Department;
use App\Management\SchoolDegree as Degree;


class SchoolDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $pro = $req->input('pro');
        // if ($pro) {
        //     $depts = Department::where('degree_id', $pro)->paginate(30);
        // } else {
        //     $depts = Department::latest()->paginate(30);
        // }
        $depts = Department::latest()->paginate(30);
        foreach ($depts as $dept) {
            $degree = [];
            if($dept->degrees){
                $dept->degrees = json_decode($dept->degrees);
                $dept->extra = json_decode($dept->extra);
                foreach ($dept->degrees as $dg) {
                    $dept->degrees = Degree::select('id','name', 'shortname')->find($dg);
                    array_push($degree,$dept->degrees);
                }
                $dept->degree = $degree;
            }
        }
        return $depts;
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
            'name' => 'required|min:3|max:30',
            'shortname' => 'required|unique:school_departments',
            'degree' => 'required|array|min:1'
        ]);

        
        $sname = str_replace(" ","-",$request->shortname);
        $degrees = [];
        foreach ($request->degree as $degree) {
            array_push($degrees, $degree['id']);
        } 
        $dg = new Department();
        $dg->name = $request->name;
        $dg->shortname = $sname;
        $dg->admin_id = $request->admin;
        $dg->description = $request->description; 
        $dg->degree_id =  0;
        
        $dg->degrees = json_encode($degrees) ;
        $dg->extra = json_encode($request->department);
        $dg->save();
        return $dg;      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dept = Department::where('shortname', $id)->first();
        $degree = [];
        $dept->degrees = json_decode($dept->degrees);
        $dept->extra = json_decode($dept->extra);
        foreach ($dept->degrees as $dg) {
            $dept->degrees = Degree::find($dg);
            array_push($degree,$dept->degrees );
        }
        $dept->degree = $degree;
        return $dept;
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
