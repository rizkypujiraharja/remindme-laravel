<?php

namespace App\Services;

use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
use App\Interfaces\ReminderServiceInterface;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Collection;

class ReminderService implements ReminderServiceInterface
{
    public function getUpcomingReminders(ReminderUpcomingRequest $request): Collection
    {
        $reminders = Reminder::UpcomingEvent()->limit($request->limit)->get();

        return $reminders;
    }

    public function store(ReminderCreateRequest $request): Reminder
    {
        $reminder = new Reminder;
        $reminder->fill($request->validated());
        $reminder->user_id = $request->user()->id;
        $reminder->save();

        return $reminder;
    }

    public function update(ReminderUpdateRequest $request, Reminder $reminder): Reminder
    {
        $reminder->update($request->validated());

        return $reminder;
    }

    public function destroy(Reminder $reminder): void
    {
        $reminder->delete();
    }
}
