<?php

namespace Tests\Feature;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\AdminsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_approval_workflow()
    {
        // run admin seeder
        $this->seed(AdminsSeeder::class);

        $admin1 = User::where('is_admin_level', 1)->first();
        $admin2 = User::where('is_admin_level', 2)->first();

        // create a test user
        $user = User::factory()->create();

        // create ticket by $user
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'status' => TicketStatus::Submitted->value,
        ]);

        // approve by admin1
        $ticket->update([
            'status' => TicketStatus::ApprovedByAdmin1->value,
            'admin1_reason' => 'همه چیز درست است.',
        ]);

        $this->assertEquals(TicketStatus::ApprovedByAdmin1->value, $ticket->status);
        $this->assertNotNull($ticket->admin1_reason);

        // approve by admin2
        $ticket->update([
            'status' => TicketStatus::ApprovedByAdmin2->value,
            'admin2_reason' => 'تایید نهایی انجام شد.',
        ]);

        $this->assertEquals(TicketStatus::ApprovedByAdmin2->value, $ticket->status);
        $this->assertNotNull($ticket->admin2_reason);
    }
}
