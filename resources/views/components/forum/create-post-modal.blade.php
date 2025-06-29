
<div
    x-show="isCreatePostModalOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="isCreatePostModalOpen = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div @click="isCreatePostModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div
            @click.outside="isCreatePostModalOpen = false"
            x-show="isCreatePostModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white rounded-xl shadow-2xl w-full max-w-lg"
        >
            {{-- Form di dalam modal --}}
            <form action="{{ route('forum.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-6">
                    <h2 class="text-xl font-semibold text-text-primary" id="modal-title">Buat Postingan Baru</h2>

                    {{-- Judul --}}
                    <div>
                        <x-input-label for="judul" value="Judul" class="sr-only"/>
                        <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" placeholder="Judul Postingan..." :value="old('judul')" required />
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    {{-- Isi Post --}}
                    <textarea name="isi_post" class="w-full h-32 p-3 border border-border-color rounded-lg resize-none focus:ring-2 focus:ring-primary focus:border-transparent text-text-primary" placeholder="Bagikan pemikiran atau pengalamanmu...">{{ old('isi_post') }}</textarea>
                    <x-input-error :messages="$errors->get('isi_post')" class="mt-2" />

                    <div>
                        <x-input-label for="kategori_id" value="Pilih Kategori" />
                        <select name="kategori_id" id="kategori_id" class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm">
                            <option value="" disabled selected>-- Pilih sebuah kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->kategori_id }}" {{ old('kategori_id') == $category->kategori_id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                    </div>

                    {{-- Aksi Upload --}}
                    <div x-data="{ photoName: null }" class="flex items-center space-x-4">
                        <label class="flex items-center px-4 py-2 border border-border-color rounded-lg text-text-secondary hover:bg-slate-50 transition-colors cursor-pointer">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <span>Upload Foto</span>
                            <input type="file" name="image" class="hidden" @change="photoName = $event.target.files[0].name">
                        </label>
                        {{-- Menampilkan nama file yang dipilih --}}
                        <p x-text="photoName" class="text-xs text-gray-500"></p>
                    </div>
                     <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                {{-- Tombol Aksi Form --}}
                <div class="flex justify-end space-x-3 pt-4 p-6 bg-slate-50 rounded-b-xl">
                    <button @click="isCreatePostModalOpen = false" type="button" class="px-5 py-2.5 rounded-lg text-text-secondary hover:bg-slate-200 transition-colors text-sm font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-primary text-white hover:bg-opacity-90 transition-colors text-sm font-semibold shadow-md">Post</button>
                </div>
            </form>
            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
        </div>
    </div>
</div>
