<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }


    public function offers(){

        return $this->belongsToMany('App\Offer');


    }

    public function tasks(){

        return $this->belongsToMany('App\Task');


    }
}
