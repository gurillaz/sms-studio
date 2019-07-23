<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function client(){

        return $this->belongsTo('App\Client');
    }



    public function events(){

        return $this->belongsToMany('App\Event');


    }
}
