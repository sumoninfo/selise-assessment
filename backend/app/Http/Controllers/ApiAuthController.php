<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    private AuthRepositoryInterface $repository;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * User Login
     *
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password', 'remember_me']);

        if (!Auth::attempt($credentials)) {
            return $this->returnResponse("error", "These credentials do not match our records", [], 403);
        }

        $response = $this->repository->login($request);
        return $this->returnResponse("success", "Successfully Login", $response);
    }

    /**
     * User register
     *
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        try {
            $response = $this->repository->register($request->only('first_name', 'last_name', 'email', 'password'));
            return $this->returnResponse("success", "Successfully Registration", $response);
        } catch (\Exception $exception) {
            return $this->returnResponse("error", $exception->getMessage(), [], $exception->getCode());
        }
    }

    /**
     * User Logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->repository->logout($request);
        return $this->returnResponse("success", 'Successfully logged out');
    }

    /**
     * Refresh token generate
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $response = $this->repository->refreshToken($request);
            return $this->returnResponse("success", "Refresh token generated", $response);
        } catch (\Exception $exception) {
            return $this->returnResponse("error", $exception->getMessage(), [], $exception->getCode());
        }
    }
}
