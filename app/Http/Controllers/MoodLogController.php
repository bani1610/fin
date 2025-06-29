<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MoodLog;

class MoodLogController extends Controller
{
    /**
     * Menyimpan data mood harian baru atau memperbarui yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|in:senang,semangat,biasa,ragu,lelah,stres,sedih',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Cari log milik pengguna untuk hari ini
        $log = MoodLog::where('user_id', Auth::id())
                    ->whereDate('created_at', today()) // Cari berdasarkan tanggal saja
                    ->first();

        $dataToSave = [
            'mood' => $request->mood,
            'catatan' => $request->catatan,
        ];

        if ($log) {
            // Jika sudah ada, update
            $log->update($dataToSave);
        } else {
            // Jika belum ada, buat baru
            Auth::user()->moodLogs()->create($dataToSave);
        }

        return redirect()->route('dashboard')->with('success', 'Mood kamu hari ini berhasil disimpan!');
    }
}
