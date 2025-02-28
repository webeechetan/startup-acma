<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PilotController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.pilot');
    }
}
