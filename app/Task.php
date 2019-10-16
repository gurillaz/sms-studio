<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;


    protected $hidden = ['pivot'];


    public function inventory()
    {

        return $this->belongsToMany('App\Inventory');


    }





    public function employee()
    {

        return $this->belongsTo('App\User','employee_id');


    }

    public function event()
    {

        return $this->belongsTo('App\Event','event_id');


    }
    public function services()
    {

        return $this->belongsToMany('App\Service');


    }


    public function user(){

        return $this->belongsTo('App\User','created_by');
    }

    public function job(){

        return $this->belongsTo('App\Job');
    }



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


}
