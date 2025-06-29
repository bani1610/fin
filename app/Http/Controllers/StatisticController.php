<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MoodLog;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Menampilkan halaman statistik dengan data dari database.
     * Method __invoke digunakan untuk controller yang hanya memiliki satu aksi.
     */
    public function __invoke(Request $request)
    {

        $user = Auth::user();
        $sevenDaysAgo = now()->subDays(7);

        // 1. MEMPROSES DATA MOOD DARI DATABASE
        $moodLogs = MoodLog::where('user_id', $user->id)
            ->where('created_at', '>=', $sevenDaysAgo)
            ->get();

        $totalMoods = $moodLogs->count();
        $moodCounts = $moodLogs->countBy('mood');

        $moodDetailsMap = [
            'senang' => ['emoji' => '😄', 'color' => 'bg-yellow-400'],
            'semangat' => ['emoji' => '😊', 'color' => 'bg-lime-400'],
            'biasa' => ['emoji' => '😐', 'color' => 'bg-sky-400'],
            'ragu' => ['emoji' => '🤔', 'color' => 'bg-orange-400'],
            'lelah' => ['emoji' => '😫', 'color' => 'bg-purple-400'],
            'stres' => ['emoji' => '😠', 'color' => 'bg-red-500'],
            'sedih' => ['emoji' => '😥', 'color' => 'bg-gray-400'],
        ];

        $moodBreakdown = [];
        if ($totalMoods > 0) {
            foreach ($moodCounts as $mood => $count) {
                if (isset($moodDetailsMap[$mood])) {
                    $moodBreakdown[] = [
                        'mood' => ucfirst($mood),
                        'emoji' => $moodDetailsMap[$mood]['emoji'],
                        'percentage' => round(($count / $totalMoods) * 100),
                        'color' => $moodDetailsMap[$mood]['color'],
                    ];
                }
            }
        }

        $moodChartData = [
            'labels' => $moodCounts->keys()->map('ucfirst')->all(),
            'data' => $moodCounts->values()->all(),
        ];

        // 2. MEMPROSES DATA TUGAS DARI DATABASE
        $completedTasks = Tasks::where('user_id', $user->id)
            ->where('status', 'done')
            ->where('updated_at', '>=', $sevenDaysAgo)
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        $taskLabels = [];
        $taskData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');

            $taskLabels[] = $date->format('D');
            $taskData[] = $completedTasks->get($dateString, 0);
        }

        $taskChartData = [
            'labels' => $taskLabels,
            'data' => $taskData,
        ];

        // 3. MENGIRIM SEMUA VARIABEL KE VIEW
        return view('statistics', compact(
            'moodBreakdown',
            'moodChartData',
            'taskChartData'
        ));
    }
}
