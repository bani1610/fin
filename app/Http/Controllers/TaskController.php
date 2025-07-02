<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar semua tugas.
     */
    public function index(Request $request)
    {
        // Ambil nilai filter dari URL, defaultnya adalah 'active'
        $filter = $request->query('filter', 'active');

        // Mulai query builder untuk model Task
        $query = auth()->user()->tasks();

        switch ($filter) {
            case 'completed':
                $query->where('status', 'done');
                break;
            case 'all':
                break;
            case 'active':
            default:
                $query->where('status', '!=', 'done');

                break;
        }

        // Ambil data setelah difilter, urutkan, dan paginasi
        $tasks = $query->latest()->paginate(10);

        // Kirim data tasks dan nilai filter saat ini ke view
        return view('tasks.index', [
            'tasks' => $tasks,
            'currentFilter' => $filter
        ]);
    }
    /**
     * Menampilkan form untuk membuat tugas baru.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Menyimpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'beban_kognitif' => 'required|in:ringan,sedang,berat',
        ]);

        Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tugas.
     */
    public function show(Tasks $task)
    {
        // Pastikan user hanya bisa mengedit tugas miliknya
        // $this->authorize('update', $task);
        return view('tasks.show', compact('task'));
    }
    public function edit(Tasks $task)
    {
        // Pastikan user hanya bisa mengedit tugas miliknya
        // $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Tasks $task)
    {
        // Cek apakah ini adalah request dari checkbox di halaman daftar tugas
        if ($request->has('toggle_complete')) {
            // Ubah logika dari 'is_completed' menjadi 'status'
            // Jika statusnya 'done', ubah kembali ke 'inprogress'. Jika bukan, ubah menjadi 'done'.
            $task->status = ($task->status === 'done') ? 'inprogress' : 'done';
            $task->save();

            return back()->with('success', 'Status tugas berhasil diperbarui!');
        }

        // Ini adalah logika untuk memproses form dari halaman "Edit Tugas"
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'beban_kognitif' => 'required|in:ringan,sedang,berat',
            'status' => 'required|in:todo,inprogress,done',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Tasks $task)
    {
        // $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
