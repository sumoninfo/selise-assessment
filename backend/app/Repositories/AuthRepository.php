<?php

namespace App\Repositories;

use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
        $user  = $request->user();
        $token = $user->createToken('appToken', [], $this->tokenExpiresAt());
        return [
            'access_token' => $token->plainTextToken,
            'token_type'   => 'Bearer',
            'expires_at'   => $token->accessToken['expires_at'],
            'user'         => new AuthUserResource($user)
        ];
    }

    /**
     * register
     *
     * @param array $data
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
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
        $request->user()->tokens()->delete();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        $token = $user->createToken('appToken', [], $this->tokenExpiresAt());
        return [
            'access_token' => $token->plainTextToken,
            'token_type'   => 'Bearer',
            'expires_at'   => $token->accessToken->expired_at,
        ];
    }

    public function refreshToken(Request $request)
    {
        // TODO: Implement refreshToken() method.
    }
}
