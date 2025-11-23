<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan daftar user (web)
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    // Tampilkan form tambah user (web)
    public function create()
    {
        return view('user.form', [
            'user' => new User(),
            'page_meta' => [
                'title' => 'Create New User',
                'method' => 'POST',
                'url' => route('user.store'),
                'button' => 'Create'
            ],
        ]);
    }

    // Simpan user baru (web)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('login')->with('success', 'User berhasil ditambahkan.');
    }

    // Tampilkan satu user (web)
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    // Tampilkan form edit user (web)
    public function edit(User $user)
    {
        return view('user.form', [
            'user' => $user,
            'page_meta' => [
                'title' => 'Update User ' . $user->name,
                'method' => 'PUT',
                'url' => route('user.update', $user),
                'button' => 'Update'
            ],
        ]);
    }

    // Update user (web)
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('home')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user (web)
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    // ===================== API =======================

    // GET /api/user - Ambil semua user
    public function apiIndex()
    {
        $users = User::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    // GET /api/user/{id} - Detail user
    public function apiShow($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }

    // POST /api/user - Tambah user baru
    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    // PUT /api/user/{id} - Update user
    public function apiUpdate(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $data = $request->only(['name', 'email', 'telepon']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    // DELETE /api/user/{id} - Hapus user
    public function apiDestroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ]);
    }
}
