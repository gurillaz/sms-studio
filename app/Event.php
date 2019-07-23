<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function payments(){


        return $this->morphMany('App\Payment','paymentable');
    }

    public function contract(){

        return $this->morphOne('App\File','fileable');

    }

    public function inventory(){

        return $this->belongsToMany('App\Inventory');


    }



    public function offers(){

        return $this->belongsToMany('App\Offer');


    }


    public function employees(){

        return $this->belongsToMany('App\Employee');


    }


    public function duration_hours(){


        $start = Carbon::parse($this->date_start);
        $end = Carbon::parse($this->date_end);

        $diff_in_hours = $start->diffInHours($end);

        return $diff_in_hours;

    }
}
