<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginApiRequest;
use App\Interfaces\AuthServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthServiceInterface $authService) {}

    public function login(LoginApiRequest $request)
    {
        $data = $this->authService->login($request->only("email", "password"));

        return $this->successResponse($data, "Login berhasil");
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->successResponse(null, "Logout berhasil.");
    }
}
