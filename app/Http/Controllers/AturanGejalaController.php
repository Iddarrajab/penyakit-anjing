<?php

namespace App\Http\Controllers;

use App\Models\AturanGejala;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Http\Requests\AturanGejalaRequest;
use Illuminate\Http\Request;

class AturanGejalaController extends Controller
{
    /**
     * ======================
     * WEB CONTROLLER SECTION
     * ======================
     */

    public function index()
    {
        $data = AturanGejala::with(['aturan.penyakit', 'gejala'])->latest()->get();

        return view('aturangejala.index', compact('data'));
    }

    public function create()
    {
        return view('aturangejala.form', [
            'aturanList' => Aturan::with('penyakit')->get(),
            'gejalaList' => Gejala::all(),
            'selectedAturanGejala' => null,
            'page_meta' => [
                'title' => 'Tambah Aturan-Gejala',
                'method' => 'POST',
                'url' => route('aturangejala.store'),
                'button' => 'Simpan Data'
            ]
        ]);
    }

    public function store(AturanGejalaRequest $request)
    {
        AturanGejala::updateOrCreate(
            [
                'aturan_id' => $request->aturan_id,
                'gejala_id' => $request->gejala_id,
            ],
            [
                'cf' => $request->cf,
            ]
        );

        return redirect()->route('aturangejala.index')->with('success', 'Aturan-Gejala berhasil disimpan.');
    }

    public function edit(AturanGejala $aturangejala)
    {
        return view('aturangejala.form', [
            'selectedAturanGejala' => $aturangejala,
            'aturanList' => Aturan::with('penyakit')->get(),
            'gejalaList' => Gejala::all(),
            'page_meta' => [
                'title' => 'Edit Aturan-Gejala',
                'method' => 'PUT',
                'url' => route('aturangejala.update', $aturangejala->id),
                'button' => 'Perbarui Data'
            ]
        ]);
    }

    public function update(AturanGejalaRequest $request, AturanGejala $aturangejala)
    {
        $aturangejala->update($request->validated());

        return redirect()->route('aturangejala.index')->with('success', 'Aturan-Gejala berhasil diperbarui.');
    }

    public function destroy(AturanGejala $aturangejala)
    {
        $aturangejala->delete();

        return redirect()->route('aturangejala.index')->with('success', 'Aturan-Gejala berhasil dihapus.');
    }


    /**
     * ======================
     * API CONTROLLER SECTION
     * ======================
     */

    public function apiIndex()
    {
        $data = AturanGejala::with(['aturan.penyakit', 'gejala'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Data aturan-gejala berhasil diambil.',
            'data' => $data
        ]);
    }

    public function apiShow($id)
    {
        $data = AturanGejala::with(['aturan.penyakit', 'gejala'])->find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail aturan-gejala ditemukan.',
            'data' => $data
        ]);
    }

    public function apiStore(AturanGejalaRequest $request)
    {
        $data = AturanGejala::updateOrCreate(
            [
                'aturan_id' => $request->aturan_id,
                'gejala_id' => $request->gejala_id,
            ],
            [
                'cf' => $request->cf,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Data aturan-gejala berhasil disimpan.',
            'data' => $data
        ]);
    }

    public function apiUpdate(AturanGejalaRequest $request, $id)
    {
        $data = AturanGejala::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        $data->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data aturan-gejala berhasil diperbarui.',
            'data' => $data
        ]);
    }

    public function apiDelete($id)
    {
        $data = AturanGejala::find($id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan.'], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data aturan-gejala berhasil dihapus.'
        ]);
    }
}
