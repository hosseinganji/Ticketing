<?php
namespace App\Services\Webservice;

use App\Models\Ticket;
use Illuminate\Http\Client\Response;

interface WebserviceClientInterface
{
    public function sendTicket(Ticket $ticket): Response;
}
