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
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('otps')->update(['count' => 0, 'updated_at' => $now]);
    }
}
