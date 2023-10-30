<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Story extends Model
{
    use HasFactory;

    protected $appends = [
        'active', 'viewed'
    ];

    public function views(): HasMany
    {
        return $this->hasMany(StoryView::class);
    }

    public function getActiveAttribute()
    {
        $hoursSinceCreation = $this->created_at->diffInHours(Carbon::now());
        return $hoursSinceCreation <= 24;
    }

    public function getViewedAttribute()
    {
        $viewed = $this->views()->where('customer_id', auth()->user()->id)->first();
        return $viewed ? true : false;
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'fileable');
    }
}
