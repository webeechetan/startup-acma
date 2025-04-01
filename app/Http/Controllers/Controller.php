<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    public function alert($msg,$type){
        Session::flash('alert', [
            'msg' => $msg,
            'type' => $type
        ]);
    }
}
