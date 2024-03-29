<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Post;
use App\Models\Story;
use App\Observers\CustomerObserver;
use App\Observers\PostObserver;
use App\Observers\StoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Customer::observe(CustomerObserver::class);
        Post::observe(PostObserver::class);
        Story::observe(StoryObserver::class);
    }
}
