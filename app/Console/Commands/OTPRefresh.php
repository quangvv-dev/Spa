<?php

namespace App\Console\Commands;

use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class  OTPRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset OTP';

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
//        Otp::truncate();
        DB::table('otps')->truncate();
    }
}
