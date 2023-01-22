<?php

namespace App\Repositories;

use App\Http\Resources\AuthUserResource;
use App\Models\RefreshToken;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * token expires at
     *
     * @return Carbon
     */
    private function tokenExpiresAt(): Carbon
    {
        return Carbon::now()->addMinutes(5);
    }

    /**
     * login
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request): array
    {
        $user         = $request->user();
        $refreshToken = Str::random(30); // generate refresh token

        // create access token
        $token = $user->createToken('appToken', [], $this->tokenExpiresAt());

        // create refresh token
        self::makeRefreshToken($user->id, $token->accessToken->id, $refreshToken);

        return [
            'access_token'  => $token->plainTextToken,
            'token_type'    => 'Bearer',
            'expires_at'    => $token->accessToken['expires_at'],
            'refresh_token' => $refreshToken,
            'user'          => new AuthUserResource($user)
        ];
    }

    /**
     * create refresh token
     *
     * @param $userId
     * @param $tokenId
     * @param $refreshToken
     * @return void
     */
    public static function makeRefreshToken($userId, $tokenId, $refreshToken): void
    {
        RefreshToken::create([
            'user_id'                  => $userId,
            'personal_access_token_id' => $tokenId,
            'refresh_token'            => $refreshToken
        ]);
    }

    /**
     * register
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        return User::create($data);
    }

    /**
     * logout
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->refreshTokens()->delete();
    }
}
