<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\WebserviceAttempt;
use App\Jobs\SendTicketToWebService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RetryFailedWebserviceSends extends Command
{
    protected $signature = 'webservice:retry-failed';
    protected $description = 'Retry failed or not-yet-sent tickets to webservice every hour.';

    public function handle()
    {
        $this->info('RetryFailedWebserviceSends started at '.now());

        $tickets = Ticket::whereIn('status', ['approved_by_admin2', 'sent_to_webservice'])
            ->get();


        foreach ($tickets as $ticket) {
            $lastAttempt = WebserviceAttempt::where('ticket_id', $ticket->id)->orderByDesc('id')->first();

            if (!$lastAttempt) {
                dispatch(new SendTicketToWebService($ticket));
                Log::info("Dispatched SendTicketToWebService for ticket {$ticket->id} (no attempts)");
                continue;
            }

            if ($lastAttempt->succeeded) {
                continue;
            }

            $lastTryAt = $lastAttempt->created_at;
            if ($lastTryAt->diffInMinutes(now()) >= 60) {
                dispatch(new SendTicketToWebService($ticket));
                Log::info("Re-dispatched SendTicketToWebService for ticket {$ticket->id} (last attempt at {$lastTryAt})");
            }
        }

        $this->info('RetryFailedWebserviceSends finished at '.now());
    }
}
