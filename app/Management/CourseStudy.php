<?php

namespace App\Management;

use Illuminate\Database\Eloquent\Model;

class CourseStudy extends Model
{
    public function department(){
        return $this->belongsTo('App\Management\SchoolDepartment');
    }

    public function programme(){
        return $this->belongsTo('App\Management\SchoolDegree');
    }
}
