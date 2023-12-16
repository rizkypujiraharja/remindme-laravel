<?php

namespace Tests\Unit;

use App\Http\Requests\ReminderUpcomingRequest;
use App\Interfaces\ReminderServiceInterface;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReminderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUpcomingReminders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reminders = Reminder::factory([
            'user_id' => $user->id,
        ])->count(5)->create();

        $request = new ReminderUpcomingRequest();
        $request->merge(['limit' => 5]);

        $service = app()->make(ReminderServiceInterface::class);

        $result = $service->getUpcomingReminders($request);

        $this->assertCount(5, $result);
        $this->assertEquals($reminders->pluck('id'), $result->pluck('id'));
    }
}
