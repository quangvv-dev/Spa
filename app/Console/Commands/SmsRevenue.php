<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class  SmsRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:revenue';

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
        $input = [
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date'   => Carbon::now()->format('Y-m-d'),
        ];
        $detail = PaymentHistory::search($input);
        $total = $detail->sum('price');
        $text = 'chi nhanh ' . request()->getHttpHost() . ' co doanh thu trong ngay ' . Carbon::now()->format('d-m-Y') . ' : ' . @number_format($total) . ' VND';
        Functions::sendSms('0334299996', $text);
    }
}
