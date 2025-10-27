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

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            TicketStatus::Draft->value => 'پیش ‌نویس',
            TicketStatus::Submitted->value => 'ارسال شده',
            TicketStatus::ApprovedByAdmin1->value => 'تایید شده توسط مدیر ۱',
            TicketStatus::ApprovedByAdmin2->value => 'تایید شده توسط مدیر ۲',
            TicketStatus::RejectedByAdmin1->value => 'رد شده توسط مدیر ۱',
            TicketStatus::RejectedByAdmin2->value => 'رد شده توسط مدیر ۲',
            TicketStatus::SentToWebservice->value => 'ارسال شده به وب‌ سرویس',
            default => 'نامشخص',
        };
    }
}
