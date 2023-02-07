<?php

namespace App\Console\Commands;

use App\Models\GeneralParams;
use App\Services\ExpoService;
use App\Services\NotifikasiServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifCountWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifcount:send {category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification Count Weekly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $notifServices = new NotifikasiServices();
            $summary = $notifServices->summaryNotif([]);
            $this->info('Notification Count Weekly');
            $category = $this->argument('category');
            //get summary
            $count = $summary[$category];
            $paramsGen = GeneralParams::getArray('repeat-weekday-notification');
            $params = collect($paramsGen)->where('category', $category)->values()->first();
            if($count > 0){
                //expo notif mobile service
                $data = json_encode(array('event' => env('APP_DOMAIN').$params['path']));
                $expo = new ExpoService();
                $header = "You have ".$count." new ".$params['category']." notification";
                $content = "Click here to see the detail.";
                $expo->countNotif(ucwords($header), $data, 1, $content);
            }

        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }
}
