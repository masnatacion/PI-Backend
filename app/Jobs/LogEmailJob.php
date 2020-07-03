<?php

namespace App\Jobs;

use Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\User;

class LogEmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = User::select("email")->get();

        if($emails)
        {
            $data = $emails->implode('email',',');
            Log::info($data);
        }
    }
}
