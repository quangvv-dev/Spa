<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\HistorySms;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\SchedulesSms;
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
        $err = Functions::sendSmsV3('0975091435', 'toi dang test tin nhan');
        return $err;


//        $input = [
//            'start_date' => Carbon::now()->format('Y-m-d'),
//            'end_date' => Carbon::now()->format('Y-m-d'),
//        ];
//        $data = SchedulesSms::whereBetween('exactly_value', [
//            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
//            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
//        ])->get();
//        if (count($data)) {
//            foreach ($data as $item) {
//                if ($item->status)
//                $err = Functions::sendSmsV3($item->phone, $item->content);
//                if (isset($err) && $err) {
//                    HistorySms::insert([
//                        'phone' => @$item->phone,
//                        'campaign_id' => 0,
//                        'message' => $item->content,
//                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
//                    ]);
//                }
//            }
//        }

//        $detail = PaymentHistory::search($input);
//        $total = $detail->sum('price');
//        $orders = Order::whereBetween('created_at', [
//            Functions::yearMonthDay(Carbon::now()->format('Y-m-d')) . " 00:00:00",
//            Functions::yearMonthDay(Carbon::now()->format('Y-m-d')) . " 23:59:59",
//        ])->with('orderDetails');
//        $all_total = $orders->sum('all_total');
//        $grossRevenue = $orders->sum('gross_revenue');
//
//        $text = request()->getHttpHost() . ' trong ngay ' . Carbon::now()->format('d/m/Y') . ' co DS: ' . @number_format($all_total) . ' DT: ' . @number_format($grossRevenue) . ' DTTK: ' . @number_format($total) . ' VND';
//        Functions::sendSmsBK('84986898662', $text);//chithuan
//        Functions::sendSmsBK('84989996738', $text);//Athien
//        $time = '13-05-2020 14:55';
//        Functions::sendSmsV3('0334299996', $text);//gửi cho SỸ
    }
}
