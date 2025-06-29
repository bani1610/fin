<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- User Stat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-bold">{{ $stats['users'] }}</h3>
                    <p class="text-gray-500">Total Pengguna</p>
                </div>
                <!-- Post Stat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-bold">{{ $stats['posts'] }}</h3>
                    <p class="text-gray-500">Total Postingan</p>
                </div>
                <!-- Task Stat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-bold">{{ $stats['tasks'] }}</h3>
                    <p class="text-gray-500">Total Tugas</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
