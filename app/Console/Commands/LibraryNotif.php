<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LibraryNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Library Expired Date';

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
        //run controller sendNotificationLibrary
        $this->info('Library Expired Date');
        $email = new \App\Http\Controllers\EmailController();
        $request = new \Illuminate\Http\Request();
        $request->last_month = 1;
        $email->sendNotificationLibrary($request);
    }
}
