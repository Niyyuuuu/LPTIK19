<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function tickets()
    {
        $piket = Tiket::where('user_id', Auth::user()->id)->get();
        return view('piket', compact('piket'));
    }
}
