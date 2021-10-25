<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    public function highlevel_result(){
        return $this->belongsTo('App\Student\HighLevelResult');
    }
    public function fee(){
        return $this->belongsTo('App\Student\StudentPayment');
    }

    public function department(){
        return $this->belongsTo('App\Management\SchoolDepartment');
    }

    public function degree(){
        return $this->belongsTo('App\Management\SchoolDegree');
    }

    public function screaning_result(){
        return $this->belongsTo('App\Student\ScreaningResult');
    }
}
