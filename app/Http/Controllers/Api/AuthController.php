<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login via API menggunakan nomor pegawai dan password.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'no_pegawai' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'no_pegawai.required' => 'Nomor pegawai wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::query()->where('no_pegawai', $validated['no_pegawai'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Nomor pegawai atau password yang Anda masukkan salah.',
                'errors' => [
                    'no_pegawai' => ['Nomor pegawai atau password yang Anda masukkan salah.'],
                ],
            ], 422);
        }

        $token = Str::random(60);
        $user->forceFill(['api_token' => $token])->save();

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'no_pegawai' => $user->no_pegawai,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Dapatkan data user yang sedang login via Bearer token.
     */
    public function me(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = User::query()->where('api_token', $token)->first();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'no_pegawai' => $user->no_pegawai,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Logout dan cabut API token.
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if ($token) {
            User::query()->where('api_token', $token)->update(['api_token' => null]);
        }

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }
}
