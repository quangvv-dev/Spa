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
        $err = Functions::sendSmsV3('0334299996', 'Test tin he thong');
        return $err;

//        Status::where('code', 'membership')->update(['name' => 'Khách hàng', 'code' => 'khach_hang']);
//        Status::where('code', 'silver')->update(['name' => 'Người mua hàng', 'code' => 'nguoi_mua_hang']);
//        Status::where('code', 'gold')->update(['name' => 'Khách hàng thân thiết', 'code' => 'khach_hang_than_thiet']);
//        Status::where('code', 'platinum')->update(['name' => 'Cộng tác viên', 'code' => 'cong_tac_vien']);
//        $customers = Order::select('member_id', \DB::raw("COUNT(member_id) as count"))->groupBy('member_id')->get()
//            ->filter(function ($f) {
//                return $f->count > 1;
//            })->pluck('member_id');
//        Customer::whereIn('id', $customers)->update(['old_customer' => 1]);

//        $arr = Customer::select('id')->where('branch_id', 1)->pluck('id')->toArray();
//        $arr = CustomerGroup::select('customer_id')->where('branch_id', 0)->pluck('customer_id')->toArray();
//        $customer2 = Customer::find($arr)->pluck('branch_id', 'id')->toArray();
////        foreach (array_chunk($customer2, 1000) as $key => $item) {
//        foreach ($customer2 as $key => $item) {
//        CustomerGroup::where('customer_id', $key)->update(['branch_id' => $item]);
//        }
    }
}
