<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Ubah Jenis Sampah</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('jenis-sampah.update', $jenisSampah) }}">
                    @csrf
                    @method('PUT')
                    @include('jenis-sampah._form', ['jenisSampah' => $jenisSampah])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
