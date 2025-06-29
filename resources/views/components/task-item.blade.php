@props(['task'])

<div class="flex items-center gap-3 rounded-md p-3 hover:bg-[#f4f8f9] border border-transparent hover:border-gray-200">
    {{-- Form untuk toggle status selesai/belum --}}
    <form method="POST" action="{{ route('tasks.update', $task) }}" class="flex-shrink-0">
        @csrf
        @method('PATCH')
        <input type="hidden" name="toggle_complete" value="1">
        <input
            type="checkbox"
            name="is_completed"
            onchange="this.form.submit()"
            @if($task->is_completed) checked @endif
            class="form-checkbox size-5 flex-shrink-0 rounded-full border-2 border-[#cde4ea] text-primary checked:border-primary checked:bg-primary checked:bg-checkbox-tick focus:ring-0 focus:ring-offset-0"
        />
    </form>

    {{-- Menampilkan Judul Tugas --}}
    <div class="flex-1">
        <label class="cursor-pointer truncate text-base font-medium {{ $task->is_completed ? 'text-gray-400 line-through' : 'text-gray-800' }}">
            {{ $task->judul_tugas }}
        </label>
    </div>

    <div class="flex-1">
        {{ $task->deskripsi }}
    </div>


    <div class="flex-1">
        {{-- Menampilkan Status Tugas --}}
        {{ $task->status }}
    </div>

    <div class="flex-1">
        {{-- Menampilkan Deadline Tugas --}}
        {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
    </div>


    {{-- Badge Prioritas --}}
    @php
        $priorityClasses = [
            'tinggi' => 'bg-red-100 text-red-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'rendah' => 'bg-green-100 text-green-800',
        ];
        // Kode aman untuk menangani prioritas yang mungkin kosong
        $priorityClass = $priorityClasses[$task->prioritas ?? 'rendah'];
    @endphp
    <span class="ml-auto mr-2 flex-shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $priorityClass }}">
        {{ ucfirst($task->prioritas ?? 'rendah') }}
    </span>

    {{-- Tombol Aksi (Edit & Hapus) --}}
    <div class="flex flex-shrink-0 items-center gap-1">
        <a href="{{ route('tasks.edit', $task) }}" aria-label="Edit task" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-blue-600">
            <span class="material-icons" style="font-size: 20px;">edit</span>
        </a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Delete task" class="rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-red-600">
                <span class="material-icons" style="font-size: 20px;">delete</span>
            </button>
        </form>
    </div>
</div>
