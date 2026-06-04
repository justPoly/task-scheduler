<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiLog;
use Carbon\Carbon;

class CleanOldLogs extends Command
{
    protected $signature = 'logs:clean';

    protected $description = 'Delete logs older than 30 days';

    public function handle()
    {
        ApiLog::where('created_at', '<', Carbon::now()->subDays(30))->delete();

        $this->info('Old logs cleaned');
    }
}