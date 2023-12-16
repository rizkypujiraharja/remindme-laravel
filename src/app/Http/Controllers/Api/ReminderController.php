<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Resources\ReminderResource;
use App\Interfaces\ReminderServiceInterface;
use App\Traits\ApiResponses;

class ReminderController extends Controller
{
    use ApiResponses;

    protected $reminderService;

    public function __construct(ReminderServiceInterface $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    public function index(ReminderUpcomingRequest $request)
    {
        $reminders = $this->reminderService->getUpcomingReminders($request);

        return $this->successApiResponse([
            'reminders' => ReminderResource::collection($reminders),
            'limit' => $request->limit,
        ]);
    }
}
