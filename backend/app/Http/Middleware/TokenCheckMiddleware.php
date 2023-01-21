<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Carbon\Carbon;
use Closure;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class TokenCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() && $request->header('Authorization_refreshToken')) {
            $personalAccessToken = PersonalAccessToken::findToken($request->bearerToken())->where('expires_at', '>=', now())->first();
            if (empty($personalAccessToken)) {
                $refreshToken = \App\Models\RefreshToken::where(['refresh_token' => $request->header('Authorization_refreshToken')])->first();

                if ($refreshToken) {
                    PersonalAccessToken::find($refreshToken->personal_access_token_id)->update([
                        'expires_at' => now()->addMinute(5)
                    ]);
                }
            }
        }

        return $next($request);
    }
}
