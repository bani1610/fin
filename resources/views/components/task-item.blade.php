@props(['task'])



<div class="grid grid-cols-12 items-center gap-4 rounded-lg p-3 hover:bg-gray-50 transition-all duration-200 border border-transparent hover:border-gray-200">

    {{-- Kolom 1: Checkbox, Judul, dan Deskripsi --}}
    <div class="col-span-12 md:col-span-4 flex items-center gap-4">
        {{-- Checkbox --}}
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="flex-shrink-0">
            @csrf
            @method('PATCH')
            <input type="hidden" name="toggle_complete" value="1">
            <input
                type="checkbox"
                onchange="this.form.submit()"
                @if($task->status === 'done') checked @endif
                class="form-checkbox size-5 flex-shrink-0 rounded-full border-2 border-gray-300 text-primary checked:border-primary checked:bg-primary checked:bg-checkbox-tick focus:ring-0 focus:ring-offset-0 transition"
            />
        </form>
        {{-- Judul & Deskripsi --}}
        <div>
            <p class="font-semibold {{ $task->status === 'done' ? 'text-gray-400 line-through' : 'text-gray-800' }}">
                {{ $task->judul_tugas }}
            </p>
            <p class="text-sm text-gray-500">{{ Str::limit($task->deskripsi, 60) }}</p>
        </div>
    </div>

    {{-- Kolom 2: Status --}}
    <div class="col-span-4 md:col-span-2">
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium capitalize
            {{ $task->status === 'done' ? 'bg-green-100 text-green-800' :
               ($task->status === 'inprogress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
            {{ $task->status }}
        </span>
    </div>

    {{-- Kolom 3: Deadline --}}
    <div class="col-span-4 md:col-span-2 text-sm text-gray-600">
        @if($task->deadline)
            {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
        @else
            -
        @endif
    </div>

    {{-- Kolom 4: Prioritas --}}
    <div class="col-span-4 md:col-span-2">
        @php
            $priorityClasses = [
                'tinggi' => 'bg-red-100 text-red-800',
                'sedang' => 'bg-orange-100 text-orange-800',
                'rendah' => 'bg-sky-100 text-sky-800',
            ];
            $priorityClass = $priorityClasses[$task->prioritas ?? 'rendah'];
        @endphp
        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold {{ $priorityClass }}">
            {{ ucfirst($task->prioritas ?? 'rendah') }}
        </span>
    </div>

    {{-- Kolom 5: Beban Kognitif (BARU) --}}
    <div class="col-span-4 md:col-span-1 text-sm text-gray-600 capitalize">
        {{ $task->beban_kognitif }}
    </div>

    {{-- Kolom 6: Tombol Aksi --}}
    <div class="col-span-8 md:col-span-1 flex justify-end items-center gap-1">
        <a href="{{ route('tasks.edit', $task) }}" aria-label="Edit task" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-200 hover:text-blue-600 transition">
            <span class="material-icons" style="font-size: 20px;">edit</span>
        </a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Delete task" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-200 hover:text-red-600 transition">
                <span class="material-icons" style="font-size: 20px;">delete</span>
            </button>
        </form>
    </div>
</div>