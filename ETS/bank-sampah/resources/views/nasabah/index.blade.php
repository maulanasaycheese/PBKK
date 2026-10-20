<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Data Nasabah</h2>
            <a href="{{ route('nasabah.create') }}"
               class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                + Tambah Nasabah
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash />

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" class="mb-4 flex flex-wrap gap-2">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode..."
                               class="w-64 rounded-md border-gray-300 text-sm shadow-sm">
                        <select name="status"
                                class="rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua status</option>
                            <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                        </select>
                        <x-secondary-button type="submit">Cari</x-secondary-button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left">
                                    <th class="py-2 pr-4">Kode</th>
                                    <th class="py-2 pr-4">Nama</th>
                                    <th class="py-2 pr-4">No. HP</th>
                                    <th class="py-2 pr-4 text-right">Saldo</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nasabah as $n)
                                    @php
                                        $saldo = ($n->setoran_sum_total_nilai ?? 0) - ($n->penarikan_sum_nominal ?? 0);
                                    @endphp
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $n->kode_nasabah }}</td>
                                        <td class="py-2 pr-4">{{ $n->nama }}</td>
                                        <td class="py-2 pr-4">{{ $n->no_hp ?? '-' }}</td>
                                        <td class="py-2 pr-4 text-right">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="rounded px-2 py-0.5 text-xs {{ $n->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                                {{ ucfirst($n->status) }}
                                            </span>
                                        </td>
                                        <td class="py-2 text-right whitespace-nowrap">
                                            <a href="{{ route('nasabah.show', $n) }}" class="text-blue-600 hover:underline">Detail</a>
                                            <a href="{{ route('nasabah.edit', $n) }}" class="ml-3 text-amber-600 hover:underline">Ubah</a>
                                            <form method="POST" action="{{ route('nasabah.destroy', $n) }}" class="ml-3 inline"
                                                  onsubmit="return confirm('Hapus nasabah {{ $n->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">Belum ada data nasabah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $nasabah->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
