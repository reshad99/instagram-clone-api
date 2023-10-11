<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    use HasFactory;

    public function blocker(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'blocker_id');
    }

    public function blocked(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'blocked_id');
    }
}
