<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'activeStories',
        'viewed'
    ];

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getActiveStoriesAttribute()
    {
        $activeStories = $this->stories->filter(function ($story) {
            if ($story->active == true)
                return $story;
        });

        return $activeStories;
    }

    public function getViewedAttribute()
    {
        return $this->stories->every(function ($story) {
            return $story->viewed == true;
        });
    }
}
