<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin;
use App\Management\Lecturer;
use Illuminate\Support\Facades\Hash;
class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = Lecturer::paginate(10);
        foreach ($lecturers as $lecturer) {
            $lecturer->admin;
            $lecturer->department;
        }
        return $lecturers;
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
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'string', 'max:20', 'unique:lecturers'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:admins'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
          ]);
    
          $lecturer = new Lecturer();
          $lecturer->phone = $request->phone;
          $lecturer->title = $request->title;
          $lecturer->department_id = $request->department;
          $lecturer->degree_id = $request->degree;
          $lecturer->save();
    
          $admin = new Admin();
          $admin->name = $request->input('name');
          $admin->email =  $request->input('email');
          $admin->password = Hash::make($request->input('password'));
          $admin->role = $request->input('role');
          $admin->lecturer_id = $lecturer->id;
          $admin->save();
    
          $lecturer->admin_id = $admin->id;
          $lecturer->save();
          return $request;
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
