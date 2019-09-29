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


    public function jobs(){


        return $this->hasMany('App\Event');


    }
    public function user(){
        return $this->belongsTo('App\User','created_by');
    }
}
