<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewHandAdded;


class HopeController extends Controller
{
    public function create()
    {
        return view('hope.create');
    }

    public function hands()
    {
        $hands = \App\Models\User::findOrFail(1);
        return response()->json([
            'count'   => $hands->hands,
        ]);
    }


    public function show()
    {
        return view('hope.show');
    }
}
