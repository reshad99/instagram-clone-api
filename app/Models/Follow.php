<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory;

    public function follower(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'follower_id');
    }

    public function followed(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'follower_id');
    }
}
