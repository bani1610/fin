<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    // Menampilkan halaman utama forum dengan daftar postingan
    public function index()
    {
    $posts = Post::with('user')->withCount('comments')->latest()->paginate(10);

    // --- Tambahkan logging ini untuk debugging ---
    foreach ($posts as $post) {
        if (empty($post->id)) {
            Log::error('DEBUG_POST_ID: Post object with missing ID found in PostController@index before view rendering.');;
        }
    }

    $categories = Category::all();
    return view('Forum.index', compact('posts', 'categories'));
    }

    // Menampilkan form untuk membuat postingan baru
    public function create()
    {
        $categories = Category::all();
        return view('forum.create', compact('categories'));
    }

    // Menyimpan postingan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_post' => 'required|string|min:20',
            'kategori_id' => 'required|exists:categories,kategori_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'public/posts_images' dan dapatkan path-nya
            $imagePath = $request->file('image')->store('posts_images', 'public');
        }

        // Buat postingan baru dengan data yang divalidasi dan path gambar
        Auth::user()->posts()->create([
            'judul' => $validated['judul'],
            'isi_post' => $validated['isi_post'],
            'kategori_id' => $validated['kategori_id'],
            'image_path' => $imagePath,
        ]);


        return redirect()->route('forum.index')->with('success', 'Postingan berhasil dipublikasikan!');
    }

    // Menampilkan satu postingan beserta komentarnya
    public function show(Post $post)
    {
        // Eager load relasi untuk efisiensi
        $post->load('user', 'category', 'comments.user');
        return view('forum.show', compact('post'));
    }
    public function destroy(Post $post)
    {
        // 1. Otorisasi: Pastikan user yang login adalah pemilik post
        // $this->authorize('delete', $post);

        // 2. Hapus gambar dari storage jika ada
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // 3. Hapus post dari database
        $post->delete();

        return redirect()->route('forum.index')->with('success', 'Postingan berhasil dihapus.');
    }

    public function myPosts()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)
                    ->with('user', 'category')
                    ->latest()
                    ->paginate(10);

        // --- Tambahkan logging ini untuk debugging ---
        foreach ($posts as $post) {
            if (empty($post->id)) {
                Log::error('DEBUG_POST_ID: Post object with missing ID found in PostController@myPosts before view rendering.');
            }
        }
        // --- Akhir logging debugging ---

        $categories = Category::all();
        return view('forum.index', [
            'posts' => $posts,
            'categories' => $categories,
            'pageTitle' => 'Postingan Saya',
        ]);
    }
}
