<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div
                x-data="{ photoName: null, photoPreview: null }"
                class="card p-6 sm:p-8 space-y-8"
            >
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-text-primary tracking-tight">Your Profile</h2>
                </div>

                {{-- PASTIKAN SEMUA ATRIBUT DI FORM INI BENAR --}}
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                    @method('patch')

                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <span class="font-bold">Oops! Ada beberapa kesalahan:</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Bagian Foto Profil --}}
                    <div class="flex flex-col items-center space-y-4">
                        <input type="file" name="photo" class="hidden" x-ref="photo" @change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                        ">

                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-32 border-4 border-primary shadow-lg"
                             :style="photoPreview ? `background-image: url('${photoPreview}')` : `background-image: url('{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}')`">
                        </div>

                        <button type="button" @click="$refs.photo.click()" class="text-sm font-medium text-primary hover:text-opacity-80 focus:outline-none">
                            Change Profile Picture
                        </button>

                        <div class="text-center">
                            <p class="text-text-primary text-2xl font-bold leading-tight tracking-[-0.01em]">{{ $user->name }}</p>
                            <p class="text-text-secondary text-md font-medium">{{ $user->email }}</p>
                        </div>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            <span class="font-medium">Profil berhasil diperbarui!</span>
                        </div>
                    @endif

                    {{-- Sisa Form --}}
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold !text-text-primary pb-1.5" />
                        <x-text-input id="name" name="name" type="text" class="form-input mt-1 block w-full h-12" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold !text-text-primary pb-1.5" />
                        <x-text-input id="email" name="email" type="email" class="form-input mt-1 block w-full h-12" :value="old('email', $user->email)" required autocomplete="username" />
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

                    <div>
                        <x-input-label for="major" :value="__('Major')" class="text-sm font-semibold !text-text-primary pb-1.5" />
                        <x-text-input id="major" name="major" type="text" class="form-input mt-1 block w-full h-12" :value="old('major', $user->major)" placeholder="e.g., Computer Science" />
                        {{-- TAMBAHKAN INI --}}
                        <x-input-error class="mt-2" :messages="$errors->get('major')" />
                    </div>


                    <div>
                        <x-input-label for="university" :value="__('University')" class="text-sm font-semibold !text-text-primary pb-1.5" />
                        <x-text-input id="university" name="university" type="text" class="form-input mt-1 block w-full h-12" :value="old('university', $user->university)" placeholder="e.g., Stanford University" />
                        {{-- TAMBAHKAN INI --}}
                        <x-input-error class="mt-2" :messages="$errors->get('university')" />
                    </div>

                    <div>
                        <x-input-label for="bio" :value="__('Bio')" class="text-sm font-semibold !text-text-primary pb-1.5" />
                        <textarea id="bio" name="bio" rows="4" class="form-input block w-full rounded-lg p-4 resize-none" placeholder="Tell us about yourself">{{ old('bio', $user->bio) }}</textarea>
                        {{-- TAMBAHKAN INI --}}
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <div>
                        <button type="submit" class="primary-button flex w-full justify-center rounded-full h-12 px-4 items-center text-base font-semibold tracking-wide">
                            Update Profile
                        </button>
                    </div>
                    </form>
                </form>

                <div class="border-t pt-6">@include('profile.partials.update-password-form')</div>
                <div class="border-t pt-6">@include('profile.partials.delete-user-form')</div>
            </div>
        </div>
    </div>
</x-app-layout>
