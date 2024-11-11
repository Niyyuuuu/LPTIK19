<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index()
    {
        return view('technisi');
    }

    public function task()
    {
        // Ambil tiket yang sesuai dengan technician_id yang sedang login
        $tickets = Tiket::where('technician_id', Auth::id())->get();

        return view('technisian.tasks', compact('tickets'));
    }

    public function ticketList()
    {
        $tickets = Tiket::with('user')->get();
        return view('technisian.ticket-list', compact('tickets'));
    }
}
