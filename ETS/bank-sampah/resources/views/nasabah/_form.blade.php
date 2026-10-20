<div class="space-y-6">
    <div>
        <x-input-label for="nama" value="Nama" />
        <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                      :value="old('nama', $nasabah->nama)" required autofocus />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="alamat" value="Alamat" />
        <textarea id="alamat" name="alamat" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('alamat', $nasabah->alamat) }}</textarea>
        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="no_hp" value="No. HP" />
        <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full"
                      :value="old('no_hp', $nasabah->no_hp)" />
        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
    </div>

    @if ($nasabah->exists)
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach (['aktif', 'nonaktif'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $nasabah->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    @endif

    <div class="flex items-center gap-3">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('nasabah.index') }}" class="text-sm text-gray-600 underline">Batal</a>
    </div>
</div>
