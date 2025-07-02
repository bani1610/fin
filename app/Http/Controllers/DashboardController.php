<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MoodLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $moodToday = MoodLog::where('user_id', $user->id)
                            ->whereDate('created_at', today())
                            ->first();

        // Ambil semua tugas yang statusnya BUKAN 'done'
        $tasks = Tasks::where('user_id', $user->id)
                    ->where('status', '!=', 'done')
                    ->orderBy('deadline', 'asc')
                    ->get();

        // Inisialisasi $recommendedTasks sebagai collection kosong
        $recommendedTasks = collect();

        // Hanya jalankan logika jika mood hari ini sudah diisi
        if ($moodToday) {
            $mood = $moodToday->mood;

            if (in_array($mood, ['senang', 'semangat'])) {
                // Mood positif -> sarankan tugas berat atau sedang
                $recommendedTasks = $tasks->filter(function ($task) {
                    return in_array($task->beban_kognitif, ['berat', 'sedang']);
                })->take(3); // Ambil maksimal 3

            } elseif (in_array($mood, ['biasa', 'ragu'])) {
                // Mood biasa -> sarankan tugas sedang atau ringan
                $recommendedTasks = $tasks->filter(function ($task) {
                    return in_array($task->beban_kognitif, ['sedang', 'ringan']);
                })->take(3); // Ambil maksimal 3

            } else { // Untuk mood lelah, stres, sedih
                // Mood buruk -> sarankan HANYA tugas ringan
                $recommendedTasks = $tasks->filter(function ($task) {
                    return $task->beban_kognitif == 'ringan';
                })->take(3); // Ambil maksimal 3
            }
        }

        return view('dashboard', [
            'moodToday' => $moodToday,
            'recommendedTasks' => $recommendedTasks,
        ]);
    }

    /**
     * Menyiapkan data untuk halaman statistik.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        $user = Auth::user();
        $today = now();

        // --- Data untuk Mood Chart ---
        $moodLogs = \App\Models\MoodLog::where('user_id', $user->id)
                            ->where('created_at', '>=', $today->copy()->subDays(6)->startOfDay())
                            ->orderBy('created_at', 'asc')
                            ->get()
                            ->keyBy(function ($log) {
                                return $log->created_at->format('Y-m-d');
                            });

        // --- Data untuk Tasks Chart (BARU) ---
        $completedTasks = Tasks::where('user_id', $user->id)
            ->where('status', 'done')
            ->where('updated_at', '>=', $today->copy()->subDays(6)->startOfDay()) // 'updated_at' karena status diubah
            ->get()
            ->groupBy(function($task) {
                return $task->updated_at->format('Y-m-d');
            });

        // --- Menyiapkan data untuk kedua chart ---
        $labels = [];
        $moodChartData = [];
        $taskChartData = []; // Variabel baru untuk data chart tugas
        $moodValues = ['sedih' => 1, 'stres' => 2, 'lelah' => 3, 'ragu' => 4, 'biasa' => 5, 'semangat' => 6, 'senang' => 7];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayName = $date->isoFormat('dddd');

            $labels[] = $dayName;

            // Data untuk mood chart
            if (isset($moodLogs[$dateString])) {
                $moodChartData[] = $moodValues[$moodLogs[$dateString]->mood];
            } else {
                $moodChartData[] = 0;
            }

            // Data untuk tasks chart (BARU)
            if (isset($completedTasks[$dateString])) {
                $taskChartData[] = count($completedTasks[$dateString]);
            } else {
                $taskChartData[] = 0;
            }
        }

        // Kirim semua data ke view
        return view('statistics', compact('labels', 'moodChartData', 'taskChartData'));
    }
}
