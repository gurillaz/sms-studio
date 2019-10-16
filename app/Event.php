<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
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

        return $this->morphOne('App\File', 'fileable');

    }






    public function employees()
    {

        return $this->belongsToMany('App\Employee');


    }
    public function tasks()
    {

        return $this->hasMany('App\Task');


    }

    public function user(){

        return $this->belongsTo('App\User','created_by');
    }


    public function job(){

        return $this->belongsTo('App\Job','job_id');
    }


    // public function client(){

    //     // return 'asd';
    //     return $this->job()->with('client.Model')->get();
        
    // }



    public function duration_hours()
    {


        $start = Carbon::parse($this->date_start);
        $end = Carbon::parse($this->date_end);

        $diff_in_hours = $start->diffInHours($end);

        return $diff_in_hours;

    }
}
