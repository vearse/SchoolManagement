<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Student\Admission;
use App\Student\HighLevelResult as HighLevel;
use DateTime;
use GuzzleHttp\Psr7\Request;

class RegisterController extends Controller
{
    /* 
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()

    
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $max_year = date('Y-m-d', strtotime('-14 years'));
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:191'],
            'lastname' => ['required', 'string', 'max:191'],
            'degree' => ['required'],'department' => ['required'],
            'gender' => ['required'],
            
            'dob' => ['required', 'date', 'before:'.$max_year],
            'phone' => ['required', 'string', 'max:20', 'unique:students'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:students'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ],[
            'dob.before' => 'Input a correct Date of Birth',
            // 'degree'
        ]); 
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       $user = new User();
       $user->fname = $data['firstname']; 
       $user->lname = $data['lastname'];
       $user->email = $data['email']; 
       $user->dob = $data['dob'];
       $user->phone = $data['phone'];
       $user->gender =  $data['gender'];
       $user->name = $data['firstname']  . " ".  $data['lastname'];
       $user->password = Hash::make($data['password']);
        
        // $user->name = $data['fname']$data['lname'];
        // return $user;
        $admit = new Admission();
        $hl = new HighLevel(); $hl->save();
        $admit->highlevel_result_id = $hl->id;
         
        $admit->address = $data['address'];
        $admit->country = $data['nationality'];
        $admit->religion = $data['religion'];
        $admit->state = $data['state'];
        $admit->department_id = $data['department_id'];
        $admit->degree_id = $data['degree'];

        $admit->save();
        $user->admission_id = $admit->id;
        $user->save();
        return $user; 
    }
}
