<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;


class ajaxController extends Controller
{
    public function clientsJson()
    {
        $clients = Client::all()->where('deleted_at','=',null);

        return $clients->jsonSerialize();
    }
}
