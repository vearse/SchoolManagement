<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Management\SchoolSession as Session;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    public $table = 'students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'fname','lname',  'name', 'email', 'password', 'phone','admission_id','dob','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function admission(){
        return $this->belongsTo('App\Student\Admission');
    }

    public function medical(){
        return $this->hasOne('App\MedicalReport');
    }

    public function getCalendarAttribute(){
        $today = date('Y-m-d');  
        $sessions = Session::where(function($q) {
            $now = Carbon::now();
            $q->where('from', '<=', $now);
            $q->where('to', '>=', $now);
        }) ->first(); 
        return $sessions;
    }
}
