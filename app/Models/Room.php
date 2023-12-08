<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    public function roomMates(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'room_mates', 'room_id', 'customer_id');
    }
}
