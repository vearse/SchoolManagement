<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Route;

use App\Admin;
use App\Management\Lecturer;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{

    protected $redirectTo = RouteServiceProvider::Dashboard;
    
    public function __construct()
    {  
      $this->middleware('guest:admin', ['except' => ['login', 'showLoginForm', '']]);
    }
    
    public function showLoginForm()
    {
      return view('admin.login');
    }
    
    public function signup(Request $request){
      
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

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
       
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
         return redirect()->intended('/dashboard');
        // //return redirect()->intended(route('dashboard'));return $request->wantsJson() ? new Response('', 204) : redirect()->intended('/dashboard');
      } 
      // if unsuccessful, then redirect back to the login with the form data
      return redirect('/admin/signin')->withInput($request->only('email', 'remember'));
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    } 
}
