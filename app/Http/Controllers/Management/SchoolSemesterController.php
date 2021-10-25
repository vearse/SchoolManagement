<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Management\SchoolSemester as Semesters;
use App\Management\SchoolSession as Session;
use DateTime;
use Illuminate\Support\Facades\Validator;

class SchoolSemesterController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sect = Semesters::latest()->paginate(10);
        foreach ($sect as $s) {
            // $s->semeters;
        }
        return $sect; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('before_or_equal', function($attribute, $value, $parameters, $validator) {
            return strtotime($validator->getData()[$parameters[0]]) >= strtotime($value);
                }, 'Date entered is not correct.');
                
        $this->validate($request,[
            'name' =>'required|string|max:25',
            'sessions' => 'required',
            'from' =>'required|date|after:yesterday|before_or_equal:to',
            'to' =>'required|date|max:25|after:today'
        ]);
        // $session = Session::find($request->sessions);

        // return $session;
        $sect = new Semesters();
        $sect->school_session_id = $request->sessions;
        $sect->name = $request->name;
        $sect->shortname = $request->sname;
        $sect->from = $request->from;
        $sect->to = $request->to;
        $sect->description = $request->note;

        $sect->save();
        return $sect;
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
        $semester = Semesters::where('shortname',$sect[0])->first();
        $semester->section = Session::find($sect[1]);
        return $semester;
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
