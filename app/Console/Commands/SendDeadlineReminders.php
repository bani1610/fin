<?php
// app/Console/Commands/SendDeadlineReminders.php

namespace App\Console\Commands;

use App\Models\Tasks;
use App\Notifications\TaskDeadlineReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendDeadlineReminders extends Command
{
    protected $signature = 'app:send-deadline-reminders';
    protected $description = 'Mencari tugas dengan deadline mendatang dan mengirim email pengingat.';

    public function handle()
    {
        $now = Carbon::now();
        $this->info('Mulai mengirim pengingat deadline...');

        // 1. Logika untuk pengingat H-1 (24 jam sebelumnya)
        $tasksOneDayAway = Tasks::where('status', '!=', 'done')
            ->whereNotNull('deadline')
            ->whereNull('one_day_reminder_sent_at') // Hanya yang belum dikirim notif H-1
            ->where('deadline', '>', $now)
            ->where('deadline', '<=', $now->copy()->addDay())
            ->with('user')
            ->get();

        foreach ($tasksOneDayAway as $task) {
            $task->user->notify(new TaskDeadlineReminder($task, '1 hari'));
            $task->one_day_reminder_sent_at = $now;
            $task->save();
            $this->info('Pengingat H-1 dikirim untuk tugas ID: ' . $task->task_id);
        }

        // 2. Logika untuk pengingat H-3 Jam
        $tasksThreeHoursAway = Tasks::where('status', '!=', 'done')
            ->whereNotNull('deadline')
            ->whereNull('three_hour_reminder_sent_at') // Hanya yang belum dikirim notif H-3
            ->where('deadline', '>', $now)
            ->where('deadline', '<=', $now->copy()->addHours(3))
            ->with('user')
            ->get();

        foreach ($tasksThreeHoursAway as $task) {
            $task->user->notify(new TaskDeadlineReminder($task, '3 jam'));
            $task->three_hour_reminder_sent_at = $now;
            $task->save();
            $this->info('Pengingat H-3 Jam dikirim untuk tugas ID: ' . $task->task_id);
        }

        $this->info('Selesai mengirim pengingat.');
        return 0;
    }
}