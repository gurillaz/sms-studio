<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;


    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function payments(){


        return $this->morphMany('App\Payment','paymentable');
    }





    public function files(){


        return $this->morphMany('App\File','fileable');
    }




    public function events(){

        return $this->belongsToMany('App\Event');


    }

    public function user(){

        return $this->belongsTo('App\User','created_by');
    }

    /*
     * Get number of events
     *
     *
     * @return Integer
     *
     * */
    public function no_events(){

        return $this->events()->count();
    }

    /*
     * Get number of payments
     *
     *
     * @return Integer
     *
     * */
    public function no_payments(){

        return $this->payments()->count();
    }


    /*
     * Get sum of payments
     *
     *
     * @return Integer
     *
     * */
    public function payments_sum(){

        return $this->payments()->where('type','==','in')->sum('amount');
    }
}
