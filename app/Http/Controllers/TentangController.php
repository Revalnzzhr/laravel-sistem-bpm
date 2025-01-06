<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tentang;


use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class TentangController extends Controller
{
    public function index(): View
    {
        $tentangs = Tentang::all();
        return view('tentang.index', compact('tentangs'));
    }

    public function read(): View
    {
        $tentangs = Tentang::all();
        return view('tentang.read', compact('tentangs'));
    }


    public function show($id)
    {
        $tentang = Tentang::findOrFail($id);
        return view('tentang.show', compact('tentang'));
    }

    public function edit($id)
    {
        $tentang = Tentang::findOrFail($id);
        return view('tentang.edit', compact('tentang'));
    }

    public function update(Request $request, $id)
    {
        $tentang = Tentang::findOrFail($id);

        // Validation rules based on the type of 'ten_isi' content
        $rules = [
            'ten_category' => 'required|string|max:255',
        ];

        // Add validation for file inputs
        if ($tentang->id == 7) { // Image file
            $rules['ten_isi'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($tentang->id == 8) { // Document file (PDF, DOCX, etc.)
            $rules['ten_isi'] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120';
        } else { // Text content
            $rules['ten_isi'] = 'required|string';
        }

        // Validate the request
        $request->validate($rules);

        // Handle file upload if exists
        if ($request->hasFile('ten_isi')) {
            $file = $request->file('ten_isi');
            $filename = time() . '-' . $file->getClientOriginalName();

            // Handle image file upload for 'ten_isi' if category ID is 7
            if ($tentang->id == 7) {
                $file->storeAs('public/tentang', $filename);
                $tentang->ten_isi = $filename;
            }
            // Handle document file upload for 'ten_isi' if category ID is 8
            elseif ($tentang->id == 8) {
                $file->storeAs('public/tentang', $filename);
                $tentang->ten_isi = $filename;
            }
        } else {
            // Jika tidak ada file, pastikan nilai 'ten_isi' tetap terupdate (untuk konten teks)
            if ($tentang->id != 7 && $tentang->id != 8) {
                $tentang->ten_isi = $request->ten_isi;
            }
        }

        // Update other fields
        $tentang->update([
            'ten_category' => $request->ten_category,
            'ten_modif_by' => 'user',
            'ten_modif_date' => now(),
        ]);

        return redirect()->route('tentang.read')->with('success', 'Data berhasil diperbarui');
    }
}
