<?php

namespace App\Http\Controllers\V1\Api\Profile;

use App\Http\Controllers\V1\Controller;
use App\Models\Customer;
use App\Services\V1\Api\Profile\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->profileService = new ProfileService();
            return $next($request);
        });
    }

    public function showProfile(Customer $customer)
    {
        return $this->profileService->showProfile($customer);
    }

    public function showPosts(Customer $customer)
    {
        return $this->profileService->showPosts($customer);
    }

    public function showFollowers(Customer $customer)
    {
        return $this->profileService->showFollowers($customer);
    }

    public function showFollows(Customer $customer)
    {
        return $this->profileService->showFollows($customer);
    }
}
