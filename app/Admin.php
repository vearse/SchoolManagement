<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Management\SchoolSession as Session;
use Carbon\Carbon;

class Admin extends  Authenticatable
{
    use Notifiable;
    #region Admin: details
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles'
    ];

    protected $appends = ['calendar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    #endregion

    public function getCalendarAttribute(){
        $today = date('Y-m-d');  
        $sessions = Session::where(function($q) {
            $now = Carbon::now();
            $q->where('from', '<=', $now);
            $q->where('to', '>=', $now);
        }) ->first(); 
        return $sessions;
    }
    // Config::set("auth. defaults.passwords","admins");
}
