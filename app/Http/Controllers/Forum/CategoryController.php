<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan postingan berdasarkan kategori
    public function show(Category $category)
    {
        $posts = $category->posts()->with('user', 'category')->latest()->paginate(10);
        $categories = Category::all();
        return view('forum.index', compact('posts', 'categories', 'category'));
    }
}
