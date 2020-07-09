<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Commission;

class  JobQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:action';

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
        $input['data_time'] = 'THIS_MONTH';
        $query = Order::returnRawData($input)->get();
        foreach ($query as $item) {
            Commission::where('order_id', $item->id)->update(['created_at' => $item->created_at]);
        }
        return 1;
    }
}
