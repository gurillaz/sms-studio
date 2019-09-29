<?php

namespace App;

use Faker\Provider\File as FileAlias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

class File extends Model
{
    use SoftDeletes;

    public function fileable(){

        return $this->morphTo();

    }



    public function user(){

        return $this->belongsTo('App\User','created_by');
    }


    public function file_extension(){
        // return storage_path();

        $file_path = storage_path("app\\public\\uploads\\").$this->file;
        // return $file_path;


        if (file_exists($file_path))
        {
            return strtoupper(FileFacade::extension($file_path));


        }
        else
        {

            return "nn";
        }


    }

    public function file_type(){

        $file_path = storage_path("app\\public\\uploads\\").$this->file;



        if (file_exists($file_path))
        {
            return Storage::mimeType('public\\uploads\\'.$this->file);

        }
        else
        {

            return "NA";
        }


    }

    public function file_size(){

        $file_path = storage_path("app\\public\\uploads\\").$this->file;



        if (file_exists($file_path))
        {

            return number_format(Storage::size('public\\uploads\\'.$this->file)/1000000,2);
        }
        else
        {

            return 0;
        }


    }

    public function file_name(){

        $file_path = storage_path("app\\public\\uploads\\").$this->file;



        if (file_exists($file_path))
        {

            return basename('public\\uploads\\'.$this->file);
        }
        else
        {

            return "NA";
        }


    }
}
