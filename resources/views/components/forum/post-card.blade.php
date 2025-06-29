@props(['post'])

<div class="feed-card">
    {{-- Bagian Header Kartu --}}
    <div class="feed-card-header">
        <img alt="{{ $post->user->name }}'s Avatar" class="size-10 rounded-full" src="{{ $post->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}" />
        <div>
            <p class="text-text-primary font-semibold text-sm">{{ $post->user->name }}</p>
            <p class="text-text-secondary text-xs">{{ $post->created_at->diffForHumans() }}</p>
        </div>
    </div>

    {{-- Bagian Konten Kartu --}}
    <div class="feed-card-content">
        <h3 class="text-text-primary text-xl font-bold leading-relaxed mb-3">
            <a href="{{ route('forum.posts.show', $post) }}" class="hover:text-primary transition-colors">
                {{ $post->judul }}
            </a>
        </h3>
        <p class="text-text-secondary text-sm leading-relaxed mb-4">
            {{ Str::limit($post->isi_post, 200) }}
        </p>

        @if ($post->image_path)
            <div class="mt-4 rounded-lg overflow-hidden w-full h-full bg-black">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->judul }}" class="w-full object-contain mx-auto">
            </div>
        @endif
    </div>

    <div class="feed-card-actions">
        <button class="action-button">
            <svg fill="currentColor" height="22px" viewBox="0 0 256 256" width="22px" xmlns="http://www.w3.org/2000/svg"><path d="M178,32c-20.65,0-38.73,8.88-50,23.89C116.73,40.88,98.65,32,78,32A62.07,62.07,0,0,0,16,94c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,220.66,240,164,240,94A62.07,62.07,0,0,0,178,32ZM128,206.8C109.74,196.16,32,147.69,32,94A46.06,46.06,0,0,1,78,48c19.45,0,35.78,10.36,42.6,27a8,8,0,0,0,14.8,0c6.82-16.67,23.15-27,42.6-27a46.06,46.06,0,0,1,46,46C224,147.61,146.24,196.15,128,206.8Z"></path></svg>
            {{-- Logika untuk Likes bisa ditambahkan nanti --}}
            <span class="text-sm font-medium">Likes</span>
        </button>
        <a href="{{ route('forum.posts.show', $post) }}#comments" class="action-button">
            <svg fill="currentColor" height="22px" viewBox="0 0 256 256" width="22px" xmlns="http://www.w3.org/2000/svg"><path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128ZM84,116a12,12,0,1,0,12,12A12,12,0,0,0,84,116Zm88,0a12,12,0,1,0,12,12A12,12,0,0,0,172,116Zm60,12A104,104,0,0,1,79.12,219.82L45.07,231.17a16,16,0,0,1-20.24-20.24l11.35-34.05A104,104,0,1,1,232,128Zm-16,0A88,88,0,1,0,51.81,172.06a8,8,0,0,1,.66,6.54L40,216,77.4,203.53a7.85,7.85,0,0,1,2.53-.42,8,8,0,0,1,4,1.08A88,88,0,0,0,216,128Z"></path></svg>
            <span class="text-sm font-medium">{{ $post->comments_count }} Comments</span>
        </a>
    </div>
</div>
