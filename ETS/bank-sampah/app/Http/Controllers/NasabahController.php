<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NasabahController extends Controller
{
    public function index(Request $request): View
    {
        $nasabah = Nasabah::query()
            ->withSum('setoran', 'total_nilai')
            ->withSum('penarikan', 'nominal')
            ->cari($request->query('q'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->query('status')))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('nasabah.index', compact('nasabah'));
    }

    public function create(): View
    {
        return view('nasabah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama'   => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_hp'  => ['nullable', 'string', 'max:20'],
        ]);

        $data['kode_nasabah'] = $this->buatKode();
        $data['status'] = 'aktif';

        Nasabah::create($data);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah): View
    {
        $setoran = $nasabah->setoran()->latest('tanggal')->latest('id')->limit(10)->get();
        $penarikan = $nasabah->penarikan()->latest('tanggal')->latest('id')->limit(10)->get();

        return view('nasabah.show', compact('nasabah', 'setoran', 'penarikan'));
    }

    public function edit(Nasabah $nasabah): View
    {
        return view('nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah): RedirectResponse
    {
        $data = $request->validate([
            'nama'   => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_hp'  => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $nasabah->update($data);

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah): RedirectResponse
    {
        if ($nasabah->setoran()->exists() || $nasabah->penarikan()->exists()) {
            return back()->with('error', 'Nasabah sudah memiliki riwayat transaksi dan tidak bisa dihapus. Ubah statusnya menjadi nonaktif.');
        }

        $nasabah->delete();

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dihapus.');
    }

    private function buatKode(): string
    {
        $berikutnya = (Nasabah::max('id') ?? 0) + 1;

        return 'NSB-' . str_pad((string) $berikutnya, 4, '0', STR_PAD_LEFT);
    }
}
