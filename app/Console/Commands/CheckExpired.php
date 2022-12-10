<?php

namespace App\Console\Commands;

use App\Constants\StatusConstant;
use App\Models\Customer;
use Illuminate\Console\Command;

class CheckExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check customer expired';

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
        $search['expired_time_boolean'] = [StatusConstant::CHUA_QUA_HAN];
        $search['date_check_expired'] = date('Y-m-d H:i:s');
        Customer::search1($search)->update(['expired_time_boolean'=>StatusConstant::QUA_HAN,'expired_time'=>null]);
        return 1;
    }
}
