<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Helpers\Functions;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Role;
use App\Models\Status;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Excel;

class DBController extends Controller
{
    public function index(Request $request)
    {

        $orders2 = PaymentHistory::where('price', '>', 0)
            ->whereBetween('created_at', ['2022-08-01 00:00:00', '2022-08-09 23:59:59'])->where('branch_id', 5)->with('order')->onlyTrashed()->get();

        Excel::create('Đơn hàng (' . date("d/m/Y") . ')', function ($excel) use ($orders2) {
            $excel->sheet('Sheet 1', function ($sheet) use ($orders2) {
                $sheet->cell('A1:P1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
                $sheet->row(1, [
                    'STT',
                    'Ngày thanh toán',
                    'Ngày tạo thanh toán',
                    'Ngày xóa',
                    'Số tiền',
                    'Tên KH',
                    'SĐT',
                    'Doanh số',
                ]);
                $i = 1;
                if ($orders2) {
                    foreach ($orders2 as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$k + 1,
                            isset($ex->payment_date) ? date("d/m/Y", strtotime($ex->payment_date)) : '',
                            isset($ex->created_at) ? date("d/m/Y", strtotime($ex->created_at)) : '',
                            isset($ex->deleted_at) ? date("d/m/Y", strtotime($ex->deleted_at)) : '',
                            @$ex->price,
                            @$ex->order->customer->full_name,
                            @$ex->order->customer->phone,
                            @$ex->order->all_total,
                        ]);
                    }
                }
            });
        })->export('xlsx');

    }
}
