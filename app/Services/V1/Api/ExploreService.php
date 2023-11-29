<?php

namespace App\Services\V1\Api;

use App\Http\Resources\V1\PaginatedResource;
use App\Http\Resources\V1\Post\PostResource;
use App\Http\Resources\V1\User\CustomerResource;
use App\Models\Customer;
use App\Models\Post;
use App\Services\V1\CommonService;
use App\Traits\ApiResponse;

class ExploreService extends CommonService
{
    use ApiResponse;

    public function __construct(Customer $customer)
    {
        parent::__construct(null, [], 'explore');
        $this->customer = $customer;
    }

    public function search(string $query)
    {
        try {
            $users = Customer::withCount('posts')->where('username', 'LIKE', '%' . $query . '%')->orderBy('posts_count', 'desc')->paginate(100);
            return new PaginatedResource(CustomerResource::collection($users));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function latestPosts()
    {
        try {
            $posts = Post::latest()->paginate(100);
            return new PaginatedResource(PostResource::collection($posts));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }
}
