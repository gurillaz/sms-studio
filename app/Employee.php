<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends User
{
    protected $table = 'users';


    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }

    public function payments(){


        return $this->morphMany('App\Payment','paymentable');
    }


//    public function all_files(){
//
//        return $this->morphMany('App\File','fileable');
//    }

    public function files(){

        return $this->morphMany('App\File','fileable')->whereNull('meta_name');
//        return $this->all_files()->where('meta_name','==',null);
    }

    public function all_files(){

        return $this->morphMany('App\File','fileable');
    }


    public function tasks(){

        return $this->hasMany('App\Task','employee_id');


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
    public function no_tasks(){

        return $this->tasks()->count();
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


    /*
   * Get profile photo/ File name
   *
   *
   * @return String
   *
   * */

    public function profile_photo(){

        return $this->all_files->where('meta_name','===','profile_photo')->first()->file;

    }
}
