<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    //
}

class CleanOldLogs extends Command
{
    protected $signature = 'logs:clean';
    protected $description = 'Delete logs older than 30 days';

    public function handle()
    {
        ApiLog::where('created_at', '<', now()->subDays(30))->delete();

        $this->info('Old logs deleted successfully');
    }

}
