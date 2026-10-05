<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses otentikasi admin menggunakan nomor pegawai dan password.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'no_pegawai' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'no_pegawai.required' => 'Nomor pegawai wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('backend.dashboard'));
        }

        return back()->withErrors([
            'no_pegawai' => 'Nomor pegawai atau password yang Anda masukkan salah.',
        ])->onlyInput('no_pegawai');
    }

    /**
     * Logout pengguna dari sistem.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
