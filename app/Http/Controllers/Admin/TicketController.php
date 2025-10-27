<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendTicketToWebService;
use App\Notifications\TicketStatusChanged;

class TicketController extends Controller
{
    public function index()
    {
        $admin = auth()->user();

        $ticketsQuery = Ticket::query()->latest();

        if ($admin->is_admin_level == 1) {
            $tickets = $ticketsQuery->get();
            $editableTicketIds = $ticketsQuery->where('status', 'submitted')->pluck('id')->toArray();
        } elseif ($admin->is_admin_level == 2) {
            $tickets = $ticketsQuery->get();
            $editableTicketIds = $ticketsQuery->where('status', 'approved_by_admin1')->pluck('id')->toArray();
        } else {
            abort(403);
        }

        return view('admin.tickets.index', compact('tickets', 'editableTicketIds'));
    }



    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function approve(Request $request, Ticket $ticket)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);
        $user = auth()->user();

        if ($user->is_admin_level == 1 && $ticket->status == 'submitted') {
            $ticket->update([
                'status' => 'approved_by_admin1',
                'admin1_id' => $user->id,
                'admin1_reason' => $request->reason,
            ]);
        } elseif ($user->is_admin_level == 2 && $ticket->status == 'approved_by_admin1') {
            $ticket->update([
                'status' => 'approved_by_admin2',
                'admin2_id' => $user->id,
                'admin2_reason' => $request->reason,
            ]);


            dispatch(new SendTicketToWebService($ticket));
            $ticket->user->notify(new TicketStatusChanged($ticket, "تیکت شما تأیید شد"));
        } else {
            abort(403, 'این تیکت هنوز آماده تأیید شما نیست.');
        }


        return redirect()->route('admin.tickets.index')->with('success', 'تیکت تأیید شد.');
    }


    public function reject(Request $request, Ticket $ticket)
    {
        $request->validate(['reason' => 'required|string|max:500']);
        $user = auth()->user();

        if ($user->is_admin_level == 1 && $ticket->status == 'submitted') {
            $ticket->update([
                'status' => 'rejected_by_admin1',
                'admin1_id' => $user->id,
                'admin1_reason' => $request->reason,
            ]);
        } elseif ($user->is_admin_level == 2 && $ticket->status == 'approved_by_admin1') {
            $ticket->update([
                'status' => 'rejected_by_admin2',
                'admin2_id' => $user->id,
                'admin2_reason' => $request->reason,
            ]);
        } else {
            abort(403, 'این تیکت هنوز آماده بررسی شما نیست.');
        }

        $ticket->user->notify(new TicketStatusChanged($ticket, "تیکت شما رد شد. دلیل: " . $request->reason));

        return redirect()->route('admin.tickets.index')->with('success', 'تیکت رد شد.');
    }



    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array|min:1',
            'reason' => 'required|string|max:1000',
        ]);

        $admin = auth()->user();

        if ($admin->is_admin_level == 1) {
            $status = 'approved_by_admin1';
            $adminIdField = 'admin1_id';
            $reasonField = 'admin1_reason';
        } elseif ($admin->is_admin_level == 2) {
            $status = 'approved_by_admin2';
            $adminIdField = 'admin2_id';
            $reasonField = 'admin2_reason';
        } else {
            return redirect()->back()->with('error', 'شما مجاز به تأیید تیکت‌ها نیستید.');
        }

        $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();

        foreach ($tickets as $ticket) {
            $ticket->update([
                'status' => $status,
                $adminIdField => $admin->id,
                $reasonField => $request->reason,
            ]);
        }

        return redirect()->back()->with('success', 'تیکت‌ها با موفقیت تأیید شدند.');
    }
}
