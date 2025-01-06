<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(): View
    {
        // Fetch only active news and order by ber_tgl in descending order
        $berita = Berita::where('ber_status', 'aktif')
            ->orderBy('ber_tgl', 'DESC')
            ->get();
        return view('berita.index', compact('berita'));
    }


    public function read(): View
    {
        // Fetch only active news and order by ber_tgl in descending order
        $berita = Berita::where('ber_status', 'aktif')
            ->orderBy('ber_tgl', 'DESC')
            ->get();
        return view('berita.read', compact('berita'));
    }

    public function add(): View
    {
        return view('berita.add');
    }

    public function edit($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('berita.edit', compact('berita'));
    }

    public function show($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }

    public function see($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('berita.see', compact('berita'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'ber_judul' => 'required|string|max:255',
            'ber_tgl' => 'required|date',
            'ber_penulis' => 'required|string|max:255',
            'ber_isi' => 'required|string',
            'ber_foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ber_foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ber_foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $berita = new Berita();
        $berita->ber_judul = $request->ber_judul;
        $berita->ber_tgl = $request->ber_tgl;
        $berita->ber_penulis = $request->ber_penulis;
        $berita->ber_isi = $request->ber_isi;
        $berita->ber_status = 'Aktif';
        $berita->ber_created_by = 'user';
        $berita->ber_created_date =   now();

        foreach (range(1, 3) as $index) {
            $fileKey = "ber_foto{$index}";
            if ($request->hasFile($fileKey)) {
                $berita->{$fileKey} = $request->file($fileKey)->store('berita', 'public');
            }
        }

        $berita->save();

        return redirect()->route('berita.read')->with('success', 'Berita berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ber_judul' => 'required|string|max:255',
            'ber_tgl' => 'required|date',
            'ber_penulis' => 'required|string|max:255',
            'ber_isi' => 'required|string',
            'ber_foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ber_foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'ber_foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $berita = Berita::findOrFail($id);
        $berita->ber_judul = $request->ber_judul;
        $berita->ber_tgl = $request->ber_tgl;
        $berita->ber_penulis = $request->ber_penulis;
        $berita->ber_isi = $request->ber_isi;
        $berita->ber_modif_by = 'user';
        $berita->ber_modif_date =   now();

        foreach (range(1, 3) as $index) {
            $fileKey = "ber_foto{$index}";
            if ($request->hasFile($fileKey)) {
                // Hapus file lama jika ada
                if ($berita->{$fileKey}) {
                    Storage::disk('public')->delete($berita->{$fileKey});
                }
                $berita->{$fileKey} = $request->file($fileKey)->store('berita', 'public');
            }
        }

        $berita->save();

        return redirect()->route('berita.read')->with('success', 'Berita berhasil diperbarui!');
    }


    public function delete($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->ber_status = 'Tidak Aktif';
        $berita->save();

        return redirect()->route('berita.read')->with('success', 'Berita berhasil dihapus');
    }

    public function search(Request $request): View
    {
        $query = $request->input('query');

        $berita = Berita::where('ber_status', 'aktif')
            ->where('ber_judul', 'like', '%' . $query . '%')
            ->get();

        return view('berita.index', compact('berita'))->with('query', $query);
    }

    public function searchRead(Request $request): View
    {
        $query = $request->input('query');

        $berita = Berita::where('ber_status', 'aktif')
            ->where('ber_judul', 'like', '%' . $query . '%')
            ->get();

        return view('berita.read', compact('berita'))->with('query', $query);
    }
}
