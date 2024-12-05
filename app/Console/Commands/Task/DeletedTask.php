<?php
namespace App\Console\Commands\Task;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeletedTask extends Command
{
    protected $signature = 'tasks:delete-mismatched';
    protected $description = 'Delete tasks with mismatched customer statuses';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('tasks')
            ->join('customers', 'tasks.customer_id', '=', 'customers.id')
            ->whereColumn('tasks.customer_status', '<>', 'customers.status_id')
            ->delete();
        $this->info('Mismatched tasks deleted successfully.');
    }
}
