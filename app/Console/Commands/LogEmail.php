<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Entities\User;

use App\Jobs\LogEmailJob as Job;

class LogEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email log';

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
     * @return mixed
     */
    public function handle()
    {
        $emails = User::count();

        if($emails)
            dispatch(new Job());
    }
}
