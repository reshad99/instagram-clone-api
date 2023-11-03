<?php

namespace App\Services\V1\Api;

use App\Http\Requests\V1\Status\AddStoryRequest;
use App\Http\Resources\V1\Status\StatusResource;
use App\Http\Resources\V1\Status\StoryResource;
use App\Models\Customer;
use App\Models\Status;
use App\Models\Story;
use App\Models\StoryView;
use App\Services\V1\CommonService;
use App\Traits\ApiResponse;

class StatusService extends CommonService
{
    use ApiResponse;
    protected Customer $customer;
    public function __construct(Customer $customer)
    {
        parent::__construct(null, [], 'status');
        $this->customer = $customer;
    }

    public function getStatus(Status $status)
    {
        return $this->dataResponse('Status', new StatusResource($status));
    }

    public function getStory(Story $story)
    {
        return $this->dataResponse('Story', new StoryResource($story));
    }

    public function getStatusList()
    {
        try {
            $statuses = Status::whereIn("id", optional($this->customer)->follows->pluck('id'))->get();
            return $this->dataResponse('Statuses', StatusResource::collection($statuses));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function saveStory(AddStoryRequest $addStoryRequest)
    {
        try {
            $status = $this->status() ?? $this->createStatus();
            $story = new Story();
            $story->position = $addStoryRequest->position;
            $story->text = $addStoryRequest->text;
            $story->status_id = $status->id;
            $story->customer_id = $this->customer->id;
            $story->save();
            return $this->dataResponse('Story added', new StoryResource($story));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function viewStory(Story $story)
    {
        try {
            $storyView = StoryView::where('story_id', $story->id)->where('customer_id', $this->customer->id)->first();
            if (!$storyView) {
                $storyView = new StoryView;
                $storyView->story_id = $story->id;
                $storyView->customer_id = $this->customer->id;
                $storyView->save();
            }
            return $this->successResponse();
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function createStatus()
    {
        $status = new Status;
        $status->customer_id = $this->customer->id;
        $status->save();
        return $status;
    }

    private function status(): Status|null
    {
        $status = Status::where('customer_id', $this->customer->id)->first();
        return $status ?? null;
    }


}
