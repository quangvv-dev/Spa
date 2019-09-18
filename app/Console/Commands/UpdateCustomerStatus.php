<?php

namespace App\Console\Commands;

use App\Http\Controllers\BE\CustomerController;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCustomerStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:customer_status';

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

    private $customerService;
    public function __construct(CustomerService $customerService)
    {
        parent::__construct();
        $this->customerService = $customerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customers = Customer::getAll();
        try {
            DB::beginTransaction();

            $this->customerService->updateStatus($customers);

            DB::commit();

            //send output to the console
            $this->info('Update status customer success!');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->error($e->getMessage());
        }
    }
}
