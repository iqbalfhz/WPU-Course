<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidats = Kandidat::latest()->paginate(10);
        return view('seleksi.kandidat', compact('kandidats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seleksi.input-manual');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'usia' => 'required|integer|min:17|max:70',
            'email' => 'required|email|max:255',
            'nilai_akademik' => 'nullable|numeric|min:0|max:100',
            'tes_kompetensi_teknis' => 'nullable|numeric|min:0|max:100',
            'tes_psikotes' => 'nullable|numeric|min:0|max:100',
            'tes_kepribadian' => 'nullable|numeric|min:0|max:100',
            'soft_skill' => 'nullable|numeric|min:0|max:100',
        ]);
        Kandidat::create($validated);
        return redirect()->route('kandidat.index')->with('success', 'Kandidat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kandidat $kandidat)
    {
        return view('seleksi.kandidat-show', compact('kandidat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kandidat $kandidat)
    {
        return view('seleksi.input-manual', compact('kandidat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kandidat $kandidat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'usia' => 'required|integer|min:17|max:70',
            'email' => 'required|email|max:255',
            'nilai_akademik' => 'nullable|numeric|min:0|max:100',
            'tes_kompetensi_teknis' => 'nullable|numeric|min:0|max:100',
            'tes_psikotes' => 'nullable|numeric|min:0|max:100',
            'tes_kepribadian' => 'nullable|numeric|min:0|max:100',
            'soft_skill' => 'nullable|numeric|min:0|max:100',
        ]);
        $kandidat->update($validated);
        return redirect()->route('kandidat.index')->with('success', 'Kandidat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kandidat $kandidat)
    {
        $kandidat->delete();
        return redirect()->route('kandidat.index')->with('success', 'Kandidat berhasil dihapus.');
    }
}
