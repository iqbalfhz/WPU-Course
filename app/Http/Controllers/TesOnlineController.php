<?php

namespace App\Http\Controllers;

use App\Models\TesOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TesOnlineController extends Controller
{
    public function index()
    {
        $soals = TesOnline::latest()->paginate(10);
        return view('seleksi.tes-online', compact('soals'));
    }

    public function create()
    {
    $tesOnline = null;
    return view('seleksi.tes-online', compact('tesOnline'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);

        [$pertanyaan, $opsi, $jawabanBenar] = $this->buildPayload($request, $validated);

        TesOnline::create([
            'jenis'          => $validated['jenis'],
            'pertanyaan'     => $pertanyaan,
            'opsi'           => $opsi,
            'jawaban_benar'  => $jawabanBenar,
        ]);

        // Boleh diarahkan ke index agar lebih jelas terlihat
        return redirect()->route('tes-online.index')->with('success', 'Soal berhasil dibuat');
    }

    public function edit(TesOnline $tesOnline)
    {
        return view('seleksi.tes-online', compact('tesOnline'));
    }

    public function update(Request $request, TesOnline $tesOnline)
    {
        // Validasi sama seperti store
        $validated = $this->validatePayload($request);

        // Build payload. Untuk update: jika tidak ada file baru, pertahankan path lama.
        [$pertanyaan, $opsi, $jawabanBenar] = $this->buildPayload($request, $validated, $tesOnline);

        $tesOnline->update([
            'jenis'          => $validated['jenis'],
            'pertanyaan'     => $pertanyaan,
            'opsi'           => $opsi,
            'jawaban_benar'  => $jawabanBenar,
        ]);

        return redirect()->route('tes-online.index')->with('success', 'Soal berhasil diupdate.');
    }

    public function destroy(TesOnline $tesOnline)
    {
        $tesOnline->delete();
        return redirect()->route('tes-online.index')->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * -------- Helpers ----------
     */

    private function validatePayload(Request $request): array
    {
        // Validasi dasar
        $validated = $request->validate([
            'jenis'                       => ['required', Rule::in(['kompetensi_teknis','psikotes','kepribadian'])],

            'pertanyaan.type'             => ['required', Rule::in(['text','image','mixed'])],
            'pertanyaan.text'             => ['nullable','string'],
            'pertanyaan.image'            => ['nullable','url'],
            'pertanyaan.image_file'       => ['nullable','image','max:2048'],

            'opsi'                        => ['required','array','min:2'],
            'opsi.*.key'                  => ['required','string','max:3'],
            'opsi.*.type'                 => ['required', Rule::in(['text','image','mixed'])],
            'opsi.*.text'                 => ['nullable','string'],
            'opsi.*.image'                => ['nullable','url'],
            'opsi.*.image_file'           => ['nullable','image','max:2048'],

            'jawaban_benar'               => ['required','array','min:1'],
            'jawaban_benar.*'             => ['required','string'],
        ]);

        // Validasi lanjutan: minimal konten sesuai type
        // pertanyaan
        $pType = Arr::get($validated, 'pertanyaan.type');
        $pText = Arr::get($validated, 'pertanyaan.text');
        $pImg  = Arr::get($validated, 'pertanyaan.image');
        if ($pType === 'text' && !filled($pText)) {
            return back()->withErrors(['pertanyaan.text' => 'Teks pertanyaan wajib diisi untuk tipe text.'])->withInput()->throwResponse();
        }
        if ($pType === 'image' && !$request->hasFile('pertanyaan.image_file') && !filled($pImg)) {
            return back()->withErrors(['pertanyaan.image' => 'Gambar pertanyaan wajib diisi untuk tipe image.'])->withInput()->throwResponse();
        }
        if ($pType === 'mixed' && (!filled($pText) || (!$request->hasFile('pertanyaan.image_file') && !filled($pImg)))) {
            return back()->withErrors(['pertanyaan.image' => 'Tipe mixed memerlukan teks dan gambar.'])->withInput()->throwResponse();
        }

        // opsi: pastikan setiap opsi valid dan key unik
        $keys = [];
        foreach ($validated['opsi'] as $i => $o) {
            $oType = $o['type'];
            $oText = $o['text'] ?? null;
            $oImg  = $o['image'] ?? null;

            if (in_array($o['key'], $keys, true)) {
                return back()->withErrors(["opsi.$i.key" => 'Key opsi duplikat.'])->withInput()->throwResponse();
            }
            $keys[] = $o['key'];

            if ($oType === 'text' && !filled($oText)) {
                return back()->withErrors(["opsi.$i.text" => 'Teks opsi wajib diisi untuk tipe text.'])->withInput()->throwResponse();
            }
            if ($oType === 'image' && !$request->hasFile("opsi.$i.image_file") && !filled($oImg)) {
                return back()->withErrors(["opsi.$i.image" => 'Gambar opsi wajib diisi untuk tipe image.'])->withInput()->throwResponse();
            }
            if ($oType === 'mixed' && (!filled($oText) || (!$request->hasFile("opsi.$i.image_file") && !filled($oImg)))) {
                return back()->withErrors(["opsi.$i.image" => 'Tipe mixed memerlukan teks dan gambar.'])->withInput()->throwResponse();
            }
        }

        // jawaban_benar ⊆ keys opsi
        $invalid = collect($validated['jawaban_benar'])->reject(fn($k) => in_array($k, $keys, true));
        if ($invalid->isNotEmpty()) {
            return back()->withErrors(['jawaban_benar' => 'Jawaban benar harus sesuai dengan key opsi yang tersedia.'])->withInput()->throwResponse();
        }

        return $validated;
    }

    /**
     * Susun payload JSON; saat update, pertahankan path lama jika tidak ada file baru.
     *
     * @return array [$pertanyaan, $opsi, $jawabanBenar]
     */
    private function buildPayload(Request $request, array $validated, ?TesOnline $existing = null): array
    {
        // Pertanyaan
        $pertanyaan = [
            'type' => Arr::get($validated, 'pertanyaan.type'),
            'text' => Arr::get($validated, 'pertanyaan.text'),
            'image'=> Arr::get($validated, 'pertanyaan.image'),
        ];

        if ($request->hasFile('pertanyaan.image_file')) {
            $pertanyaan['image'] = $request->file('pertanyaan.image_file')->store('tes/pertanyaan', 'public');
        } elseif ($existing) {
            // Jika edit dan tidak ada input image baru maupun URL baru, pertahankan yang lama
            $newUrl = Arr::get($validated, 'pertanyaan.image');
            if (!filled($newUrl)) {
                $pertanyaan['image'] = Arr::get($existing->pertanyaan, 'image');
            }
        }

        // Opsi
        $opsi = [];
        foreach ($validated['opsi'] as $i => $o) {
            $item = [
                'key'   => $o['key'],
                'type'  => $o['type'],
                'text'  => $o['text'] ?? null,
                'image' => $o['image'] ?? null,
            ];

            if ($request->hasFile("opsi.$i.image_file")) {
                $item['image'] = $request->file("opsi.$i.image_file")->store('tes/opsi', 'public');
            } elseif ($existing) {
                // Cari opsi lama dengan key yang sama untuk pertahankan image jika tidak ada input baru
                $old = collect($existing->opsi ?? [])->firstWhere('key', $o['key']);
                if ($old && !filled($item['image'])) {
                    $item['image'] = $old['image'] ?? null;
                }
            }

            $opsi[] = $item;
        }

        // Jawaban benar
        $jawabanBenar = $validated['jawaban_benar'];

        return [$pertanyaan, $opsi, $jawabanBenar];
    }
}
