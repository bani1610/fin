<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 font-bold sm:text-2xl text-indigo-600">
                        MoodStudy 🚀
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-text hover:text-primary text-sm font-medium leading-normal transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" class="text-text hover:text-primary text-sm font-medium leading-normal transition-colors">
                        {{ __('Tasks') }}
                    </x-nav-link>
                    <x-nav-link :href="route('statistics')" :active="request()->routeIs('statistics')" class="text-text hover:text-primary text-sm font-medium leading-normal transition-colors">
                        {{ __('Stastistik') }}
                    </x-nav-link>
                    {{-- Perbaikan kecil: routeIs('forum.*') agar aktif di semua halaman forum --}}
                    <x-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*')" class="text-text hover:text-primary text-sm font-medium leading-normal transition-colors">
                        {{ __('Forum') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Bagian Kanan Navigasi (Notifikasi & Profil) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                {{-- Dropdown Notifikasi --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative flex items-center justify-center size-10 rounded-full bg-slate-100 hover:bg-slate-200 transition-colors mr-4">
                        <span class="material-icons text-2xl">notifications</span>
                        {{-- Tampilkan badge HANYA JIKA ada notifikasi yang belum dibaca --}}
                        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                        @endif
                    </button>

                    {{-- Isi Dropdown --}}
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border z-50" style="display: none;">
                        <div class="p-3 font-semibold text-sm border-b">Notifikasi</div>
                        <div class="divide-y max-h-96 overflow-y-auto">
                            @if(isset($unreadNotifications))
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="block p-3 hover:bg-slate-50">
                                        <p class="text-sm">
                                            @if($notification->type == 'App\Notifications\PostLikedNotification')
                                                <span class="font-bold">{{ $notification->data['liker_name'] ?? 'Seseorang' }}</span> menyukai postingan Anda: <span class="font-semibold text-gray-700">"{{ Str::limit($notification->data['post_title'] ?? 'postingan', 25) }}"</span>
                                            @elseif($notification->type == 'App\Notifications\NewCommentNotification')
                                                <span class="font-bold">{{ $notification->data['commenter_name'] ?? 'Seseorang' }}</span> mengomentari postingan Anda: <span class="font-semibold text-gray-700">"{{ Str::limit($notification->data['post_title'] ?? 'postingan', 25) }}"</span>
                                            @else
                                                Anda memiliki notifikasi baru.
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <p class="p-4 text-sm text-center text-gray-500">Tidak ada notifikasi baru.</p>
                                @endforelse
                            @else
                                {{-- Pesan jika variabel $unreadNotifications tidak ada --}}
                                <p class="p-4 text-sm text-center text-gray-500">Gagal memuat notifikasi.</p>
                            @endif
                        </div>
                        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                             <div class="p-2 border-t bg-slate-50 rounded-b-lg">
                                <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-center text-sm font-medium text-blue-600 hover:text-blue-800">Tandai semua sudah dibaca</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Dropdown Pengguna --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center transition">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-transparent hover:border-primary transition-all" style="background-image: url('{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}');"></div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Menu Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                {{ __('Tasks') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('statistics')" :active="request()->routeIs('statistics')">
                {{ __('Stastistik') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*')">
                {{ __('Forum') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>