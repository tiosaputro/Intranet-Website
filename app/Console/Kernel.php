<?php

namespace App\Console;

use App\Models\Broadcast;
use App\Models\GeneralParams;
use App\Models\NotificationMobile;
use App\Models\User;
use App\Services\ExpoService;
use App\Services\NotifikasiServices;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\LibraryNotif::class,
        \App\Console\Commands\CalendarNotifMobile::class,
        \App\Console\Commands\RecurrenceNotif::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('library:expired')->daily();
        $schedule->command('calendar:upcoming')->weeklyOn(1, '8:00');
        $schedule->command('calendar:upcoming')->weeklyOn(3, '8:00');
        $schedule->command('recurrence:notification')->everyTwoHours();
        // $schedule->command('recurrence:notification')->everyTwoMinutes();
        try{
            //check recurring task on broadcast table
            $broadcast = Broadcast::where('is_recurrence', 1)->whereRaw("duration is not null")->where("cron_active",0)->get();
            if($broadcast->count() > 0){
                foreach($broadcast as $row){
                    //call cron job
                    $duration = $row->duration;
                    //name user
                    $user = User::where('id', $row->updated_by)->first();
                    $namaUser = $user->name;
                    $schedule->call(function () use ($row, $namaUser) {
                        //action notification mobile expo
                        NotificationMobile::create([
                            'id' => generate_id(),
                            'content_id' => $row->id,
                            'category' => $row->type,
                            'title' => $row->title,
                            'path' => url('broadcast/detail/' . $row->type . '/' . $row->id),
                            'created_at' => now(),
                            'updated_at' => now(),
                            'created_by' => $row->updated_by,
                            'updated_by' => $row->updated_by,
                            'author_by' => $namaUser
                        ]);
                        //expo notif mobile service
                        $judul = Str::words($row->title, 15);
                        $body = $judul;
                        $data = json_encode(array('event' => url('broadcast/detail/' . $row->type . '/' . $row->id)));
                        $expo = new ExpoService();
                        $expo->broadcastContent($body, $data, $row->id, $namaUser);

                        $row->cron_active = 1;
                        $row->date_cron_active = now();
                        $row->save();
                    })->$duration();

                }
            }
        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }

        try{
            $params = GeneralParams::getArray('repeat-weekday-notification');
            //checking params is active = 1;
            $notifServices = new NotifikasiServices();
            $summary = $notifServices->summaryNotif([]);
            collect($params)->map(function($row) use ($schedule, $summary){
                if($row['active'] == 1){
                    $dura = $row['duration'];
                    $at = $row['at'];
                    //get summary
                    $count = $summary[$row['category']];
                    if($count > 0){
                        //run command with category
                        $schedule->command('notifcount:send '.$row['category'])->$dura()->at($at);
                    }
                }//endif
            });

        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
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
