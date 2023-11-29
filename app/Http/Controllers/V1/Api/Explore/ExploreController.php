<?php

namespace App\Http\Controllers\V1\Api\Explore;

use App\Http\Controllers\V1\Controller;
use App\Services\V1\Api\ExploreService;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    protected ExploreService $exploreService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->exploreService = new ExploreService(auth()->guard('customer')->user());
            return $next($request);
        });
    }

    public function search(string $query)
    {
        return $this->exploreService->search($query);
    }

    public function latestPosts()
    {
        return $this->exploreService->latestPosts();
    }
}
