<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Jenis Sampah &amp; Harga</h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('jenis-sampah.create') }}"
                   class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                    + Tambah Jenis
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash />

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" class="mb-4 flex gap-2">
                        <select name="kategori"
                                class="rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">Semua kategori</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ ucfirst($k) }}</option>
                            @endforeach
                        </select>
                        <x-secondary-button type="submit">Filter</x-secondary-button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b text-left">
                                    <th class="py-2 pr-4">Nama</th>
                                    <th class="py-2 pr-4">Kategori</th>
                                    <th class="py-2 pr-4 text-right">Harga / kg</th>
                                    <th class="py-2 pr-4">Status</th>
                                    @if (auth()->user()->role === 'admin')
                                        <th class="py-2 text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jenisSampah as $j)
                                    <tr class="border-b">
                                        <td class="py-2 pr-4">{{ $j->nama }}</td>
                                        <td class="py-2 pr-4">{{ ucfirst($j->kategori) }}</td>
                                        <td class="py-2 pr-4 text-right">Rp {{ number_format($j->harga_per_kg, 0, ',', '.') }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="rounded px-2 py-0.5 text-xs {{ $j->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                                {{ $j->aktif ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        @if (auth()->user()->role === 'admin')
                                            <td class="py-2 text-right whitespace-nowrap">
                                                <a href="{{ route('jenis-sampah.edit', $j) }}" class="text-amber-600 hover:underline">Ubah</a>
                                                <form method="POST" action="{{ route('jenis-sampah.destroy', $j) }}" class="ml-3 inline"
                                                      onsubmit="return confirm('Hapus {{ $j->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500">Belum ada jenis sampah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $jenisSampah->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
