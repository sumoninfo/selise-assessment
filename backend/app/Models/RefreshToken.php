<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\PersonalAccessToken;

class RefreshToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'personal_access_token_id', 'refresh_token'];

    /**
     * Get the user that owns the refresh token.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the personal access token that owns the refresh token.
     */
    public function personalAccessToken(): BelongsTo
    {
        return $this->belongsTo(PersonalAccessToken::class);
    }
}
