<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\Aturan;
use App\Models\Diagnosa;
use Illuminate\Support\Facades\Auth;

class DiagnosaController extends Controller
{
    public function index()
    {
        $query = Diagnosa::with(['penyakit', 'user']);

        $user = Auth::user();
        if ($user) {
            $query->where('user_id', $user->id);
        }

        $riwayat = $query->latest()->get();

        $hasil = $riwayat->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_hewan' => $item->nama_hewan ?? '-',
                'penyakit'   => $item->penyakit->penyakit ?? 'Tidak diketahui',
                'cf'         => $item->nilai_cf ?? 0,
                'obat'       => $item->penyakit->obat ?? '-',
                'solusi'     => $item->penyakit->solusi ?? '-',
                'user'       => $item->user->name ?? '-',
                'created_at' => $item->created_at->format('d-m-Y H:i'),
            ];
        });

        return view('diagnosa.index', [
            'hasil' => $hasil,
            'page_meta' => [
                'title' => 'Hasil Diagnosa',
                'description' => 'Berikut adalah hasil analisis berdasarkan gejala yang Anda pilih.',
            ],
        ]);
    }

    public function create()
    {
        $gejala = Gejala::all();

        return view('diagnosa.form', [
            'gejala' => $gejala,
            'page_meta' => [
                'title' => 'Form Diagnosa Penyakit Hewan',
                'description' => 'Silakan isi gejala yang muncul pada hewan Anda dan tingkat keyakinannya.',
                'url' => route('diagnosa.store'),
                'method' => 'POST',
                'button' => 'Diagnosa Sekarang',
            ],
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->has('gejala') || empty($request->gejala)) {
            return back()->with('error', 'Silakan pilih minimal satu gejala.')->withInput();
        }

        $gejalaDipilih = $request->input('gejala');
        $cfUserInput = $request->input('cf_user', []); // nilai keyakinan user per gejala
        $namaHewan = $request->input('nama_hewan', '-');
        $userId = Auth::id();

        // Cek apakah kombinasi gejala sudah pernah didiagnosa oleh user
        $riwayatUser = Diagnosa::where('user_id', $userId)->get();
        foreach ($riwayatUser as $riwayat) {
            $gejalaRiwayat = $riwayat->gejala()->pluck('gejala_id')->toArray() ?? [];
            sort($gejalaRiwayat);
            $gejalaSekarang = $gejalaDipilih;
            sort($gejalaSekarang);

            if ($gejalaRiwayat == $gejalaSekarang) {
                return back()->with('error', 'Gejala ini sudah pernah Anda diagnosa sebelumnya.')->withInput();
            }
        }

        // Proses diagnosa (Decision Tree + Certainty Factor)
        $hasil = $this->prosesDiagnosa($gejalaDipilih, $cfUserInput);

        if (empty($hasil)) {
            return redirect()->route('diagnosa.index')->with('error', 'Tidak ada penyakit yang terdiagnosa.');
        }

        // Ambil hasil dengan CF tertinggi
        $tertinggi = $hasil[0];

        // Simpan ke tabel diagnosa
        $diagnosaBaru = Diagnosa::create([
            'nama_hewan' => $namaHewan,
            'penyakit_id' => $tertinggi['id'],
            'nilai_cf' => $tertinggi['cf'],
            'user_id' => $userId,
        ]);

        $diagnosaBaru->gejala()->attach($gejalaDipilih);

        return redirect()->route('diagnosa.index')->with('success', 'Diagnosa berhasil dilakukan.');
    }

    private function prosesDiagnosa(array $gejalaDipilih, array $cfUserInput)
    {
        $aturanList = Aturan::with(['gejala', 'penyakit'])->get();
        $hasilDiagnosa = [];

        foreach ($aturanList as $aturan) {
            $gejalaAturan = $aturan->gejala;
            $cfGabungan = 0;
            $adaKecocokan = false;

            foreach ($gejalaAturan as $g) {
                if (in_array($g->id, $gejalaDipilih)) {
                    $adaKecocokan = true;

                    $cfPakar = $g->pivot->cf ?? 0;        // CF dari pakar
                    $cfUser = $cfUserInput[$g->id] ?? 1;  // CF dari user

                    $cfGejala = $cfPakar * $cfUser;       // CF untuk gejala ini

                    // Rumus kombinasi CF
                    if ($cfGabungan == 0) {
                        $cfGabungan = $cfGejala;
                    } else {
                        $cfGabungan = $cfGabungan + $cfGejala * (1 - $cfGabungan);
                    }
                }
            }

            if ($adaKecocokan && $cfGabungan > 0) {
                $penyakit = $aturan->penyakit;
                $hasilDiagnosa[] = [
                    'id' => $penyakit->id,
                    'penyakit' => $penyakit->penyakit ?? 'Tidak diketahui',
                    'cf' => round($cfGabungan, 4),
                    'obat' => $penyakit->obat ?? '-',
                    'solusi' => $penyakit->solusi ?? '-',
                ];
            }
        }

        // Urutkan berdasarkan nilai CF terbesar
        usort($hasilDiagnosa, fn($a, $b) => $b['cf'] <=> $a['cf']);

        return $hasilDiagnosa;
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Anda harus login sebagai admin untuk menghapus data.');
        }

        $diagnosa = Diagnosa::findOrFail($id);
        $diagnosa->gejala()->detach();
        $diagnosa->delete();

        return redirect()->route('diagnosa.index')->with('success', 'Data diagnosa berhasil dihapus.');
    }
}
