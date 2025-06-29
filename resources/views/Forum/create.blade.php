<x-app-layout>
    <x-slot name="header">
        <x-nav-link :href="route('forum.index')">
                <i class="fa-solid fa-arrow-left"></i>
        </x-nav-link>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight px-4">
            Buat Postingan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- 1. TAMBAHKAN enctype DI SINI --}}
                    <form method="POST" action="{{ route('forum.posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Judul -->
                        <div>
                            <x-input-label for="judul" value="Judul Postingan" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="mt-4">
                            <x-input-label for="kategori_id" value="Pilih Kategori" />
                            <select name="kategori_id" id="kategori_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->kategori_id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <!-- Isi Postingan -->
                        <div class="mt-4">
                            <x-input-label for="isi_post" value="Isi Postingan" />
                            <textarea id="isi_post" name="isi_post" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('isi_post') }}</textarea>
                            <x-input-error :messages="$errors->get('isi_post')" class="mt-2" />
                        </div>

                        {{-- 2. TAMBAHKAN INPUT FILE DI SINI --}}
                        <div class="mt-4">
                            <x-input-label for="image" value="Unggah Gambar (Opsional)" />
                            <input type="file" name="image" id="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <p class="mt-1 text-sm text-gray-500">Tipe file: JPG, PNG, GIF. Maks: 2MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                             <x-primary-button>Publikasikan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
