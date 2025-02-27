<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.layouts.app');
});

Route::get('/users',function(){
    return view('admin.users.list');    
});
