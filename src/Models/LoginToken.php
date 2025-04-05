<?php

namespace ParvezMia\PasswordlessAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoginToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a secure token for the user.
     *
     * @param  int  $userId
     * @return self
     */
    public static function generateFor($userId)
    {
        $token = static::create([
            'user_id' => $userId,
            'token' => Str::random(config('passwordless-auth.token_length', 64)),
            'expires_at' => now()->addMinutes(config('passwordless-auth.token_expiration', 15)),
        ]);

        return $token;
    }

    /**
     * Check if the token has expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        return $this->expires_at->isPast();
    }

    /**
     * Get the user that owns the token.
     */
    public function user()
    {
        return $this->belongsTo(config('passwordless-auth.user_model'));
    }
}
