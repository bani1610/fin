<?php
// routes/console.php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // <-- TAMBAHKAN INI

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// TAMBAHKAN KODE PENJADWALAN DI SINI
Schedule::command('app:send-deadline-reminders')->everyTenMinutes();