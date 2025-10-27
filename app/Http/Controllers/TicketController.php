<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index() {
        $tickets = Auth::user()->tickets()->latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create() {
        return view('tickets.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $path = $request->file('file')->store('tickets', 'public');

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'attachment_path' => $path,
            'status' => TicketStatus::Submitted,
        ]);

        return redirect()->route('dashboard')->with('success', 'تیکت با موفقیت ارسال شد.');
    }
}
