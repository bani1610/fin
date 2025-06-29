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
        // Pastikan pengguna hanya bisa mengupdate tugas miliknya sendiri
        // $this->authorize('update', $task);

        // Cek apakah ini adalah request untuk toggle status
        if ($request->has('toggle_complete')) {
            // Balikkan status is_completed
            $task->is_completed = !$task->is_completed;
            $task->save();

            // Redirect KEMBALI ke halaman sebelumnya (misal: /tasks?filter=active)
            return back()->with('success', 'Status tugas berhasil diperbarui!');
        }

        // (Opsional) Tambahkan logika untuk update dari form edit di sini
        // ...

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
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
