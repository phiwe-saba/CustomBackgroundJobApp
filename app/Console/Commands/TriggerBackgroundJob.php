<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TriggerBackgroundJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:trigger-background-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger background job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $className = \App\Jobs\CustomJob::class;
        $methodName = 'process';
        $parameters = ['param1', 'param2'];

        runBackgroundJob($className, $methodName, $parameters);

        $this->info('Background job triggered successfully.');
    }
}
