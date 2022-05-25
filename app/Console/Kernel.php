<?php

namespace App\Console;

use App\Models\Task;
use App\Models\User;
use App\Services\NotificationSender;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $tasks = Task::all();

        foreach($tasks as $task){
            $date_now = Carbon::now();
            $deadline = Carbon::parse($task->expiry_date);
            $diff = $deadline ->diffInDays($date_now);
        NotificationSender::send();

    }
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
