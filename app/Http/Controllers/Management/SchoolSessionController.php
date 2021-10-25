<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Management\SchoolSession as Session;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;

class SchoolSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sect = Session::latest()->paginate(10);
        foreach ($sect as $s) {
            $s->semeters;
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
            'from' =>'required|date|after:yesterday|before_or_equal:to',
            'to' =>'required|date|max:25|after:today'
        ]); 
        $max_year = date('Y-m-d', strtotime('+1 year',  date_timestamp_get(new DateTime($request->from))));
        $this->validate($request,['to' => 'before:'.$max_year]);
        $shfr = explode('-', $request->from)[0]; 
        $shfr = substr($shfr, 2, 2);
        $shto = explode('-', $request->to)[0]; 
        $shto = substr($shto, 2, 2);
        $shortname = "$shfr-$shto";
        $sect = new Session();
        $sect->name = $request->name;
        $sect->from = $request->from;
        $sect->to = $request->to;
        $sect->shortname = $shortname;
        $sect->description = $request->note;
        $sect->save();
        return $sect;
    }

    public function currentSession(Request $req){
        $info  = $req->info;
        $today = date('Y-m-d');  
        $sessions = Session::where(function($q) {
            $now = Carbon::now();
            $q->where('from', '<=', $now);
            $q->where('to', '>=', $now);
        }) ->first(); 

        if($info == "full"){
            $sessions->semeters;
        }

        return $sessions;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
