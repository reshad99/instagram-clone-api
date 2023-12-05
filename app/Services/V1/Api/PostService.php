<?php

namespace App\Services\V1\Api;

use App\Http\Requests\V1\Post\SavePostRequest;
use App\Http\Resources\V1\PaginatedResource;
use App\Http\Resources\V1\Post\CommentResource;
use App\Http\Resources\V1\Post\PostResource;
use App\Http\Resources\V1\User\CustomerResource;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Like;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\V1\CommonService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostService extends CommonService
{
    use ApiResponse;
    protected Customer $customer;

    public function __construct(Customer $customer)
    {
        parent::__construct(new PostRepository, [], 'posts');
        $this->customer = $customer;
    }

    public function savePost(SavePostRequest $savePostRequest)
    {
        try {
            return DB::transaction(function () use ($savePostRequest) {
                $data = $savePostRequest->validated();
                $data['customer_id'] = $this->customer->id;
                $post = $this->mainRepository->store($data);
                return $this->dataResponse('Post created', new PostResource($post));
            });
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function getPosts()
    {
        try {
            $follows = $this->getFollowedCustomerIds();
            $blocks = $this->getBlockedCustomerIds();
            $follows[] = $this->customer->id;
            $posts = Post::whereIn('customer_id', $follows)->whereNotIn('customer_id', $blocks)->latest()->paginate($this->getPostsPerPage());
            return new PaginatedResource(PostResource::collection($posts));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function myPosts()
    {
        try {
            $posts = Post::where('customer_id', $this->customer->id)->latest()->get();
            return $this->dataResponse('My posts', PostResource::collection($posts));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showPost(Post $post)
    {
        try {
            return $this->dataResponse('Post', new PostResource($post));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showLikes(Post $post)
    {
        try {
            return $this->dataResponse('Likes', CustomerResource::collection($post->likes));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showComments(Post $post)
    {
        try {
            return $this->dataResponse('Likes', CommentResource::collection($post->comments));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function likePost(Post $post)
    {
        try {
            $likeCheck = Like::where('post_id', $post->id)->where('customer_id', $this->customer->id)->first();
            if ($likeCheck) {
                $likeCheck->delete();
            } else {
                Like::create(['post_id' => $post->id, 'customer_id' => $this->customer->id]);
            }
            return $this->successResponse();
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function addComment(Request $request, Post $post)
    {
        try {
            $request->validate([
                'text' => 'required|max:255'
            ]);
            $comment = Comment::create(['post_id' => $post->id, 'customer_id' => $this->customer->id, 'text' => $request->text]);
            return $this->dataResponse('Comment created', new CommentResource($comment));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    private function getFollowedCustomerIds()
    {
        return $this->customer->follows()->pluck('customers.id');
    }

    private function getBlockedCustomerIds()
    {
        return $this->customer->blocks()->pluck('customers.id');
    }

    private function getPostsPerPage()
    {
        return 100;
    }
}
