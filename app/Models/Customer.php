<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function media()
    {
        return $this->morphOne(Media::class, 'fileable');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'customer_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'follows', 'followed_id', 'follower_id');
    }

    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'follows', 'follower_id', 'followed_id');
    }

    public function blockedBy(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'blocks', 'blocked_id', 'blocker_id');
    }

    public function blocks(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'blocks', 'blocker_id', 'blocked_id');
    }

    public function getFollowedAttribute(): bool
    {
        $myId = Auth::user()->id;
        $follow = Follow::where('follower_id', $myId)->where('followed_id', $this->id)->first();

        if ($follow) {
            return true;
        }

        return false;
    }
}
