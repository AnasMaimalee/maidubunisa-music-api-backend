<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maimalee\LaravelApiResponse\ApiResponse;

class AuthController extends Controller
{
    protected ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return $this->response->error('Invalid credentials', 401);
        }

        return $this->response->success([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return $this->response->success(null, 'Logged out successfully');
    }

    public function me()
    {
        return $this->response->success(
            Auth::guard('api')->user()
        );
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $user = auth('api')->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            return $this->response->error('Current password is incorrect', 422);
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return $this->response->success(null, 'Password updated successfully');
    }
}
