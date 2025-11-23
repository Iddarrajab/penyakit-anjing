<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Aturan;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Http\Requests\AturanRequest;

class AturanController extends Controller
{
    public function index()
    {
        $aturan = Aturan::with('penyakit')->latest()->get();
        return view('aturan.index', compact('aturan'));
    }

    public function create()
    {
        return view('aturan.form', [
            'penyakitList' => Penyakit::all(),
            'gejalaList'   => Gejala::all(),
            'aturan'       => new Aturan(),
            'page_meta'    => [
                'title'  => 'Tambah Aturan',
                'method' => 'POST',
                'url'    => route('aturan.store'),
                'button' => 'Simpan',
            ],
        ]);
    }

    public function store(AturanRequest $request)
    {
        $aturan = Aturan::create([
            'code'        => $request->code,
            'penyakit_id' => $request->penyakit_id,
        ]);

        // Simpan relasi gejala + nilai CF
        $syncData = [];
        foreach ($request->gejala_ids as $gejala_id) {
            $cf = $request->cf[$gejala_id] ?? 0.5;
            $syncData[$gejala_id] = ['cf' => $cf];
        }
        $aturan->gejala()->sync($syncData);

        return redirect()->route('aturan.index')->with('success', 'Data aturan berhasil disimpan.');
    }

    public function edit(Aturan $aturan)
    {
        $aturan->load('gejala');

        return view('aturan.form', [
            'aturan'       => $aturan,
            'penyakitList' => Penyakit::all(),
            'gejalaList'   => Gejala::all(),
            'page_meta'    => [
                'title'  => 'Edit Aturan: ' . $aturan->code,
                'method' => 'PUT',
                'url'    => route('aturan.update', $aturan->id),
                'button' => 'Update',
            ],
        ]);
    }

    public function update(AturanRequest $request, Aturan $aturan)
    {
        $aturan->update([
            'code'        => $request->code,
            'penyakit_id' => $request->penyakit_id,
        ]);

        $syncData = [];
        foreach ($request->gejala_ids as $gejala_id) {
            $cf = $request->cf[$gejala_id] ?? 0.5;
            $syncData[$gejala_id] = ['cf' => $cf];
        }
        $aturan->gejala()->sync($syncData);

        return redirect()->route('aturan.index')->with('success', 'Data aturan berhasil diperbarui.');
    }

    public function destroy(Aturan $aturan)
    {
        $aturan->gejala()->detach();
        $aturan->delete();

        return redirect()->route('aturan.index')->with('success', 'Data aturan berhasil dihapus.');
    }
}
