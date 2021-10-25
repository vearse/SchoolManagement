<?php

namespace App\Management;

use Illuminate\Database\Eloquent\Model;

class SchoolDepartment extends Model
{
    public function degree(){
        return $this->belongsTo('App\Management\SchoolDegree');
    }
}
