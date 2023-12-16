<?php

namespace Tests\Unit;

use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
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
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $service = app()->make(ReminderServiceInterface::class);

        $result = $service->getUpcomingReminders($request);

        $this->assertCount(5, $result);
        $this->assertEquals($reminders->pluck('id'), $result->pluck('id'));
    }

    public function testStoreReminder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new ReminderCreateRequest();
        $remindAt = now()->timestamp;
        $eventAt = now()->addDay()->timestamp;
        $request->merge([
            'title' => 'Test Reminder',
            'description' => 'Test Description',
            'remind_at' => $remindAt,
            'event_at' => $eventAt,
        ]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        $service = app()->make(ReminderServiceInterface::class);
        $reminder = $service->store($request);

        $this->assertEquals('Test Reminder', $reminder->title);
        $this->assertEquals('Test Description', $reminder->description);
        $this->assertEquals($remindAt, $reminder->remind_at->timestamp);
        $this->assertEquals($eventAt, $reminder->event_at->timestamp);
        $this->assertEquals($user->id, $reminder->user_id);
    }

    public function testUpdateReminder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reminder = Reminder::factory()->create([
            'title' => 'Old Title',
            'user_id' => $user->id
        ]);

        $request = new ReminderUpdateRequest();
        $request->merge(['title' => 'New Title']);

        $service = app()->make(ReminderServiceInterface::class);
        $updatedReminder = $service->update($request, $reminder);

        $this->assertEquals('New Title', $updatedReminder->title);
    }

    public function testDeleteReminder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reminder = Reminder::factory()->create([
            'user_id' => $user->id
        ]);

        $service = app()->make(ReminderServiceInterface::class);
        $service->destroy($reminder);

        $this->assertDatabaseMissing('reminders', ['id' => $reminder->id]);
    }
}
