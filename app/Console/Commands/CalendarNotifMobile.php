<?php

namespace App\Console\Commands;

use App\Services\CalendarServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;

class CalendarNotifMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upcoming Calendar';

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
            $this->info('Upcoming Event Calendar');
            //check calendar upcoming
            $request = new Request();
            $request->active = 1;
            $request->nodelete = 1;
            $request->year = date('Y');
            $request->orderBy = "asc";
            $request->comeNear = true;
            $calendar = new CalendarServices();
            $dataCalendar = $calendar->getAllWithFilter($request, 1,1);
            $count = $dataCalendar->count();
            if($count >= 1){
                $title = $dataCalendar->pluck('title')->toArray();
                $etc = ($count > 1) ? ", etc." : "";
                $allEvent = implode(', ', $title).$etc;
                //notification to expo services
                $expo = new \App\Services\ExpoService();
                $content = "Event : ".$allEvent;
                $header = $count ." Upcoming Event. Check in Calendar.";
                $data = json_encode(array('event' => url('calendar')));
                $id = "RMDCALENDAR-".now();
                $expo->reminder($header, $data, $id, $content);
            }

        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
    }
}
