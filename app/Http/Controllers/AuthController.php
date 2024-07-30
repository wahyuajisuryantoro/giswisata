<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->only('username', 'password');
        Log::info('Percobaan login oleh username: ' . $credentials['username']);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            // Ambil objek admin yang terautentikasi
            $admin = Auth::guard('admin')->user();
    
            if ($admin) {
                Log::info('Login berhasil oleh admin dengan ID: ' . $admin->id);
                Alert::success('Berhasil Login', 'Anda berhasil login sebagai admin dengan ID: ' . $admin->id_admin);
                return redirect()->route('admin.dashboard');
            } else {
                Alert::error('Gagal Login', 'Tidak dapat mengidentifikasi data admin.');
                return back()->withInput($request->only('username'));
            }
        }
    
        Log::warning('Login gagal oleh username: ' . $credentials['username']);
        Alert::error('Gagal Login', 'Username atau password salah.');
        return back()->withInput($request->only('username'));
    }
    
    

    public function logoutProcess(Request $request)
    {
        $username = Auth::guard('admin')->user()->username;
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info('Logout berhasil oleh admin dengan username: ' . $username);

        Alert::success('Berhasil Logout', 'Anda telah berhasil logout.');

        return redirect()->route('admin.login');
    }
}
