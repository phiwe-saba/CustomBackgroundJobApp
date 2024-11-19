<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CustomJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }

    public function process($param1, $param2)
    {
        // Example processing logic
        file_put_contents(storage_path('logs/example_job.log'), "Processing $param1, $param2\n", FILE_APPEND);
    }
}
