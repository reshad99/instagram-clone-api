<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['uid'];

    public function roomMates(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'room_mates', 'room_id', 'customer_id');
    }

    public function getLastMessageAttribute()
    {
        $message = Message::where('room_id', $this->uid)->latest()->first();
        return $message;
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'room_id')->latest();
    }
}
