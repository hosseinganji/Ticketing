<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatus;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment_path',
        'status',
        'admin1_id',
        'admin2_id',
        'admin1_reason',
        'admin2_reason',
    ];

    // Convenience helpers
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin1()
    {
        return $this->belongsTo(User::class, 'admin1_id');
    }

    public function admin2()
    {
        return $this->belongsTo(User::class, 'admin2_id');
    }

    public function attempts()
    {
        return $this->hasMany(WebserviceAttempt::class);
    }

    public function getStatusEnum()
    {
        return TicketStatus::tryFrom($this->status);
    }

    public function setStatusEnum(TicketStatus $status)
    {
        $this->status = $status->value;
        $this->save();
    }
}
