<?php

namespace App\Console;

use App\Events\LessThanQuantityEvent;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Models\Notification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $ingredients = Ingredient::get();



        if ($ingredients) {
            foreach ($ingredients as $ingredient){
                if ($ingredient->quantity <= $ingredient->should_notify_quantity){
                    $notification = Notification::create([
                        'text' => 'The amount of ' . $ingredient->name .  ' decreased to less than its minimum level',
                        'branch_id' => $ingredient->branch_id
                    ]);
                    event(new LessThanQuantityEvent($notification));
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
