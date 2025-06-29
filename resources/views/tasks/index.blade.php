<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Tugas Saya') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Tugas Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <a href="{{ route('tasks.index', ['filter' => 'all']) }}"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition-colors
                                {{ ($currentFilter ?? 'active') == 'all' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            All
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'active']) }}"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition-colors
                                {{ ($currentFilter ?? 'active') == 'active' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            Active
                        </a>
                        <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
                        class="rounded-lg px-4 py-2 text-sm font-medium transition-colors
                                {{ ($currentFilter ?? 'active') == 'completed' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            Completed
                        </a>
                    </div>

                    {{-- <p>
                        list tugas
                    </p> --}}
                    <div class="space-y-3">
                        @forelse ($tasks as $task)
                            <x-task-item :task="$task" />
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">Selamat! Tidak ada tugas aktif saat ini.</p>
                                <a href="{{ route('tasks.create') }}" class="mt-4 inline-block text-blue-600 hover:underline">Buat Tugas Baru</a>
                            </div>
                        @endforelse
                    </div>

                     <div class="mt-6">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
