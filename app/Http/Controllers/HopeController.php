<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewHandAdded;


class HopeController extends Controller
{
    public function create()
    {
        return view('hope.create');
    }


    public function show()
    {
        return view('hope.show');
    }
}
