<?php

namespace App\Console;

use App\Console\Commands\TranslationConvert;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Catalog\Console\CheckProductQty;
use Modules\Order\Console\UpdateBalanceOfExpiredSubscriptionCommand;
use Modules\Order\Console\UpdateFailedQtyOrdersCommand;
use Modules\Order\Console\UpdateFailedSubscriptionCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckProductQty::class,
        TranslationConvert::class,
        UpdateFailedQtyOrdersCommand::class,
        UpdateFailedSubscriptionCommand::class,
        UpdateBalanceOfExpiredSubscriptionCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('product:checkQty')->daily(); // Run the task every day at midnight
        $schedule->command('order:update')->everyMinute(); // Run the task every minute.
        $schedule->command('subscription:update')->everyMinute(); // Run the task every minute.
        $schedule->command('subscription-balance:update')->everyMinute(); // Run the task every minute.
        $schedule->command('queue:work --stop-when-empty')->everyMinute() /* ->withoutOverlapping() */;
        $schedule->command('queue:restart')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function bootstrappers()
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
