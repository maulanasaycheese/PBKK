<div class="space-y-6">
    <div>
        <x-input-label for="nama" value="Nama jenis sampah" />
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                      :value="old('nama', $jenisSampah->nama)" required autofocus />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="kategori" value="Kategori" />
        <select id="kategori" name="kategori"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @foreach ($kategori as $k)
                <option value="{{ $k }}" @selected(old('kategori', $jenisSampah->kategori) === $k)>{{ ucfirst($k) }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="harga_per_kg" value="Harga per kg (Rp)" />
        <x-text-input id="harga_per_kg" name="harga_per_kg" type="number" step="0.01" min="0" class="mt-1 block w-full"
                      :value="old('harga_per_kg', $jenisSampah->harga_per_kg)" required />
        <x-input-error :messages="$errors->get('harga_per_kg')" class="mt-2" />
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="aktif" value="0">
        <input id="aktif" name="aktif" type="checkbox" value="1"
               class="rounded border-gray-300"
               @checked(old('aktif', $jenisSampah->exists ? $jenisSampah->aktif : true))>
        <x-input-label for="aktif" value="Aktif (bisa dipilih saat setoran)" />
    </div>

    <div class="flex items-center gap-3">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('jenis-sampah.index') }}" class="text-sm text-gray-600 underline">Batal</a>
    </div>
</div>
