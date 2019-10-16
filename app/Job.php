<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;


    public function files()
    {


        return $this->morphMany('App\File', 'fileable');
    }

    public function notes()
    {


        return $this->morphMany('App\Note', 'noteable');
    }

    public function payments()
    {


        return $this->morphMany('App\Payment', 'paymentable');
    }

    public function contract()
    {

        return $this->files()->where('meta_name','==','contract_file');

    }



    public function offer()
    {

        return $this->belongsTo('App\Offer','offer_id');


    }


    public function client()
    {

        return $this->belongsTo('App\Client','client_id');


    }

    public function user(){

        return $this->belongsTo('App\User','created_by');
    }


    public function events(){

        return $this->hasMany('App\Event','job_id');
    }
    
    public function tasks(){

        return $this->hasMany('App\Task','job_id');
    }



//    public function duration_hours()
//    {
//
//
//        $start = Carbon::parse($this->date_start);
//        $end = Carbon::parse($this->date_end);
//
//        $diff_in_hours = $start->diffInHours($end);
//
//        return $diff_in_hours;
//
//    }
}
