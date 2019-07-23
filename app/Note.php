<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;


    public function belongs_to_model(){

        $belongsTo = explode('\\',trim($this->noteable_type))[1];
        if($belongsTo === ''){
            return "NA";
        }

        return $belongsTo;

    }

    public function user(){

        return $this->belongsTo('App\User','created_by');
    }

    public function noteable(){


        return $this->morphTo();
    }
}
