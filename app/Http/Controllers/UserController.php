<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // ===================== WEB =======================

    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.form', [
            'user' => new User(),
            'page_meta' => [
                'title' => 'Register User',
                'method' => 'POST',
                'url' => route('user.store'),
                'button' => 'Register'
            ],
        ]);
    }

    // 🔥 STEP 1: REGISTER (TIDAK MASUK DATABASE)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $otp = rand(100000, 999999);

        // simpan ke session
        session([
            'register_data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'password' => Hash::make($validated['password']),
                'otp' => $otp,
                'otp_expired_at' => now()->addMinutes(5),
            ]
        ]);

        // kirim email OTP
        try {
            Mail::to($validated['email'])->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal kirim email: ' . $e->getMessage());
        }

        return redirect('/verify-otp')->with('success', 'OTP dikirim ke email');
    }

    // ================= OTP =================

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    // 🔥 STEP 2: VERIFIKASI OTP → SIMPAN KE DB
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $data = session('register_data');

        if (!$data) {
            return redirect()->route('login')->with('error', 'Session habis, daftar ulang');
        }

        if ($request->otp != $data['otp']) {
            return back()->with('error', 'OTP salah');
        }

        if (now()->gt($data['otp_expired_at'])) {
            return back()->with('error', 'OTP sudah kadaluarsa');
        }

        // 🔥 simpan ke database
        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'password' => $data['password'],
                'is_verified' => true
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal simpan user: ' . $e->getMessage());
        }

        // hapus session
        session()->forget('register_data');

        return redirect()->route('login')->with('success', 'Registrasi berhasil');
    }

    // ================= CRUD =================

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    // ===================== API =======================

    public function apiIndex()
    {
        return response()->json([
            'status' => 'success',
            'data' => User::latest()->get()
        ]);
    }

    public function apiShow($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }

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
