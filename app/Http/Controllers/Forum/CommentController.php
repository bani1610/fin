<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    // Menyimpan komentar baru pada sebuah postingan
    public function store(Request $request, Post $post)
    {
            $request->validate([
                'isi_komentar' => 'required|string|min:3|max:500'
            ]);

            $comment = $post->comments()->create([
                'user_id' => auth()->id(),
                'isi_komentar' => $request->isi_komentar,
            ]);

            $postOwner = $post->user;

            // Kirim notifikasi HANYA JIKA yang komentar bukan pemilik post
            if ($postOwner->id !== auth()->id()) {
                $postOwner->notify(new NewCommentNotification($comment));
            }
            // --- LOGIKA NOTIFIKASI SELESAI ---

            return back()->with('success', 'Komentar berhasil ditambahkan.');
        }
    }

