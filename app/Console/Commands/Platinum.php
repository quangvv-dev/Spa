<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Order;

class  Platinum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:platinum';

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


        $status1 = Functions::getStatusWithCode('platinum');
        $data = Order::select('gross_revenue', 'member_id', \DB::raw('SUM(gross_revenue) AS total'))->groupBy('member_id')
            ->having('total', '>=', setting('platinum'))->get()->pluck('member_id');
        Customer::whereIn('id',$data)->update(['status_id' => $status1]);
    }
}
