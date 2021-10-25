<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student\HighLevelResult as HighLevel;
use App\Student\StudentPayment as Payment;
use App\MedicalReport as Medical;
use App\User;

use App\LibaryClass as Libary;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    { 
        $p = $req->input('p');
        $prop = User::where('prospective', 0)->latest()->paginate(10);
        $admit = User::where('prospective', 1)->latest()->paginate(10);
        
        foreach ($admit as $student) {
            $student->admission;
            $student->admission->department;
            $student->admission->degree; 

            $student->highlevel = $student->admission->highlevel_result;
        }
        foreach ($prop as $student) {
            $student->admission;
            $student->admission->department;
            $student->admission->degree; 
            $student->highlevel = $student->admission->highlevel_result;

        }

        return ['prospective' => $prop, 'admission' => $admit];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->admission; //Student Admission Details
        $user->medical;
        if(!$user->admission->highlevel_result_id){
            $hl = new HighLevel(); $hl->save();
            $user->admission->highlevel_result_id = $hl->id;
            $user->admission->save();
        }
        if(!$user->medical){
            $med = new Medical(); 
            $med->user_id = $id;
            $med->save();
        }
        $user->admission->fee; $user->admission->department; 
        $user->admission->degree;  
        $user->highlevel = $user->admission->highlevel_result;//Student High Level Results
        // $user->screaning = $user->admission->screaning_result;//Student Screaning Results
        // var_dump($user);
        return  $user;
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

    public function medical(Request $request){
        $this->validate($request, [

        ]);
        $user = User::find($request->student);
        $user->medical;
        $user->medical->disability = $request->disability;
        $user->medical->blood_group = $request->blood;
        $user->medical->geneotype = $request->geneotype;
        $user->medical->alergic = $request->alergic;
        $user->medical->medical_history = $request->history;
        $user->medical->save();
    }

    public function highlevel(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'photo'  => 'required',//'image|required|min: 100|max:1500|mimes:jfif,jpeg,jpg,png',
            'document1'  => 'required',//'image|required|min: 100|max:1500|mimes:jfif,jpeg,jpg,png',
        ]);
        $user = User::find($request->id);
        $user->admission; 
        $user->admission->highlevel_result;
        
        $photo = '' ; $path1 = ''; $path2 = ''; $path3 = '';
        if($request->hasFile('photo')){
            $request->validate(['photo'=>'min: 5|max:5000|mimes:jfif,jpeg,jpg,png']);
            $fileFullName = $request->file('photo')->getClientOriginalName();
            $fileType = $request->file('photo')->getClientMimeType();
            $ext = $request->file('photo')->getClientOriginalExtension();
            $fileNameStore = sha1(time()). rand(100000, 999999) . '.'.$ext;
            $photo = $request->file('photo')->storeAs('public/staffs', $fileNameStore);
        }
        // return $photo;
 
        if($request->hasFile('document1')){
            $request->validate(['document1'=>'min: 5|max:5000|mimes:pdf,doc,docx']);
            $fileFullName = $request->file('document1')->getClientOriginalName();
            $fileType = $request->file('document1')->getClientMimeType();
            $ext = $request->file('document1')->getClientOriginalExtension();
            $fileNameStore = sha1(time()). rand(100000, 999999) . '.'.$ext;
            $path1 = $request->file('document1')->storeAs('public/prospective', $fileNameStore);
        }
        if($request->hasFile('document2')){
            $request->validate(['document2'=>'min: 5|max:5000|mimes:pdf,doc,docx']);
            $fileFullName = $request->file('document2')->getClientOriginalName();
            $fileType = $request->file('document2')->getClientMimeType();
            $ext = $request->file('document2')->getClientOriginalExtension();
            $fileNameStore = sha1(time()). rand(100000, 999999) . '.'.$ext;
            $path2 = $request->file('document2')->storeAs('public/prospective', $fileNameStore);
        }
        if($request->hasFile('document3')){
            $request->validate(['document3'=>'min: 5|max:5000|mimes:pdf,doc,docx']);
            $fileFullName = $request->file('document3')->getClientOriginalName();
            $fileType = $request->file('document3')->getClientMimeType();
            $ext = $request->file('document3')->getClientOriginalExtension();
            $fileNameStore = sha1(time()). rand(100000, 999999) . '.'.$ext;
            $path3 = $request->file('document3')->storeAs('public/prospective', $fileNameStore);
        }

        $user->admission->photo = $photo;
        $user->admission->save();
        // $user->admission->highlevel_result->total_result = $request->result;
        $user->admission->highlevel_result->course1_name = $path1;
        $user->admission->highlevel_result->course2_name = $path2;
        $user->admission->highlevel_result->course3_name = $path3;
        $user->admission->highlevel_result->save();
        return $user;
    }

    public function studentReview(Request $req){
        $review = $req->input('r');
        $tale = $req->input('t');
        $student = $req->input('s');
        $session = $req->input('ses');
        $user = User::find($student);

        if($user && $review == "student" && $tale == "asnmdmskdmgvkdkmcd"){
            $user->admission;
            $user->admission->extra1 = 1;
            $user->admission->save();
            return  $user->admission; 
        }
        if($user && $review == "screan" && $tale == "skjsuikendnfnedd"){
            $matric = Libary::generateMatricNumber($user,$session);
            $user->prospective = 2;
            $user->session_id = $session;
            $user->save();
            $user->admission; 
            $user->admission->matriculation_no = $matric;
            $user->admission->screaning_result_id = 1;
            $user->admission->screaned_at = date('Y-m-d H:i:s');
            $user->admission->save();
            return  $user->admission;
        }
        if($user && $review == "admit" && $tale == "pakiwsnmdbnjhadbjbsbdxmsnmcdf"){
            $user->prospective = 1;
            $user->student_at = date('Y-m-d H:i:s'); 
            // $user->session_id = $; 
            $user->save();
            return  $user;
        }
        return $user;
    }

    public function fees(Request $request){
        $student = $request->input('s');
        $tale = $request->input('t');
        $user = User::find($student);
        $user->admission;
        if($user && $tale == "ajkxhnkjmandjnasd"){
            $pay = new Payment();
            $pay->save();
            $user->admission->acceptance_id = $pay->id;
            $user->admission->save();
            return $user;
        }else {
            $pay = new Payment();
            $pay->save();
            $user->admission->fee_id = $pay->id;
            $user->admission->save();
            return $user;
        }
    }
}
