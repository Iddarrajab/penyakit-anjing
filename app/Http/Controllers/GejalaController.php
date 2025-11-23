<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use Illuminate\Validation\ValidationException;

class GejalaController extends Controller
{
    // ========================
    //      WEB CONTROLLERS
    // ========================

    public function index()
    {
        $gejala = Gejala::latest()->get();
        return view('gejala.index', ['gejala' => $gejala]);
    }

    public function create()
    {
        return view('gejala.form', [
            'gejala' => new Gejala(),
            'page_meta' => [
                'title' => 'Create New Gejala',
                'method' => 'POST',
                'url' => route('gejala.store'),
                'button' => 'create'
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:gejala,code',
            'gejala' => 'required|string|max:255|unique:gejala,gejala',
        ]);

        Gejala::create($validated);

        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function show(Gejala $gejala)
    {
        return view('gejala.show', compact('gejala'));
    }

    public function edit(Gejala $gejala)
    {
        return view('gejala.form', [
            'gejala' => $gejala,
            'page_meta' => [
                'title' => 'Update Gejala ' . $gejala->gejala,
                'method' => 'PUT',
                'url' => route('gejala.update', ['gejala' => $gejala->id]),
                'button' => 'update'
            ],
        ]);
    }

    public function update(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:gejala,code,' . $gejala->id,
            'gejala' => 'required|string|max:255|unique:gejala,gejala,' . $gejala->id,
        ]);

        $gejala->update($validated);

        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('gejala.index')->with('success', 'Data gejala berhasil dihapus.');
    }

    // ========================
    //        API SECTION
    // ========================

    public function apiIndex()
    {
        $data = Gejala::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Data gejala berhasil diambil.',
            'data' => $data
        ]);
    }

    public function apiShow($id)
    {
        $gejala = Gejala::find($id);

        if (!$gejala) {
            return response()->json([
                'status' => false,
                'message' => 'Data gejala tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail gejala ditemukan.',
            'data' => $gejala
        ]);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:gejala,code',
            'gejala' => 'required|string|max:255|unique:gejala,gejala',
        ]);

        $data = Gejala::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Data gejala berhasil ditambahkan.',
            'data' => $data
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $gejala = Gejala::find($id);

        if (!$gejala) {
            return response()->json([
                'status' => false,
                'message' => 'Data gejala tidak ditemukan.'
            ], 404);
        }

        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:gejala,code,' . $id,
            'gejala' => 'required|string|max:255|unique:gejala,gejala,' . $id,
        ]);

        $gejala->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Data gejala berhasil diperbarui.',
            'data' => $gejala
        ]);
    }

    public function apiDelete($id)
    {
        $gejala = Gejala::find($id);

        if (!$gejala) {
            return response()->json([
                'status' => false,
                'message' => 'Data gejala tidak ditemukan.'
            ], 404);
        }

        $gejala->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data gejala berhasil dihapus.'
        ]);
    }
}
