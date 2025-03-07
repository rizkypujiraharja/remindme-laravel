<?php

namespace App\Interfaces;

use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ReminderServiceInterface
{
    public function getUpcomingReminders(ReminderUpcomingRequest $request): Collection;
    public function store(ReminderCreateRequest $request): Reminder;
    public function update(ReminderUpdateRequest $request, Reminder $reminder): Reminder;
    public function destroy(Request $request, Reminder $reminder): void;
}
