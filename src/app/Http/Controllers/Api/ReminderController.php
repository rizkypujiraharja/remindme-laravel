<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpcomingRequest;
use App\Http\Requests\ReminderUpdateRequest;
use App\Http\Resources\ReminderResource;
use App\Interfaces\ReminderServiceInterface;
use App\Models\Reminder;
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

    public function store(ReminderCreateRequest $request)
    {
        $reminder = $this->reminderService->store($request);

        return $this->successApiResponse(new ReminderResource($reminder));
    }

    public function show(Reminder $reminder)
    {
        return $this->successApiResponse(new ReminderResource($reminder));
    }

    public function update(ReminderUpdateRequest $request, Reminder $reminder)
    {
        $reminder = $this->reminderService->update($request, $reminder);

        return $this->successApiResponse(new ReminderResource($reminder));
    }

    public function destroy(Reminder $reminder)
    {
        $this->reminderService->destroy($reminder);

        return $this->okOnlyApiResponse();
    }
}
