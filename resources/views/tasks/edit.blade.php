<x-app-layout>
    <x-slot name="header">
        <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks')">
            <i class="fa-solid fa-arrow-left"></i>
        </x-nav-link>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight px-4">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto py-12 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 py-12 px-4">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PATCH') {{-- Atau PUT --}}

                        <!-- Judul Tugas -->
                        <div>
                            <x-input-label for="judul_tugas" :value="__('Judul Tugas')" />
                            <x-text-input id="judul_tugas" class="block mt-1 w-full" type="text" name="judul_tugas" :value="old('judul_tugas', $task->judul_tugas)" required autofocus />
                            <x-input-error :messages="$errors->get('judul_tugas')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="deskripsi" name="deskripsi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $task->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <!-- Deadline -->
                        <div class="mt-4">
                            <x-input-label for="deadline" :value="__('Deadline')" />
                            <x-text-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline', $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                            <!-- Prioritas -->
                            <div>
                                <x-input-label for="prioritas" :value="__('Prioritas')" />
                                <select name="prioritas" id="prioritas" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="rendah" @selected(old('prioritas', $task->prioritas) == 'rendah')>Rendah</option>
                                    <option value="sedang" @selected(old('prioritas', $task->prioritas) == 'sedang')>Sedang</option>
                                    <option value="tinggi" @selected(old('prioritas', $task->prioritas) == 'tinggi')>Tinggi</option>
                                </select>
                                <x-input-error :messages="$errors->get('prioritas')" class="mt-2" />
                            </div>

                            <!-- Beban Kognitif -->
                            <div>
                                <x-input-label for="beban_kognitif" :value="__('Beban Kognitif')" />
                                <select name="beban_kognitif" id="beban_kognitif" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="ringan" @selected(old('beban_kognitif', $task->beban_kognitif) == 'ringan')>Ringan</option>
                                    <option value="sedang" @selected(old('beban_kognitif', $task->beban_kognitif) == 'sedang')>Sedang</option>
                                    <option value="berat" @selected(old('beban_kognitif', $task->beban_kognitif) == 'berat')>Berat</option>
                                </select>
                                <x-input-error :messages="$errors->get('beban_kognitif')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="todo" @selected(old('status', $task->status) == 'todo')>To-Do</option>
                                    <option value="inprogress" @selected(old('status', $task->status) == 'inprogress')>In Progress</option>
                                    <option value="done" @selected(old('status', $task->status) == 'done')>Done</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Perbarui Tugas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
