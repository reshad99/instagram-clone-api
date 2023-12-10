<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function getMyMateAttribute()
    {
        foreach ($this->roomMates as $mate) {
            if (auth()->user()->id != $mate->id) {
                return $mate;
            }
        }
    }

    public function lastMessage(): BelongsTo
    {
        // $message = Message::where('room_id', $this->id)->latest()->first();
        // return $message;
        return $this->belongsTo(Message::class, 'room_id')->latest()->first();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'room_id')->latest();
    }
}
