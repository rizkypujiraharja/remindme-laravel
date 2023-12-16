<?php

namespace App\Interfaces;

use App\Http\Requests\ReminderUpcomingRequest;
use Illuminate\Database\Eloquent\Collection;

interface ReminderServiceInterface
{
    public function getUpcomingReminders(ReminderUpcomingRequest $request): Collection;
}
