<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function files(){


        return $this->morphMany('App\File','fileable');
    }



    public function paymentable(){

        return $this->morphTo();
    }
}
