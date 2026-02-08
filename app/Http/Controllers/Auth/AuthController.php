<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Cek credentials
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak sesuai dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Buat admin user (untuk setup pertama kali saja)
     * Akses via: /auth/create-admin
     */
    public function createAdmin()
    {
        // Check if admin sudah exists
        $adminExists = User::where('email', 'admin@donasi.app')->first();

        if ($adminExists) {
            return response()->json([
                'message' => 'Admin sudah terdaftar',
                'email' => 'admin@donasi.app',
                'password' => 'Lihat di database'
            ]);
        }

        // Buat admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@donasi.app',
            'password' => Hash::make('admin123456'),
        ]);

        return response()->json([
            'message' => 'Admin berhasil dibuat',
            'email' => 'admin@donasi.app',
            'password' => 'admin123456',
            'note' => 'Segera ganti password setelah login!'
        ]);
    }
}

