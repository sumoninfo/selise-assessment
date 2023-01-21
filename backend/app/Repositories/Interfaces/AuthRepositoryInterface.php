<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function login(Request $request);

    public function register(array $data);

    public function logout(Request $request);

    public function refreshToken(Request $request);
}

