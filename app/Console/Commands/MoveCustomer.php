<?php

namespace App\Console\Commands;

use App\Constants\StatusConstant;
use App\Models\Customer;
use App\User;
use Illuminate\Console\Command;

class MoveCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move_customer:search';

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
        $search['expired_time_boolean'] = StatusConstant::QUA_HAN;
        $search['date_check_move'] = date('Y-m-d H:i:s');
        $customers = Customer::search1($search);
        $customers1 = clone $customers;

        $arr_customer = $customers1->pluck('id')->toArray();

//        $sale_leader = User::where('department_id', 2)->where('is_leader', 1)->pluck('id')->toArray();
//
//        $chia_so_den_vi_tri = 0;
//        $count_sale_leader = count($sale_leader);

        foreach ($arr_customer as $item) {
//            if ($chia_so_den_vi_tri >= $count_sale_leader) {
//                $chia_so_den_vi_tri = 0;
//            }
            $current_user = Customer::where('id',$item)->with('timeStatus','branch')->first();
            $sale_leader = User::select('id')->where('department_id', 2)->where('is_leader', 1)->where('location_id',$current_user->branch->location_id)->first();

            if($current_user->timeStatus){
                $status_next = $current_user->timeStatus->status_id_next;
            } else {
                $status_next = $current_user->status_id;
            }
            if ($current_user && $sale_leader) {
                $current_user->update([
                    'expired_time' => NULL,
                    'time_move_cskh' => NULL,
                    'expired_time_boolean' => StatusConstant::MOVE_CSKH,
                    'telesales_id' => $sale_leader->id,
                    'status_id' => $status_next
                ]);
            }
//            $chia_so_den_vi_tri++;
        }

        return 1;
    }
}
