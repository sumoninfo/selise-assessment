<?php

namespace App\Http\Middleware;

use App\Models\RefreshToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class TokenCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $bearerToken  = $request->bearerToken();
        $refreshToken = $request->header('Authorization_RefreshToken');

        // check bearer and refresh token from request
        if (!$bearerToken || !$refreshToken) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // check bearer token exists and token expires_at
        $pATExists = PersonalAccessToken::findToken($bearerToken);

        // check refresh token
        $refreshTokenExists = RefreshToken::where(['refresh_token' => $refreshToken])->first();

        if (empty($pATExists) || empty($refreshTokenExists)) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // check token expires_at
        $pATExpireAt = $pATExists->where('expires_at', '<=', Carbon::now()->toDateTimeString())->first();

        if (!empty($pATExpireAt)) {
            $pATExpireAt->update([
                'expires_at' => Carbon::now()->addMinutes(5)
            ]);
        }

        return $next($request);
    }
}
