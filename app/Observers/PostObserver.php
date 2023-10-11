<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\V1\FileProcess\FileUploaderService;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    public function created(Post $post)
    {
        $files = request()->media;

        Log::channel('posts')->info("post model in observer: " . json_encode($post));

        foreach ($files as $file) {
            $fileService = new FileUploaderService($file);
            $fileService->save($post);
        }
    }
}
