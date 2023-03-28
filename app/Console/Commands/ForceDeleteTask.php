<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class  ForceDeleteTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $now = Carbon::now()->format('Y-m-d');
        $tasks = Task::select('id', 'customer_id', 'customer_status')->where('date_from', $now)->whereNotNull('customer_status')->with('customer')->get();
        if (count($tasks)) {
            foreach ($tasks as $item) {
                if ($item->customer_status != @$item->customer->status_id) {
                    Task::find($item->id)->forceDelete();
                }
            }
            return 1;
        }
    }
}
