<?php
// File: app/Http/Controllers/Admin/ForumController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class ForumController extends Controller
{
    public function posts()
    {
        $posts = Post::with('user')->latest()->paginate(15);

        // Kirim data posts ke view yang akan kita buat
        return view('admin.forum.posts', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
        // Admin bisa menghapus postingan siapa saja
        $post->delete();
        return back()->with('success', 'Postingan berhasil dihapus.');
    }
        public function store(Request $request)
    {
        // 1. Validasi Input: Pastikan judul tidak kosong
        $request->validate([
            'title' => 'required|string|max:255', // 'required' berarti wajib diisi
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // 2. Simpan ke Database
        Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title, // <-- PASTIKAN BARIS INI ADA
            'content' => $request->content,
        ]);

        return redirect()->route('forum.index')->with('success', 'Postingan berhasil dibuat!');
    }

}
