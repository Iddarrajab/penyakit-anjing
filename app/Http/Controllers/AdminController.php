<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampilkan daftar admin (web)
    public function index()
    {
        $admin = Admin::latest()->get();
        return view('admin.index', compact('admin'));
    }

    // Tampilkan form tambah admin (web)
    public function create()
    {
        return view('admin.form', [
            'admin' => new Admin(),
            'page_meta' => [
                'title' => 'Create New Admin',
                'method' => 'POST',
                'url' => route('admin.store'),
                'button' => 'Create'
            ],
        ]);
    }

    // Simpan admin baru (web)
    public function store(AdminRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Admin::create($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Tampilkan satu admin (web)
    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    // Tampilkan form edit admin (web)
    public function edit(Admin $admin)
    {
        return view('admin.form', [
            'admin' => $admin,
            'page_meta' => [
                'title' => 'Update Admin ' . $admin->name,
                'method' => 'PUT',
                'url' => route('admin.update', $admin),
                'button' => 'Update'
            ],
        ]);
    }

    // Update admin (web)
    public function update(AdminRequest $request, Admin $admin)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan ubah password kalau tidak dikirim
        }

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    // Hapus admin (web)
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }

    // ===================== API =======================

    // GET /api/admin - Ambil semua admin
    public function apiIndex()
    {
        $admin = Admin::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $admin
        ]);
    }

    // GET /api/admin/{id} - Detail admin
    public function apiShow($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $admin]);
    }

    // POST /api/admin - Tambah admin baru
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:admin,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil ditambahkan',
            'data' => $admin
        ]);
    }

    // PUT /api/admin/{id} - Update admin
    public function apiUpdate(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:admin,username,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'username']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil diperbarui',
            'data' => $admin
        ]);
    }

    // DELETE /api/admin/{id} - Hapus admin
    public function apiDestroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil dihapus'
        ]);
    }
}
