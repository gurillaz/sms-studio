<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;
    protected $hidden = ['pivot'];

    
    public function user(){

        return $this->belongsTo('App\User','created_by');
    }
    public function notes(){


        return $this->morphMany('App\Note','noteable');
    }
    public function files(){


        return $this->morphMany('App\File','fileable');
    }
    public function payments(){


        return $this->morphMany('App\Payment','paymentable');
    }

    public function client(){

        return $this->belongsTo('App\Client');
    }



    public function tasks(){

        return $this->belongsToMany('App\Task');


    }
}
