<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class FilamentLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request): \Symfony\Component\HttpFoundation\Response
    {
        // Alihkan ke halaman utama ('/') setelah logout
        return redirect()->to('/');
    }
}
