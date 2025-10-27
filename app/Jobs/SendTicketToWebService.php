<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\WebserviceAttempt;
use App\Services\Webservice\WebserviceClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendTicketToWebService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ticket $ticket;

    public int $tries = 1;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle(WebserviceClientInterface $client)
    {
        if ($this->ticket->status !== 'approved_by_admin2' && $this->ticket->status !== 'sent_to_webservice') {
            Log::info("Ticket #{$this->ticket->id} is not ready for sending. status: {$this->ticket->status}");
            return;
        }

        $lastAttempt = WebserviceAttempt::where('ticket_id', $this->ticket->id)
            ->orderByDesc('id')
            ->first();

        $attemptNumber = $lastAttempt ? $lastAttempt->attempt_number + 1 : 1;

        try {
            $response = $client->sendTicket($this->ticket);

            WebserviceAttempt::create([
                'ticket_id' => $this->ticket->id,
                'attempt_number' => $attemptNumber,
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'succeeded' => $response->successful(),
            ]);

            if ($response->successful()) {
                $this->ticket->update(['status' => 'sent_to_webservice']);
                Log::info("Ticket {$this->ticket->id} sent successfully. attempt: {$attemptNumber}");
            } else {
                Log::warning("Ticket {$this->ticket->id} send failed. HTTP {$response->status()}. attempt: {$attemptNumber}");
                // throw new \Exception("Webservice returned status {$response->status()}");
            }
        } catch (Throwable $e) {
            WebserviceAttempt::create([
                'ticket_id' => $this->ticket->id,
                'attempt_number' => $attemptNumber,
                'status_code' => null,
                'response_body' => $e->getMessage(),
                'succeeded' => false,
            ]);

            Log::error("Ticket {$this->ticket->id} exception while sending: ".$e->getMessage());
            throw $e;
        }
    }

    public function failed(Throwable $exception)
    {
        Log::error("job failed for ticket {$this->ticket->id}: ".$exception->getMessage());
    }
}
