<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AkunController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.pages.account.index', compact('admins'));
    }

    public function add()
    {
        return view('admin.pages.account.add');
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:admins|max:255',
            'nama' => 'required',
            'password' => 'required|min:6'
        ]);

        $admin = new Admin();
        $admin->username = $validated['username'];
        $admin->nama = $validated['nama'];
        $admin->password = bcrypt($validated['password']);
        $admin->save();

        Alert::success('Berhasil', 'Admin baru telah ditambahkan.');
        return back();
    }
    

    public function edit($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->route('admins.index')->with('error', 'Admin tidak ditemukan');
        }
        return view('admin.pages.account.edit', compact('admin'));
    }
    

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'nama' => 'required',
        ]);
    
        $admin = Admin::find($id);
    
        if (!$admin) {
            Alert::error('Gagal', 'Admin tidak ditemukan.');
            return back();
        }
    
        if ($admin->update($validated)) {
            if (!empty($request->password)) {
                $admin->password = bcrypt($request->password);
                $admin->save();
            }
            Alert::success('Berhasil', 'Data berhasil diperbarui.');
            return redirect()->route('admin.akun');
        } else {
            Alert::error('Gagal', 'Tidak dapat update data.');
            return back();
        }
    }
    

    // Menghapus akun
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        Alert::success('Berhasil', 'Admin berhasil dihapus.');
        return back();
    }
}
