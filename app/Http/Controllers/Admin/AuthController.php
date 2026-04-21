<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $token = $admin->createToken('admin-token', ['role:admin'])->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data'   => [
                'token' => $token,
                'admin' => ['id' => $admin->id, 'name' => $admin->name, 'email' => $admin->email],
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success', 'message' => 'Logged out.']);
    }
}