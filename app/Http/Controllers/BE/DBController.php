<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Jobs\ZaloZns;
use App\Models\TokenZalOa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Excel;

class DBController extends Controller
{
    public function __construct($template_id = null)
    {
        $this->template_id = $template_id ?? config('partners.zalo_zns.template_id');
    }

    public function index(Request $request)
    {
//        $phone = '0975091435';
//        $data = ['customer_name' => "Chị Nhiên", 'order_code' => 'DH112334','created_at'=>'01/06/2024 21:13'];
////        Session::flush();
//        $oa = TokenZalOa::first();
//        if (empty($this->template_id) || empty($oa)) {
//            return false;
//        }
//        $newPhone = substr_replace($phone, "84", 0, 1);
//        $response = GuzzleHttpCall(config('partners.zalo_zns.url'), 'post',
//            ['access_token' => $oa->access_token]
//            , [
//                'tracking_id' => 'development',
//                'phone' => $newPhone,
//                'template_id' => $this->template_id,
//                'template_data' => $data,
//            ]);
//        return $response->error;
        ZaloZns::dispatch('0975091435', ['customer_name' => "Chị Nhiên", 'order_code' => 'DH112344','created_at'=>'15/12/2023 21:13'])
            ->delay(now()->addSeconds(2));
//        $c = PaymentHistory::select('payment_histories.id', 'payment_histories.is_debt', \DB::raw('MONTH(payment_histories.payment_date) as month'), \DB::raw('MONTH(o.created_at) as m_created'))
//            ->whereDate('payment_histories.payment_date','>=', $request->date)
//            ->join('orders as o', 'o.id', '=', 'payment_histories.order_id')->get()->chunk(300);
//        foreach ($c as $item) {
//            foreach ($item as $i) {
//                if ($i->month != $i->m_created) {
//                    $i->is_debt = 1;
//                    $i->save();
//                }
//            }
//        }
//
        return 1;
//        $param = $request->all();
//        $orders2 = PaymentHistory::where('price', '>', 0)
//            ->whereBetween('payment_date', ['2021-01-01 00:00:00', '2021-11-30 23:59:59'])->where('branch_id', $param['branch_id'])
//            ->with('order')
//            ->when(isset($param['type']), function ($q) use ($param) {
//                $q->onlyTrashed();
//            })->get();
//
//        Excel::create('Đơn hàng (' . date("d/m/Y") . ')', function ($excel) use ($orders2) {
//            $excel->sheet('Sheet 1', function ($sheet) use ($orders2) {
//                $sheet->cell('A1:P1', function ($row) {
//                    $row->setBackground('#008686');
//                    $row->setFontColor('#ffffff');
//                });
//                $sheet->freezeFirstRow();
//                $sheet->row(1, [
//                    'STT',
//                    'Ngày thanh toán',
//                    'Ngày tạo thanh toán',
//                    'Mã đơn',
//                    'Số tiền',
//                    'Tên KH',
//                    'SĐT',
//                    'Doanh số',
//                    'Doanh thu',
//                ]);
//                $i = 1;
//                if ($orders2) {
//                    foreach ($orders2 as $k => $ex) {
//                        $i++;
//                        $sheet->row($i, [
//                            @$k + 1,
//                            isset($ex->payment_date) ? date("d/m/Y", strtotime($ex->payment_date)) : '',
//                            isset($ex->created_at) ? date("d/m/Y", strtotime($ex->created_at)) : '',
//                            isset($ex->deleted_at) ? date("d/m/Y", strtotime($ex->deleted_at)) : '',
//                            @$ex->price,
//                            @$ex->order->customer->full_name,
//                            @$ex->order->customer->phone,
//                            @$ex->order->all_total,
//                            @$ex->order->gross_revenue,
//                        ]);
//                    }
//                }
//            });
//        })->export('xlsx');

    }
}
