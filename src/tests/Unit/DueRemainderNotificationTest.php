<?php

namespace Tests\Unit;

use App\Models\Reminder;
use App\Models\User;
use App\Notifications\DueReminderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DueRemainderNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testDueReminderNotificationSent(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory([
            'user_id' => $user->id,
        ])->create();

        Notification::fake();
        $user->notify(new DueReminderNotification($reminder));

        // Assert a notification was sent to the given users...
        Notification::assertSentTo(
            [$user],
            DueReminderNotification::class
        );
    }
}
