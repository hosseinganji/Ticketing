<?php
namespace App\Services\Webservice;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class HttpWebserviceClient implements WebserviceClientInterface
{
    protected string $endpoint;

    public function __construct()
    {
        // $this->endpoint = route('webservice.send');

        $this->endpoint = route('webservice.send', [], false);
        $this->endpoint = 'http://localhost:8000' . $this->endpoint;
    }

    public function sendTicket(Ticket $ticket): Response
    {
        $payload = [
            'ticket_id' => $ticket->id,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'attachment_path' => asset('storage/'.$ticket->attachment_path),
            'user_id' => $ticket->user_id,
        ];

        return Http::timeout(10)->post($this->endpoint, $payload);
    }
}
