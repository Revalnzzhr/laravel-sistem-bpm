<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Validator;
use Illuminate\Support\Facades\Cookie;


class KegiatanController extends Controller
{
    public function indexJadwal(): View
    {
        
        $jadwalKegiatan = Kegiatan::where('keg_status', 'aktif')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->get();
        return view('jadwalKegiatan.index', compact('jadwalKegiatan'));
    }

    public function readJadwal(): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $jadwalKegiatan = Kegiatan::with('jenisKegiatan') 
            ->where('keg_status', 'aktif')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->paginate(5);

        return view('jadwalKegiatan.read', compact('jadwalKegiatan'));
    }

    public function addJadwal(): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $jenisKegiatan = JenisKegiatan::all(); // Mengambil semua jenis kegiatan
        return view('jadwalKegiatan.add', compact('jenisKegiatan'));
    }

    public function storeJadwal(Request $request)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

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
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('jadwalKegiatan.show', compact('kegiatan', 'jenisKegiatan'));
    }

    public function editJadwal($id): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('jadwalKegiatan.edit', compact('kegiatan', 'jenisKegiatan'));
    }

    public function updateJadwal(Request $request, $id)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $request->validate([
            'keg_nama' => 'required|string|max:120',
            'jkg_id' => 'required|exists:bpm_msJenisKegiatan,jkg_id',
            'keg_tgl_mulai' => 'required|date',
            'keg_tgl_selesai' => 'required|date|after_or_equal:keg_tgl_mulai',
            'keg_jam_mulai' => 'required|date_format:H:i',
            'keg_jam_selesai' => 'required|date_format:H:i',
            'keg_tempat' => 'required|string|max:100',
            'keg_deskripsi' => 'nullable|string',
        ], [
            'keg_tgl_selesai.after_or_equal' => 'Tanggal selesai kegiatan harus sesudah tanggal mulai', // Pesan kustom
            'keg_jam_selesai.after' => 'Jam selesai kegiatan harus lebih besar dari jam mulai kegiatan jika tanggal mulai dan tanggal selesai sama',
            
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
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->keg_status = 'Tidak Aktif';
        $kegiatan->save();

        return redirect()->route('jadwalKegiatan.read')->with('success', 'Jadwal Kegiatan berhasil dihapus');
    }

    public function searchJadwal(Request $request): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $query = $request->input('query');

        $jadwalKegiatan = Kegiatan::where('keg_status', 'Aktif')
            ->where('keg_nama', 'like', '%' . $query . '%')
            ->get();

        return view('jadwalKegiatan.read', compact('jadwalKegiatan'))->with('query', $query);
    }



    // DOKUMENTASI KEGIATAN
    public function indexDokum(): View
    {
      

        // Fetch only active news and order by ber_tgl in descending order
        $kegiatan = Kegiatan::where('keg_status', 'aktif')
            ->where('keg_kategori', 'Terlaksana')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->get();
        $jenisKegiatan = JenisKegiatan::all();
        return view('dokumentasiKegiatan.index', compact('kegiatan', 'jenisKegiatan'));
    }

    public function readDokum(): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        // Fetch only active news and order by keg_tgl_selesai in descending order
        $kegiatan = Kegiatan::where('keg_status', 'aktif')
            ->where('keg_kategori', 'Terlaksana')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->paginate(5);
        return view('dokumentasiKegiatan.read', compact('kegiatan'));
    }

    public function addDokum()
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::where('keg_status', 'aktif')
            ->where('keg_kategori', 'Terlewat')
            ->orderBy('keg_tgl_selesai', 'DESC')
            ->get();

        if ($kegiatan->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada Kegiatan yang terlewat');
        }

        $jenisKegiatan = JenisKegiatan::all();
        return view('dokumentasiKegiatan.add', compact('kegiatan', 'jenisKegiatan'));
    }

    

    public function getKegiatanDetails($id)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::with('jenisKegiatan')->find($id);

        if (!$kegiatan) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json([
            'keg_tgl_mulai' => $kegiatan->keg_tgl_mulai,
            'keg_jam_mulai' => $kegiatan->keg_jam_mulai,
            'keg_tempat' => $kegiatan->keg_tempat,
            'keg_tgl_selesai' => $kegiatan->keg_tgl_selesai,
            'keg_jam_selesai' => $kegiatan->keg_jam_selesai,
            'keg_deskripsi' => $kegiatan->keg_deskripsi,
            'jkg_id' => $kegiatan->jkg_id,
            'jkg_nama' => $kegiatan->jenisKegiatan->jkg_nama ?? '', // Pastikan nama kolom benar
        ]);
    }

    public function storeDokum(Request $request, $keg_id)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        // Validasi data input langsung dengan validate
        $request->validate([
            'keg_link_folder' => 'required|string|max:255',
            'keg_dok_notulen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx',
            'keg_status_dok_notulen' => 'required|in:Privat,Publik',
            'keg_foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Cari kegiatan berdasarkan keg_id
        $kegiatan = Kegiatan::find($keg_id);
        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan');
        }
    
        // Update field yang tidak readonly
        $kegiatan->keg_link_folder = $request->input('keg_link_folder');
        $kegiatan->keg_status_dok_notulen = $request->input('keg_status_dok_notulen');
    
        // Simpan dokumen notulen jika ada file diunggah
        if ($request->hasFile('keg_dok_notulen')) {
            $file = $request->file('keg_dok_notulen');
            $filePath = $file->store('kegiatan', 'public'); // Simpan di folder public/dok_notulen
            $kegiatan->keg_dok_notulen = $filePath;
        }
    
        // Simpan foto sampul jika ada file diunggah
        if ($request->hasFile('keg_foto_sampul')) {
            $foto = $request->file('keg_foto_sampul');
            $fotoPath = $foto->store('kegiatan', 'public'); // Simpan di folder public/foto_sampul
            $kegiatan->keg_foto_sampul = $fotoPath;
        }
    
        // Update kolom yang mencatat waktu dan pengguna modifikasi
        $kegiatan->keg_modif_by = 'User';
        $kegiatan->keg_modif_date = now();
        $kegiatan->keg_kategori = 'Terlaksana';
    
        // Simpan perubahan
        $kegiatan->save();
    
        return redirect()->route('dokumentasiKegiatan.read')->with('success', 'Dokumentasi kegiatan berhasil diperbarui');
    }
    
    public function editDokum($id): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('dokumentasiKegiatan.edit', compact('kegiatan', 'jenisKegiatan'));
    }

    public function updateDokum(Request $request, $keg_id)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }
    
        // Validasi data input
        $request->validate([
            'keg_nama' => 'required|string|max:120',
            'jkg_id' => 'required|exists:bpm_msJenisKegiatan,jkg_id',
            'keg_tgl_mulai' => 'required|date',
            'keg_tgl_selesai' => 'required|date|after_or_equal:keg_tgl_mulai', // Tanggal selesai harus sama atau setelah tanggal mulai
            'keg_jam_mulai' => 'required|date_format:H:i',
            'keg_jam_selesai' => 'required|date_format:H:i|after:keg_jam_mulai', // Jam selesai harus lebih besar dari jam mulai jika tanggal sama
            'keg_tempat' => 'required|string|max:100',
            'keg_deskripsi' => 'nullable|string',
            'keg_link_folder' => 'required|string|max:255',
            'keg_dok_notulen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'keg_status_dok_notulen' => 'required|in:Privat,Publik',
            'keg_foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'keg_tgl_selesai.after_or_equal' => 'Tanggal selesai kegiatan harus sesudah tanggal mulai', // Pesan kustom
            'keg_jam_selesai.after' => 'Jam selesai kegiatan harus lebih besar dari jam mulai kegiatan jika tanggal mulai dan tanggal selesai sama',
        ]);
    
        // Cari kegiatan berdasarkan keg_id
        $kegiatan = Kegiatan::find($keg_id);
        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan');
        }
    
        // Update data berdasarkan input
        $kegiatan->keg_link_folder = $request->input('keg_link_folder');
        $kegiatan->keg_status_dok_notulen = $request->input('keg_status_dok_notulen');
    
        // Jika ada file dokumen notulen yang diunggah
        if ($request->hasFile('keg_dok_notulen')) {
            // Hapus file lama jika ada
            if ($kegiatan->keg_dok_notulen) {
                Storage::disk('public')->delete($kegiatan->keg_dok_notulen);
            }
            $file = $request->file('keg_dok_notulen');
            $filePath = $file->store('kegiatan', 'public');
            $kegiatan->keg_dok_notulen = $filePath;
        }
    
        // Jika ada file foto sampul yang diunggah
        if ($request->hasFile('keg_foto_sampul')) {
            // Hapus file lama jika ada
            if ($kegiatan->keg_foto_sampul) {
                Storage::disk('public')->delete($kegiatan->keg_foto_sampul);
            }
            $foto = $request->file('keg_foto_sampul');
            $fotoPath = $foto->store('kegiatan', 'public');
            $kegiatan->keg_foto_sampul = $fotoPath;
        }
    
        // Update metadata
        $kegiatan->keg_modif_by = auth()->user()->name ?? 'System';
        $kegiatan->keg_modif_date = now();
        $kegiatan->keg_kategori = 'Terlaksana';
        
        // Update data kegiatan
        $kegiatan->update([
            'jkg_id' => $request->jkg_id,
            'keg_nama' => $request->keg_nama,
            'keg_deskripsi' => $request->keg_deskripsi,
            'keg_tgl_mulai' => $request->keg_tgl_mulai,
            'keg_jam_mulai' => $request->keg_jam_mulai,
            'keg_tgl_selesai' => $request->keg_tgl_selesai,
            'keg_jam_selesai' => $request->keg_jam_selesai,
            'keg_tempat' => $request->keg_tempat,
    
        ]);
    
        // Simpan perubahan
        return redirect()->route('dokumentasiKegiatan.read')->with('success', 'Dokumentasi kegiatan berhasil diperbarui');
    }
    

    public function showDokum($id): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $jenisKegiatan = JenisKegiatan::all();
        return view('dokumentasiKegiatan.show', compact('kegiatan', 'jenisKegiatan'));
    }

    public function deleteDokum($id)
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->keg_status = 'Tidak Aktif';
        $kegiatan->save();

        return redirect()->route('dokumentasiKegiatan.read')->with('success', 'Jadwal Kegiatan berhasil dihapus');
    }

    public function searchDokum(Request $request): View
    {
        if (!Cookie::has('username')) {
            return view('login.index');
        }

        $query = $request->input('query');

        $kegiatan = Kegiatan::where('keg_status', 'Aktif')
            ->where('keg_kategori', 'Terlaksana')
            ->where('keg_nama', 'like', '%' . $query . '%')
            ->get();

        return view('dokumentasiKegiatan.read', compact('kegiatan'))->with('query', $query);

    }


}
