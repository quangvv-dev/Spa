<?php

namespace App\Console\Commands;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Status;
use Illuminate\Console\Command;

class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

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
        $status = Status::where('code', 'like', '%da_mua_l1%')->first();
        if (isset($status) && $status) {
            $data = Customer::with('status', 'orders')->whereHas('status', function ($q) {
                $q->where('status.code', 'like', '%moi%');
            });
            $data = $data->get();
            if (count($data)) {
                foreach ($data as $item) {
                    if (isset($item->orders) && count($item->orders)) {
                        $item->update(['status_id' => $status->id]);
                    }
                }
            }
        }
    }
}
