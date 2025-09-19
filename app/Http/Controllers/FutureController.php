<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FutureController extends Controller
{
    public function index()
    {
        return view('future.show');
    }
}
