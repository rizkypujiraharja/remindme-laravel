<?php

namespace App\Services;

use App\Exceptions\ForbiddenAccessException;
use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
use App\Interfaces\ReminderServiceInterface;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReminderService implements ReminderServiceInterface
{
    public function getUpcomingReminders(ReminderUpcomingRequest $request): Collection
    {
        $reminders = Reminder::upcomingEvent()
            ->where('user_id', $request->user()->id)
            ->limit($request->limit)
            ->get();

        return $reminders;
    }

    public function store(ReminderCreateRequest $request): Reminder
    {
        $reminder = new Reminder;
        $reminder->fill($request->only('title', 'description', 'remind_at', 'event_at'));
        $reminder->user_id = $request->user()->id;
        $reminder->save();

        return $reminder;
    }

    public function update(ReminderUpdateRequest $request, Reminder $reminder): Reminder
    {
        if ($request->user()->id !== $reminder->user_id) {
            throw new ForbiddenAccessException();
        }
        $reminder->update($request->only('title', 'description', 'remind_at', 'event_at'));

        return $reminder;
    }

    public function destroy(Request $request, Reminder $reminder): void
    {
        if ($request->user()->id !== $reminder->user_id) {
            throw new ForbiddenAccessException();
        }
        $reminder->delete();
    }
}
