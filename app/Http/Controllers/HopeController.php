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

    public function handOn()
    {

        Route::post('/hope/add-hand', function () {
            event(new NewHandAdded('🖐️'));
            return response()->json(['status' => 'sent']);
        });
    }

    public function show()
    {
        return view('hope.show');
    }
}
