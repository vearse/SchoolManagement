<?php

namespace App\Management;

use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    public function semeters(){
        return $this->hasMany('App\Management\SchoolSemester');
    }
}
