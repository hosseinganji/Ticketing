<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebserviceAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'attempt_number',
        'status_code',
        'response_body',
        'succeeded',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
