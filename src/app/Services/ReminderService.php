<?php

namespace App\Services;

use App\Http\Requests\ReminderUpcomingRequest;
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
}
