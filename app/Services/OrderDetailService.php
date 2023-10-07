<?php

namespace App\Services;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\OrderDetail;
use App\Models\ProductDepot;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderDetailService
{
    public $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function create($data, $orderId)
    {

        $dataArr = [];

        if (empty($data) && is_array($data) == false) {
            return false;
        }

        foreach ($data['service_id'] as $key => $value) {
            $dataArr[] = [
                'created_at' => Carbon::now()->format('Y-m-d H:i'),
                'order_id' => $orderId,
                'user_id' => $data['user_id'],
                'booking_id' => $data['service_id'][$key],
                'days' => isset($data['days']) && count($data['days']) ? $data['days'][$key] : 0,
                'quantity' => $data['quantity'][$key],
                'price' => replaceNumberFormat($data['price'][$key]),
                'vat' => 0,
                'address' => $data['address'],
                'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                'total_price' => replaceNumberFormat($data['total_price'][$key]),
                'branch_id' => $data['branch_id'],
            ];
            $service = Services::where('id', $data['service_id'][$key])->first();

            if ($data['service_note'][$key]) {
                $service->update(['description' => $data['service_note'][$key]]);

            }

            if ($data['role_type'] == StatusCode::PRODUCT || $data['role_type'] == StatusCode::COMBOS) {
                $product = ProductDepot::where('branch_id', $data['branch_id'])->where('product_id', $data['service_id'][$key])->first();
                if (isset($product)) {
                    $product->quantity = $product->quantity - $data['quantity'][$key];
                    $product->save();
                }
            }
        }
        if (!empty($dataArr)) {
            $model = OrderDetail::insert($dataArr);

            return $model;
        }
    }

    public function update($data, $orderId)
    {
        if (empty($data) && is_array($data) == false) {
            return false;
        }
        $dataArr = [];
        foreach ($data['service_id'] as $key => $value) {
            if ($data['service_id']) {
                $dataArr[] = [
                    'id' => isset($data['order_detail_id'][$key]) ? $data['order_detail_id'][$key] : '',
                    'order_id' => $orderId,
                    'user_id' => $data['user_id'],
                    'booking_id' => $data['service_id'][$key],
                    'days' => isset($data['days'][$key]) ? $data['days'][$key] : 0,
                    'quantity' => isset($data['quantity'][$key]) ? $data['quantity'][$key] : 0,
                    'price' => replaceNumberFormat($data['price'][$key]),
                    'vat' => 0,
                    'address' => $data['address'],
                    'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                    'total_price' => replaceNumberFormat($data['total_price'][$key]),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ];
                $service = Services::where('id', $data['service_id'][$key])->withTrashed()->first();

                if (isset($data['service_note'][$key])) {
                    $service->update(['description' => $data['service_note'][$key]]);

                }
            }

        }

        $orderDetail = [];

        if (count($dataArr)) {
            OrderDetail::where('order_id', $orderId)->delete();

            foreach ($dataArr as $item) {
//                if (!empty($item['id'])) {
//                    $orderDetail = OrderDetail::where('id', $item['id'])->first();
//                    $orderDetail->update($item);
//                }
//                if (empty($item['id'])) {
                $orderDetail = OrderDetail::create($item);
//                }
            }
        }


        return $orderDetail;
    }

    public function revenueWithSource($input)
    {
        return $this->orderDetail->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('order_detail.created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('order_detail.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('order_detail.branch_id', $input['group_branch']);
        })->join('customers as c', 'c.id', '=', 'order_detail.user_id')->join('status as s', 'c.source_id', '=', 's.id')
            ->select(
                DB::raw('SUM(order_detail.total_price) as revenue'), 's.name as name')
            ->groupBy('c.source_id')->get();
    }

    public function revenueWithTrademark($input)
    {
        return $this->orderDetail->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('order_detail.created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('order_detail.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('order_detail.branch_id', $input['group_branch']);
        })->join('services as s', 's.id', 'order_detail.booking_id')->join('trademarks as t', 't.id', 's.trademark')
            ->select(DB::raw('SUM(order_detail.total_price) as price'), 't.name as name')
            ->groupBy('s.trademark')->orderByDesc('price')->get();
    }

    public function revenueWithService($input, $type = StatusCode::PRODUCT)
    {
        return $this->orderDetail->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('order_detail.created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('order_detail.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('order_detail.branch_id', $input['group_branch']);
        })->join('services as s', 's.id', 'order_detail.booking_id')
            ->select(DB::raw('SUM(order_detail.total_price) as total'), 's.name as name')
            ->where('s.type', $type)
            ->groupBy('s.id')->orderByDesc('total')->get();
    }
}
