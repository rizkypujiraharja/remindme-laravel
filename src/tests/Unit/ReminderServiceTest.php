<?php

namespace Tests\Unit;

use App\Exceptions\ForbiddenAccessException;
use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
use App\Interfaces\ReminderServiceInterface;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReminderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app()->make(ReminderServiceInterface::class);
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testGetUpcomingReminders()
    {
        $reminders = Reminder::factory([
            'user_id' => $this->user->id,
        ])->count(5)->create();

        $request = new ReminderUpcomingRequest();
        $request->merge(['limit' => 5]);
        $request->setUserResolver(function () {
            return $this->user;
        });

        $result = $this->service->getUpcomingReminders($request);

        $this->assertCount(5, $result);
        $this->assertEquals($reminders->pluck('id'), $result->pluck('id'));
    }

    public function testStoreReminder()
    {
        $request = new ReminderCreateRequest();
        $remindAt = now()->timestamp;
        $eventAt = now()->addDay()->timestamp;
        $request->merge([
            'title' => 'Test Reminder',
            'description' => 'Test Description',
            'remind_at' => $remindAt,
            'event_at' => $eventAt,
        ]);
        $request->setUserResolver(function () {
            return $this->user;
        });

        $reminder = $this->service->store($request);

        $this->assertEquals('Test Reminder', $reminder->title);
        $this->assertEquals('Test Description', $reminder->description);
        $this->assertEquals($remindAt, $reminder->remind_at->timestamp);
        $this->assertEquals($eventAt, $reminder->event_at->timestamp);
        $this->assertEquals($this->user->id, $reminder->user_id);
    }

    public function testUpdateReminder()
    {
        $reminder = Reminder::factory()->create([
            'title' => 'Old Title',
            'user_id' => $this->user->id
        ]);

        $request = new ReminderUpdateRequest();
        $request->merge(['title' => 'New Title']);
        $request->setUserResolver(function () {
            return $this->user;
        });

        $updatedReminder = $this->service->update($request, $reminder);

        $this->assertEquals('New Title', $updatedReminder->title);
    }

    public function testCannotUpdateReminderByOtherUser()
    {
        $reminder = Reminder::factory()->create([
            'title' => 'Old Title',
            'user_id' => $this->user->id
        ]);

        $otherUser = User::factory()->create();

        $request = new ReminderUpdateRequest();
        $request->merge(['title' => 'New Title']);
        $request->setUserResolver(function () use ($otherUser) {
            return $otherUser;
        });

        $this->expectException(ForbiddenAccessException::class);
        $this->service->update($request, $reminder);
    }

    public function testDeleteReminder()
    {
        $reminder = Reminder::factory()->create([
            'user_id' => $this->user->id
        ]);

        $request = new Request();
        $request->setUserResolver(function () {
            return $this->user;
        });
        $this->service->destroy($request, $reminder);

        $this->assertNull(Reminder::find($reminder->id));
    }

    public function testCannotDeleteReminderByOtherUser()
    {
        $reminder = Reminder::factory()->create([
            'user_id' => $this->user->id
        ]);

        $otherUser = User::factory()->create();

        $request = new Request();
        $request->setUserResolver(function () use ($otherUser) {
            return $otherUser;
        });

        $this->expectException(ForbiddenAccessException::class);
        $this->service->destroy($request, $reminder);
    }
}
