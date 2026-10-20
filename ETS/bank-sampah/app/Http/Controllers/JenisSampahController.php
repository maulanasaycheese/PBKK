<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JenisSampahController extends Controller
{
    public const KATEGORI = ['plastik', 'kertas', 'logam', 'kaca', 'organik', 'lainnya'];

    public function index(Request $request): View
    {
        $jenisSampah = JenisSampah::query()
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->query('kategori')))
            ->orderBy('kategori')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('jenis-sampah.index', [
            'jenisSampah' => $jenisSampah,
            'kategori' => self::KATEGORI,
        ]);
    }

    public function create(): View
    {
        return view('jenis-sampah.create', ['kategori' => self::KATEGORI]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validasi($request);
        $data['aktif'] = $request->boolean('aktif', true);

        JenisSampah::create($data);

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(JenisSampah $jenisSampah): View
    {
        return view('jenis-sampah.edit', [
            'jenisSampah' => $jenisSampah,
            'kategori' => self::KATEGORI,
        ]);
    }

    public function update(Request $request, JenisSampah $jenisSampah): RedirectResponse
    {
        $data = $this->validasi($request, $jenisSampah);
        $data['aktif'] = $request->boolean('aktif');

        $jenisSampah->update($data);

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroy(JenisSampah $jenisSampah): RedirectResponse
    {
        if ($jenisSampah->detailSetoran()->exists()) {
            return back()->with('error', 'Jenis sampah ini sudah dipakai di transaksi dan tidak bisa dihapus. Nonaktifkan saja.');
        }

        $jenisSampah->delete();

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil dihapus.');
    }

    private function validasi(Request $request, ?JenisSampah $jenisSampah = null): array
    {
        return $request->validate([
            'nama' => [
                'required', 'string', 'max:255',
                Rule::unique('jenis_sampah', 'nama')->ignore($jenisSampah?->id),
            ],
            'kategori'     => ['required', Rule::in(self::KATEGORI)],
            'harga_per_kg' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ]);
    }
}
