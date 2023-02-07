<?php

namespace App\Console\Commands;

use App\Models\Broadcast;
use App\Models\GeneralParams;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecurrenceNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurrence:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Recurring Notification Mobile';

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
        //check recurring task on general params table
        $params = GeneralParams::getArray('repeat-weekday-notification');
        //checking params is active = 0;
        $update = collect($params)->map(function($row){
            $row['active'] = 1;
            return $row;
        })->toArray();
        //update params

        GeneralParams::where('slug','like','%repeat-weekday-notification%')->update(['name' => json_encode($update)]);

        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }
}
