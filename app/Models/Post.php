<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    public function getLikedAttribute(): bool
    {
        $liked = Like::where('post_id', $this->id)->where('customer_id', auth()->user()->id)->first() ? true : false;
        return $liked;
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'likes')->latest();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id')->latest();
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'fileable');
    }
}
