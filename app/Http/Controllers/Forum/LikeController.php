<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Notifications\PostLikedNotification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Menangani proses like/unlike pada sebuah post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        $postOwner = $post->user;

        // Toggle like
        $result = $user->likes()->toggle($post->post_id);

        if (in_array($post->post_id, $result['attached']) && $user->id !== $postOwner->id) {
            $postOwner->notify(new PostLikedNotification($user, $post));
        }

        return back();
    }
}