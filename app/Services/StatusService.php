<?php

namespace App\Services;

use App\Http\Requests\StatusRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;

class StatusService
{
    public function getAllStatus()
    {
        return StatusResource::collection(Status::paginate());
    }

    public function createStatus(StatusRequest $request): Status
    {
        $status = new Status();

        $status->number = $request->number ?? Status::count() + 1;
        $status->name = $request->name;

        $status->save();

        return $status;
    }

    public function updateStatus(Status $status, StatusRequest $request): bool
    {
        if ($request->number) {
            $status->number = $request->number;
        }
        $status->name = $request->name;

        return $status->save();
    }

    public function destroyStatus(Status $status): bool
    {
        return $status->delete();
    }
}
