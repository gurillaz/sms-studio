<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;



    public function user(){

        return $this->belongsTo('App\User','created_by');
    }

    public function noteable(){


        return $this->morphTo();
    }
}
