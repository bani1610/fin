<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PATCH') {{-- Atau PUT --}}

                        <div>
                            <x-input-label for="judul_tugas" :value="__('Judul Tugas')" />
                            <x-text-input id="judul_tugas" class="block mt-1 w-full" type="text" name="judul_tugas" :value="old('judul_tugas', $task->judul_tugas)" required autofocus />
                            <x-input-error :messages="$errors->get('judul_tugas')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="prioritas" :value="__('Prioritas')" />
                            <select name="prioritas" id="prioritas" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="rendah" @selected(old('prioritas', $task->prioritas) == 'rendah')>Rendah</option>
                                <option value="sedang" @selected(old('prioritas', $task->prioritas) == 'sedang')>Sedang</option>
                                <option value="tinggi" @selected(old('prioritas', $task->prioritas) == 'tinggi')>Tinggi</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                             <label class="inline-flex items-center">
                                <input type="checkbox" name="is_completed" value="1" @checked(old('is_completed', $task->is_completed)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Selesai</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
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
