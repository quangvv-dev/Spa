<?php

namespace App\Http\Controllers\BE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FanpageController extends Controller
{
    public function index()
    {
        return view('fanpage.index');
    }
}
