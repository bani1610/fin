<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pageTitle ?? 'Forum Feed' }}
        </h2>
    </x-slot>
    <div x-data="{ isCreatePostModalOpen: false }" class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="flex px-2 py-3 justify-end mb-6">
                {{-- Kita ubah dari <a> menjadi <button> dan tambahkan @click --}}
                <button @click="isCreatePostModalOpen = true" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-11 px-5 bg-primary text-white text-sm font-semibold leading-normal tracking-wide shadow-md hover:bg-opacity-90 transition-all duration-200">
                    <svg class="mr-2" fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
                    </svg>
                    <span class="truncate">Create Post</span>
                </button>
            </div>

            {{-- Feed Postingan (tidak berubah) --}}
            <div class="space-y-8">
                @forelse ($posts as $post)
                    <div class="mb-6 py-4">
                        <x-forum.post-card :post="$post" />
                    </div>
                @empty
                    <div class="feed-card">
                        <div class="p-8 text-center text-gray-500">
                            <p>Belum ada postingan di sini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Link Paginasi (tidak berubah) --}}
            <div class="mt-8">
                {{ $posts->links() }}
            </div>

        </div>

        {{-- PANGGIL KOMPONEN MODAL DI SINI --}}
        <x-forum.create-post-modal :categories="$categories" />
    </div> {{-- Akhir dari div x-data --}}
</x-app-layout>
