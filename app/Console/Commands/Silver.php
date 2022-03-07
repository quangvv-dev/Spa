<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\CustomerGroup;
use App\Models\Status;
use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Order;

class  Silver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:silver';

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
//        $err = Functions::sendSmsV3('0975091435', 'Test tin he thong');
//        return $err;



//        $arr = Customer::select('id')->where('branch_id', 1)->pluck('id')->toArray();
//        $arr = CustomerGroup::select('customer_id')->where('branch_id', 0)->pluck('customer_id')->toArray();
//        $customer2 = Customer::find($arr)->pluck('branch_id', 'id')->toArray();
////        foreach (array_chunk($customer2, 1000) as $key => $item) {
//        foreach ($customer2 as $key => $item) {
//        CustomerGroup::where('customer_id', $key)->update(['branch_id' => $item]);
//        }
    }
}
