<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index() {
        $tickets = Ticket::latest()->get();
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket) {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function approve(Request $request, Ticket $ticket) {
        $request->validate(['reason' => 'nullable|string|max:500']);

        if (auth()->user()->is_admin_level_1) {
            $ticket->update(['status' => TicketStatus::ApprovedByAdmin1, 'reason' => $request->reason]);
        } elseif (auth()->user()->is_admin_level_2) {
            $ticket->update(['status' => TicketStatus::ApprovedByAdmin2, 'reason' => $request->reason]);
        }

        return redirect()->back()->with('success', 'تیکت تأیید شد.');
    }

    public function reject(Request $request, Ticket $ticket) {
        $request->validate(['reason' => 'required|string|max:500']);

        if (auth()->user()->is_admin_level_1) {
            $ticket->update(['status' => TicketStatus::RejectedByAdmin1, 'reason' => $request->reason]);
        } elseif (auth()->user()->is_admin_level_2) {
            $ticket->update(['status' => TicketStatus::RejectedByAdmin2, 'reason' => $request->reason]);
        }

        return redirect()->back()->with('success', 'تیکت رد شد.');
    }

    public function bulkApprove(Request $request) {
        $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();
        foreach ($tickets as $ticket) {
            $ticket->update(['status' => TicketStatus::ApprovedByAdmin1]);
        }
        return redirect()->back()->with('success', 'تیکت‌ها به صورت گروهی تأیید شدند.');
    }
}
