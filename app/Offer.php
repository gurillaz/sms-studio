<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function services(){

        return $this->belongsToMany('App\Service');


    }


    public function events(){


        return $this->belongsToMany('App\Event');


    }
}
