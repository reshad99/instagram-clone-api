<?php

namespace App\Http\Controllers\V1\Api\Post;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\Post\SavePostRequest;
use App\Models\Post;
use App\Services\V1\Api\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->postService = new PostService(auth()->guard('customer')->user());
            return $next($request);
        });
    }

    public function showPost(Post $post)
    {
        return $this->postService->showPost($post);
    }

    public function getPosts()
    {
        return $this->postService->getPosts();
    }

    public function myPosts()
    {
        return $this->postService->myPosts();
    }

    public function savePost(SavePostRequest $savePostRequest)
    {
        return $this->postService->savePost($savePostRequest);
    }

    public function likePost(Post $post)
    {
        return $this->postService->likePost($post);
    }

    public function addComment(Request $request, Post $post)
    {
        return $this->postService->addComment($request, $post);
    }

    public function showLikes(Post $post)
    {
        return $this->postService->showLikes($post);
    }

    public function showComments(Post $post)
    {
        return $this->postService->showComments($post);
    }
}
