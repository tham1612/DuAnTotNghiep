<?php

namespace App\Console;

use App\Notifications\TaskOverdueNotification;
use App\Notifications\TaskDueNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Gửi thông báo cho task sắp đến hạn
        $schedule->call(function () {
            $tasks = Task::where('end_date', '>=', Carbon::tomorrow())
                ->where('end_date', '<', Carbon::tomorrow()->addDays(1))
                ->where('progress', '<', 100) // Chỉ lấy task chưa hoàn thành
                ->with(['members', 'catalog.board'])->get();

            foreach ($tasks as $task) {
                $task->members->each(function ($user) use ($task) {
                    $user->notify(new TaskDueNotification($task));
                });
            }
        })->dailyAt('08:00'); // Chạy mỗi ngày lúc 08:00

        // Gửi thông báo cho task quá hạn và chưa hoàn thành
        $schedule->call(function () {
            $tasks = Task::where('end_date', '<', Carbon::today()) // Task đã quá hạn
                ->where('progress', '<', 100) // Task chưa hoàn thành
                ->with(['members', 'catalog.board'])->get();

            foreach ($tasks as $task) {
                if ($this->shouldSendNotification($task)) {
                    $task->members->each(function ($user) use ($task) {
                        $user->notify(new TaskOverdueNotification($task));
                    });
                }
            }
        })->dailyAt('08:00');
    }

    /**
     * Kiểm tra xem có cần gửi thông báo cho task quá hạn hay không.
     */
    protected function shouldSendNotification($task)
    {
        // Lấy thông báo gần nhất của task (nếu có)
        $lastNotification = $task->notifications()->latest()->first();

        // Nếu chưa từng gửi thông báo hoặc đã qua 7 ngày từ lần gửi cuối cùng
        return !$lastNotification || $lastNotification->created_at->diffInDays(now()) >= 7;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
