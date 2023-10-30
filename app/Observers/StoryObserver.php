<?php

namespace App\Observers;
use App\Models\Story;
use App\Services\V1\FileProcess\FileUploaderService;

class StoryObserver
{
    public function created(Story $story)
    {
        $file = request()->media;
        $fileService = new FileUploaderService($file);
        $fileService->save($story);
    }
}
