<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function indexJadwal(): View
    {
        // Fetch only active news and order by ber_tgl in descending order
        $jadwalKegiatan = Kegiatan::where('keg_status', 'aktif')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->get();
        return view('jadwalKegiatan.index', compact('jadwalKegiatan'));
    }

    public function readJadwal(): View
    {
        $jadwalKegiatan = Kegiatan::with('jenisKegiatan') // Mengambil relasi jenis kegiatan
            ->where('keg_status', 'aktif')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->get();

        return view('jadwalKegiatan.read', compact('jadwalKegiatan'));
    }

    public function addJadwal(): View
    {
        $jenisKegiatan = JenisKegiatan::all(); // Mengambil semua jenis kegiatan
        return view('jadwalKegiatan.add', compact('jenisKegiatan'));
    }

    public function storeJadwal(Request $request)
    {
        // Validasi form input dengan pesan kustom
        $request->validate([
            'keg_nama' => 'required|string|max:120',
            'jkg_id' => 'required|exists:bpm_msJenisKegiatan,jkg_id',
            'keg_tgl_mulai' => 'required|date',
            'keg_tgl_selesai' => 'required|date|after_or_equal:keg_tgl_mulai', // Tanggal selesai harus sama atau setelah tanggal mulai
            'keg_jam_mulai' => 'required|date_format:H:i',
            'keg_jam_selesai' => 'required|date_format:H:i',
            'keg_tempat' => 'required|string|max:100',
            'keg_deskripsi' => 'nullable|string',
        ], [
            'keg_tgl_selesai.after_or_equal' => 'Tanggal selesai kegiatan harus sesudah tanggal mulai', // Pesan kustom
            'keg_jam_selesai.after' => 'Jam selesai kegiatan harus lebih besar dari jam mulai kegiatan jika tanggal mulai dan tanggal selesai sama',
            // Tambahkan pesan kustom lainnya sesuai dengan kebutuhan
        ]);

        // Validasi tambahan untuk tanggal dan waktu
        if (
            $request->keg_tgl_mulai == $request->keg_tgl_selesai &&
            $request->keg_jam_mulai >= $request->keg_jam_selesai
        ) {
            return redirect()->back()->withInput()->withErrors([
                'keg_jam_selesai' => 'Jam selesai harus lebih besar dari jam mulai jika tanggal mulai dan tanggal selesai sama.',
            ]);
        }

        // Menentukan status berdasarkan tanggal mulai
        $status = (strtotime($request->keg_tgl_mulai) >= strtotime(date('Y-m-d'))) ? 'Rencana' : 'Terlewat';

        // Simpan data ke tabel kegiatan
        Kegiatan::create([
            'jkg_id' => $request->jkg_id,
            'keg_nama' => $request->keg_nama,
            'keg_deskripsi' => $request->keg_deskripsi,
            'keg_tgl_mulai' => $request->keg_tgl_mulai,
            'keg_jam_mulai' => $request->keg_jam_mulai,
            'keg_tgl_selesai' => $request->keg_tgl_selesai,
            'keg_jam_selesai' => $request->keg_jam_selesai,
            'keg_tempat' => $request->keg_tempat,
            'keg_kategori' => $status,
            'keg_status' => 'Aktif',
            'keg_created_by' => 'user', // Asumsikan user yang login sebagai pembuat
            'keg_created_date' => now(),
        ]);

        return redirect()->route('jadwalKegiatan.read')->with('success', 'Jadwal Kegiatan berhasil disimpan');
    }

    public function showJadwal($id): View
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('jadwalKegiatan.show', compact('kegiatan', 'jenisKegiatan'));
    }

    public function editJadwal($id): View
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('jadwalKegiatan.edit', compact('kegiatan', 'jenisKegiatan'));
    }

    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'keg_nama' => 'required|string|max:120',
            'jkg_id' => 'required|exists:bpm_msJenisKegiatan,jkg_id',
            'keg_tgl_mulai' => 'required|date',
            'keg_tgl_selesai' => 'required|date|after_or_equal:keg_tgl_mulai', // Tanggal selesai harus sama atau setelah tanggal mulai
            'keg_jam_mulai' => 'required|date_format:H:i',
            'keg_jam_selesai' => 'required|date_format:H:i',
            'keg_tempat' => 'required|string|max:100',
            'keg_deskripsi' => 'nullable|string',
        ], [
            'keg_tgl_selesai.after_or_equal' => 'Tanggal selesai kegiatan harus sesudah tanggal mulai', // Pesan kustom
            'keg_jam_selesai.after' => 'Jam selesai kegiatan harus lebih besar dari jam mulai kegiatan jika tanggal mulai dan tanggal selesai sama',
            // Tambahkan pesan kustom lainnya sesuai dengan kebutuhan
        ]);

        // Validasi tambahan untuk tanggal dan waktu
        if (
            $request->keg_tgl_mulai == $request->keg_tgl_selesai &&
            $request->keg_jam_mulai >= $request->keg_jam_selesai
        ) {
            return redirect()->back()->withInput()->withErrors([
                'keg_jam_selesai' => 'Jam selesai harus lebih besar dari jam mulai jika tanggal mulai dan tanggal selesai sama.',
            ]);
        }

        // Menentukan status berdasarkan tanggal mulai
        $status = (strtotime($request->keg_tgl_mulai) >= strtotime(date('Y-m-d'))) ? 'Rencana' : 'Terlewat';


        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'jkg_id' => $request->jkg_id,
            'keg_nama' => $request->keg_nama,
            'keg_deskripsi' => $request->keg_deskripsi,
            'keg_tgl_mulai' => $request->keg_tgl_mulai,
            'keg_jam_mulai' => $request->keg_jam_mulai,
            'keg_tgl_selesai' => $request->keg_tgl_selesai,
            'keg_jam_selesai' => $request->keg_jam_selesai,
            'keg_tempat' => $request->keg_tempat,
            'keg_kategori' => $status,
            'keg_modif_by' => 'user',
            'keg_modif_date' => now(),

        ]);

        return redirect()->route('jadwalKegiatan.read')->with('success', 'Jadwal Kegiatan berhasil diperbarui');
    }

    public function deleteJadwal($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->keg_status = 'Tidak Aktif';
        $kegiatan->save();

        return redirect()->route('jadwalKegiatan.read')->with('success', 'Jadwal Kegiatan berhasil dihapus');
    }

    public function searchJadwal(Request $request): View
    {
        $query = $request->input('query');

        $jadwalKegiatan = Kegiatan::where('keg_status', 'Aktif')
            ->where('keg_nama', 'like', '%' . $query . '%')
            ->get();

        return view('jadwalKegiatan.read', compact('jadwalKegiatan'))->with('query', $query);
    }
}
