<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PenyakitRequest;
use App\Models\Penyakit;

class PenyakitController extends Controller
{
    // =====================
    //      WEB SECTION
    // =====================

    public function index()
    {
        $penyakit = Penyakit::latest()->get();
        return view('penyakit.index', ['penyakit' => $penyakit]);
    }

    public function create()
    {
        return view('penyakit.form', [
            'penyakit' => new Penyakit(),
            'page_meta' => [
                'title' => 'Create New Penyakit',
                'method' => 'POST',
                'url' => route('penyakit.store'),
                'button' => 'Create'
            ],
        ]);
    }

    public function store(PenyakitRequest $request)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:penyakit,code',
            'penyakit' => 'required|string|max:255|unique:penyakit,penyakit',
        ]);

        Penyakit::create($request->validated());
        return redirect()->route('penyakit.index')->with('success', 'Data berhasil dibuat');
    }

    public function show(Penyakit $penyakit)
    {
        return view('penyakit.show', compact('penyakit'));
    }

    public function edit(Penyakit $penyakit)
    {
        return view('penyakit.form', [
            'penyakit' => $penyakit,
            'page_meta' => [
                'title' => 'Update Penyakit ' . $penyakit->penyakit,
                'method' => 'PUT',
                'url' => route('penyakit.update', ['penyakit' => $penyakit->id]),
                'button' => 'Update'
            ],
        ]);
    }

    public function update(PenyakitRequest $request, Penyakit $penyakit)
    {
        $validated = $request->validate([
            'code'   => 'required|string|max:10|unique:penyakit,code',
            'penyakit' => 'required|string|max:255|unique:penyakit,penyakit',
        ]);

        $penyakit->update($request->validated());
        return redirect()->route('penyakit.index');
    }

    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();
        return redirect()->route('penyakit.index');
    }

    // =====================
    //      API SECTION
    // =====================

    /**
     * Get all penyakit (for API).
     */
    public function apiIndex()
    {
        $data = Penyakit::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Show single penyakit (for API).
     */
    public function apiShow($id)
    {
        $penyakit = Penyakit::find($id);

        if (!$penyakit) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $penyakit
        ]);
    }
}
