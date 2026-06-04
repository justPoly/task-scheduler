<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiLog;
use Carbon\Carbon;

class CleanOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-old-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ApiLog::where('created_at', '<', Carbon::now()->subDays(30))->delete();

        $this->info('Old logs cleaned');
    }
}
