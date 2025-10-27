<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'attachment_path' => 'uploads/test.pdf',
            'status' => TicketStatus::Draft->value,
            'admin1_id' => null,
            'admin2_id' => null,
            'admin1_reason' => null,
            'admin2_reason' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
