<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('tasks.index') }}" class="mr-4">
                {{-- Anda bisa menggunakan ikon panah kembali jika ada Font Awesome --}}
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Tugas Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    {{-- FORMULIR UNTUK MEMBUAT TUGAS BARU --}}
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="judul_tugas" :value="__('Judul Tugas')" />
                            <x-text-input id="judul_tugas" class="block mt-1 w-full" type="text" name="judul_tugas" :value="old('judul_tugas')" required autofocus />
                            <x-input-error :messages="$errors->get('judul_tugas')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="deskripsi" name="deskripsi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deadline" :value="__('Deadline')" />
                            <x-text-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline')" />
                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="prioritas" :value="__('Prioritas')" />
                                <select name="prioritas" id="prioritas" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('prioritas', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                                <x-input-error :messages="$errors->get('prioritas')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="beban_kognitif" :value="__('Beban Kognitif')" />
                                <select name="beban_kognitif" id="beban_kognitif" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="ringan" {{ old('beban_kognitif') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                    <option value="sedang" {{ old('beban_kognitif', 'sedang') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="berat" {{ old('beban_kognitif') == 'berat' ? 'selected' : '' }}>Berat</option>
                                </select>
                                <x-input-error :messages="$errors->get('beban_kognitif')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Tugas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
