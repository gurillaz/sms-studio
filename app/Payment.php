<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }
    public function user(){

        return $this->belongsTo('App\User','created_by');
    }


    public function files(){


        return $this->morphMany('App\File','fileable');
    }
    public function categories(){


        return $this->morphMany('App\Category','categories');
    }



    public function paymentable(){

        return $this->morphTo();
    }
}
