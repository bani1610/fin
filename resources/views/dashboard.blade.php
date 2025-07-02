<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto py-12 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Halo, {{ Auth::user()->name }}!</h3>

                    @if($moodToday)
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
                            <p class="font-bold">Mood kamu hari ini: <span class="capitalize">{{ $moodToday->mood }}</span></p>
                            <p>Kamu sudah check-in untuk hari ini. Tetap semangat!</p>
                        </div>
                    @else
                        <div class="p-6 border rounded-xl bg-slate-50">
                            <h4 class="text-lg font-semibold mb-4">Bagaimana perasaanmu hari ini?</h4>
                            <form action="{{ route('moods.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-7 gap-4 mb-4">
                                    @php
                                        $moods = ['senang' => '😄', 'semangat' => '😊', 'biasa' => '😐', 'ragu' => '🤔', 'lelah' => '😫', 'stres' => '😠', 'sedih' => '😥'];
                                    @endphp
                                    @foreach ($moods as $mood => $emoji)
                                        <label class="cursor-pointer text-center group">
                                            <input type="radio" name="mood" value="{{ $mood }}" class="sr-only peer" required>
                                            <div class="p-3 border-2 bg-white rounded-lg group-hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-md transition-all duration-200">
                                                <span class="text-4xl">{{ $emoji }}</span>
                                                <p class="text-sm capitalize mt-1 font-medium">{{ $mood }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('mood')<p class="text-red-500 text-sm mb-2 -mt-2">{{ $message }}</p>@enderror

                                <div>
                                    <label for="catatan" class="block font-medium text-sm text-gray-700">Ada apa? (Opsional)</label>
                                    <textarea name="catatan" id="catatan" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                </div>

                                <div class="mt-4">
                                    <x-primary-button>Simpan Mood</x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <hr class="my-8 border-gray-200">

                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Rekomendasi Tugas Untukmu Hari Ini
                        </h4>

                        <div class="space-y-3">
                             @forelse ($recommendedTasks as $task)
                                <a href="{{ route('tasks.show', $task) }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition duration-200">
                                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $task->judul_tugas }}</p>
                                            <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
                                        </div>
                                        @php
                                            $bebanClass = [
                                                'berat'  => 'bg-red-100 text-red-800',
                                                'sedang' => 'bg-orange-100 text-orange-800',
                                                'ringan' => 'bg-green-100 text-green-800',
                                            ][$task->beban_kognitif] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="mt-2 sm:mt-0 text-xs font-semibold uppercase px-2 py-1 rounded-full {{ $bebanClass }}">
                                            {{ $task->beban_kognitif }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="bg-sky-50 text-sky-800 text-center p-6 rounded-lg border border-sky-200">
                                    <p class="font-semibold">Tidak ada tugas yang cocok dengan mood-mu saat ini.</p>
                                    <p class="mt-1 text-sm">Ini kesempatan bagus untuk melakukan sesuatu yang menyenangkan untuk menaikkan semangatmu! ✨</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold group">
                        <span>Lihat Semua Tugas</span>
                        <span class="ml-1 transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
