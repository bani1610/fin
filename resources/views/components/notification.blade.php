@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        {{-- Kelas animasi diubah agar transisi dari atas --}}
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-12"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-12"

        {{-- Kelas posisi diubah ke tengah atas --}}
        class="fixed top-5 left-1/2 -translate-x-1/2 z-50 bg-green-500 text-white py-3 px-5 rounded-lg shadow-lg flex items-center"

        role="alert"
    >
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p>{{ session('success') }}</p>
        <button @click="show = false" class="ml-4 text-green-100 hover:text-white">&times;</button>
    </div>
@endif
