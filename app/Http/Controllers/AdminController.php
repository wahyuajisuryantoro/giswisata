<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        // Periksa apakah ada admin yang terautentikasi
        if (!Auth::guard('admin')->check()) {
            // Tidak ada admin yang terautentikasi, redirect ke halaman login
            return redirect()->route('admin.login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // Fetch the counts
        $adminCount = Admin::count();
        $wisataCount = Wisata::count();
    
        // Fetch the currently logged-in Admin details
        $currentAdmin = Auth::guard('admin')->user();
    
        // Pass the data to the view
        return view('admin.dashboard', compact('adminCount', 'wisataCount', 'currentAdmin'));
    }
    
    
}
