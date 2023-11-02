<?php

namespace App\Http\Controllers\V1\Api\Status;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\Status\AddStoryRequest;
use App\Models\Status;
use App\Models\Story;
use App\Services\V1\Api\StatusService;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    protected StatusService $statusService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->statusService = new StatusService(auth()->user());
            return $next($request);
        });
    }

    public function getStatuses()
    {
        return $this->statusService->getStatusList();
    }

    public function saveStory(AddStoryRequest $addStoryRequest)
    {
        return $this->statusService->saveStory($addStoryRequest);
    }

    public function getStatus(Status $status)
    {
        return $this->statusService->getStatus($status);
    }

    public function getStory(Story $story)
    {
        return $this->statusService->getStory($story);
    }

    public function viewStory(Story $story)
    {
        return $this->statusService->viewStory($story);
    }
}
