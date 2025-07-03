<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Bagian Update Informasi Profil --}}
            <div x-data="{ photoName: null, photoPreview: null }" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Profil') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Perbarui informasi profil, alamat email, dan detail lainnya.") }}
                        </p>
                    </header>

                    {{-- Menampilkan pesan error jika ada --}}
                    @if ($errors->any())
                        <div class="p-4 my-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <span class="font-bold">Oops! Ada beberapa kesalahan:</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Menampilkan pesan sukses --}}
                     @if (session('status') === 'profile-updated')
                        <div class="p-4 my-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            <span class="font-medium">Profil berhasil diperbarui!</span>
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Bagian Foto Profil --}}
                        <div class="flex flex-col items-center space-y-4">
                            <input type="file" name="photo" class="hidden" x-ref="photo" @change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($refs.photo.files[0]);
                            ">
                            
                            {{-- Tampilan Foto --}}
                            <div class="bg-center bg-no-repeat bg-cover rounded-full size-32 border-4 border-sky-500 shadow-lg"
                                 :style="photoPreview ? `background-image: url('${photoPreview}')` : `background-image: url('{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}')`">
                            </div>

                            <button type="button" @click="$refs.photo.click()" class="text-sm font-medium text-sky-600 hover:text-sky-800 focus:outline-none">
                                Ganti Foto Profil
                            </button>
                        </div>
                        
                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Alamat email Anda belum terverifikasi.') }}

                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- NIM --}}
                        <div>
                            <x-input-label for="nim" :value="__('NIM')" />
                            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->Nim)" required autocomplete="nim" />
                            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                        </div>

                        {{-- Universitas --}}
                        <div>
                            <x-input-label for="universitas" :value="__('Universitas')" />
                            <x-text-input id="universitas" name="universitas" type="text" class="mt-1 block w-full" :value="old('universitas', $user->universitas)" required autocomplete="universitas" />
                            <x-input-error class="mt-2" :messages="$errors->get('universitas')" />
                        </div>

                        {{-- Jurusan --}}
                        <div>
                            <x-input-label for="jurusan" :value="__('Jurusan')" />
                            <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full" :value="old('jurusan', $user->jurusan)" required autocomplete="jurusan" />
                            <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Form untuk mengirim verifikasi email (terpisah) --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            @endif

            {{-- Bagian Update Password --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bagian Hapus Akun --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
