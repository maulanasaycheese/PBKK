<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $nasabah->nama }} &middot; {{ $nasabah->kode_nasabah }}
            </h2>
            <a href="{{ route('nasabah.index') }}" class="text-sm text-gray-600 underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                <dl class="grid grid-cols-1 gap-4 text-sm text-gray-900 sm:grid-cols-4">
                    <div><dt class="text-gray-500">Saldo</dt><dd class="text-lg font-semibold">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</dd></div>
                    <div><dt class="text-gray-500">No. HP</dt><dd>{{ $nasabah->no_hp ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Status</dt><dd>{{ ucfirst($nasabah->status) }}</dd></div>
                    <div><dt class="text-gray-500">Terdaftar</dt><dd>{{ $nasabah->created_at->format('d M Y') }}</dd></div>
                    <div class="sm:col-span-4"><dt class="text-gray-500">Alamat</dt><dd>{{ $nasabah->alamat ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="mb-3 font-semibold text-gray-900">Setoran Terakhir</h3>
                    <ul class="divide-y text-sm text-gray-900">
                        @forelse ($setoran as $s)
                            <li class="flex justify-between py-2">
                                <span>{{ $s->tanggal->format('d M Y') }}</span>
                                <span>Rp {{ number_format($s->total_nilai, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-gray-500">Belum ada setoran.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="mb-3 font-semibold text-gray-900">Penarikan Terakhir</h3>
                    <ul class="divide-y text-sm text-gray-900">
                        @forelse ($penarikan as $p)
                            <li class="flex justify-between py-2">
                                <span>{{ $p->tanggal->format('d M Y') }}</span>
                                <span>Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-gray-500">Belum ada penarikan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
