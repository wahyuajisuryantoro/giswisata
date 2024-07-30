<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WisataController extends Controller
{
    public function index()
    {
        $accessToken = env('PUBLIC_MAPBOX_ACCESS_TOKEN');
        $wisatas = Wisata::all();
        return view('admin.pages.website.index', compact('accessToken', 'wisatas'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Anda harus login sebagai admin untuk menambahkan wisata.'], 403);
        }
        
        $validatedData = $request->validate([
            'id_admin' => 'required|exists:admins,id_admin',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'img_url' => 'required|url',
        ]);
        
        Wisata::create($validatedData);
        return redirect()->back()->with('success','Data Wisata Berhasil Ditambahkan' );
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Anda harus login sebagai admin untuk mengedit wisata.'], 403);
        }

        $validatedData = $request->validate([
            'id_admin' => 'required|exists:admins,id_admin',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'img_url' => 'required|url',
        ]);

        $wisata = Wisata::findOrFail($id);
        $wisata->update($validatedData);

        return response()->json(['success' => 'Wisata berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Anda harus login sebagai admin untuk menghapus wisata.'], 403);
        }

        $wisata = Wisata::findOrFail($id);
        $wisata->delete();

        return response()->json(['success' => 'Wisata berhasil dihapus.']);
    }
}
