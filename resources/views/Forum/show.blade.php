<x-app-layout>
    <x-slot name="header">
            <x-nav-link :href="route('forum.index')">
                <i class="fa-solid fa-arrow-left"></i>
            </x-nav-link>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight px-4">
            Forum Diskusi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Detail Postingan -->
                   <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-sm font-semibold text-blue-600">{{ $post->category->nama_kategori }}</span>
                        <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $post->judul }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Diposting oleh {{ $post->user->name }} &#8226; {{ $post->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- TOMBOL HAPUS (HANYA MUNCUL UNTUK PEMILIK POST) --}}
                    @can('delete', $post)
                        <form action="{{ route('forum.posts.destroy', $post) }}" method="POST" class="delete-form"> {{-- Hapus onsubmit, tambahkan class --}}
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    @endcan
                </div>
                <hr class="my-6 border-gray-200">
                @if ($post->image_path)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->judul }}" class="post-image">
                    </div>
                @endif
                <hr class="my-6 border-gray-200">

                <div class="prose max-w-none mt-6 text-gray-700">
                    {!! nl2br(e($post->isi_post)) !!}
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Komentar ({{ $post->comments->count() }})</h3>
                <div class="space-y-4">
                    @forelse($post->comments as $comment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-text-primary">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $comment->isi_komentar }}</p>
                        </div>
                    @empty
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 text-center">
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Tinggalkan Komentar</h3>
                @auth
                    <form action="{{ route('forum.comments.store', $post) }}" method="POST">
                        @csrf
                        <textarea name="isi_komentar" rows="4" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tulis komentar Anda di sini...">{{ old('isi_komentar') }}</textarea>
                        <x-input-error :messages="$errors->get('isi_komentar')" class="mt-2" />
                        <div class="mt-4">
                            <x-primary-button>Kirim Komentar</x-primary-button>
                        </div>
                    </form>
                @else
                    <p class="text-gray-600">
                        Silakan <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> untuk meninggalkan komentar.
                    </p>
                @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
