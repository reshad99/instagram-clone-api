<?php

namespace App\Services\V1\Api;

use App\Http\Resources\V1\Post\PostResource;
use App\Http\Resources\V1\User\CustomerResource;
use App\Models\Customer;
use App\Models\Post;
use App\Services\V1\CommonService;
use App\Traits\ApiResponse;

class ProfileService extends CommonService
{
    use ApiResponse;

    public function __construct()
    {
        parent::__construct(null, [], 'profile');
    }

    public function showProfile(Customer $customer)
    {
        try {
            return $this->dataResponse('Profile', new CustomerResource($customer));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showPosts(Customer $customer)
    {
        try {
            return $this->dataResponse('Posts', PostResource::collection($customer->posts()->latest()->get()));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showFollowers(Customer $customer)
    {
        try {
            $followers = $customer->followers()->latest()->get();
            return $this->dataResponse('Followers', CustomerResource::collection($followers));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function showFollows(Customer $customer)
    {
        try {
            $follows = $customer->follows()->latest()->get();
            return $this->dataResponse('Follows', CustomerResource::collection($follows));
        } catch (\Exception $e) {
            $this->logError($e);
            throw $e;
        }
    }
}
