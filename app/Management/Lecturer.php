<?php

namespace App\Management;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function department(){
        return $this->belongsTo('App\Management\SchoolDepartment');
    }

}
