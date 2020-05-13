<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\Order;
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
            'end_date' => Carbon::now()->format('Y-m-d'),
        ];
        $detail = PaymentHistory::search($input);
        $total = $detail->sum('price');
        $orders = Order::whereBetween('created_at', [
            Functions::yearMonthDay(Carbon::now()->format('Y-m-d')) . " 00:00:00",
            Functions::yearMonthDay(Carbon::now()->format('Y-m-d')) . " 23:59:59",
        ])->with('orderDetails');
        $all_total = $orders->sum('all_total');
        $grossRevenue = $orders->sum('gross_revenue');
        $text = request()->getHttpHost() . ' trong ngay ' . Carbon::now()->format('d/m/Y') . ' co DS: ' . @number_format($all_total) . ' DT: ' . @number_format($grossRevenue) . ' DTTK: ' . @number_format($total) . ' VND';
//        Functions::sendSmsBK('84986898662', $text);//chithuan
//        Functions::sendSmsBK('84989996738', $text);//Athien
        $time = '13-05-2020 14:52';;
        Functions::sendSmsV3('0353997108', $text, $time);
//        Functions::sendSmsBK('84334299996', $text);//Sy
    }
}
