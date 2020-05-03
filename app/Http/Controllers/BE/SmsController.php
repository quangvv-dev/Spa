<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\HistorySms;
use App\Models\OrderDetail;
use App\Models\Status;
use Carbon\Carbon;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{

    public function __construct()
    {
        $campaign_arr = Campaign::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
        view()->share([
            'campaign_arr' => $campaign_arr,
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Quản lý nội dung tin nhắn';
        $category = Category::select('id', 'name')->has('services')->with('services')->get()
            ->map(function ($item) {
                $count = CustomerGroup::where('category_id', $item->id)
                    ->groupBy('customer_id')->get()->count();
                $item->name = $item->name . ' (' . $count . ')';
                return $item;
            })->pluck('name', 'id')->toArray();
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id');
        $campaign = Campaign::orderBy('id', 'desc')->paginate(StatusCode::PAGINATE_10);

        return view('sms.index', compact('title', 'category', 'status', 'campaign'));
    }

    /**
     * Đếm số customers thuộc nhóm
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getCountCustomer(Request $request)
    {
        $arr_customers = CustomerGroup::where('category_id', $request->category_id)
            ->groupBy('customer_id')->pluck('customer_id')->toArray();
        $count = Customer::whereIn('id', $arr_customers)->where('status_id', $request->status_id)
            ->when($request->time_from && $request->time_to, function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($request->time_from) . " 00:00:00",
                    Functions::yearMonthDay($request->time_to) . " 23:59:59",
                ]);
            })
            ->get()->count();
        return $count;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Campaign::create($request->all());
//        setting([
//            'sms_cskh'         => $request->sms_cskh,
//            'sms_csnv'         => $request->sms_csnv,
//            'sms_birthday_kh'  => $request->sms_birthday_kh,
//            'sms_cskh_booking' => $request->sms_cskh_booking,
//        ])->save();
        return redirect()->back()->with('status', 'TẠO CHIẾN DỊCH THÀNH CÔNG !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function sentSms(Request $request)
    {
        if (isset($request->sms_group) && $request->sms_group && !empty($request->campaign_id)) {
            setting(['sms_group' => $request->sms_group])->save();
            $arr_customers = CustomerGroup::where('category_id', $request->category_id)
                ->groupBy('customer_id')->pluck('customer_id')->toArray();
            $users = Customer::whereIn('id', $arr_customers)->where('status_id', $request->status_id)
                ->pluck('phone', 'full_name')->toArray();
            $number = 0;
            if (count($users)) {
                foreach ($users as $key => $item) {
                    if (strlen($item) == 10) {
                        $phone= Functions::convertPhone($item);
                        $key = str_replace('%full_name%', $key, $request->sms_group);
                        $body = Functions::vi_to_en($key);
                        $err = Functions::sendSmsBK($phone, $body);
                        if (isset($err) && $err) {
                            $number++;
                            $input['phone'] = $item;
                            $input['campaign_id'] = $request->campaign_id ?: 0;
                            $input['message'] = $body;
                            HistorySms::create($input);
                            if (isset($request->limit) && $request->limit && $request->limit <= $number) {
                                break;
                            }
                        }
                    }
                }
            } else {
                return back()->with('error', 'LỰA CHỌN KHÔNG CÓ KHÁCH HÀNG THỎA MÃN !!!');
            }
            if ($number == 0) {
                return back()->with('error', 'LỰA CHỌN KHÔNG CÓ KHÁCH HÀNG THỎA MÃN !!!');
            }
            return back()->with('status', 'GỬI TIN THÀNH CÔNG CHO ' . $number . ' KHÁCH HÀNG !!!');
        }
    }

    public function sentSmsBK(Request $request)
    {
        if (isset($request->sms_group) && $request->sms_group) {
            setting(['sms_group' => $request->sms_group])->save();
            $services = [];
            $phone = [];
            $date = Carbon::now()->format('d/m/Y H:i');
            $category = Category::find($request->category_id);

            if (isset($category) && $category) {
                foreach ($category->services as $value) {
                    $services[] = $value->id;
                }
            }
            $order_detail = OrderDetail::groupBy('order_id')->has('order')->with('order')
                ->whereIn('booking_id', $services)->get();
            if (count($order_detail)) {
                foreach ($order_detail as $val) {
                    if (isset($val->order->customer) && $val->order->customer->phone && $val->order->customer->full_name) {
                        if (!in_array($val->order->customer->phone,
                                $phone) && strlen($val->order->customer->phone) == 10) {
                            $phone[] = $val->order->customer->phone;
                            $body = $request->sms_group;
                            $body = str_replace('%full_name%', @$val->order->customer->full_name, $body);
                            $body = Functions::vi_to_en($body);
//                        Functions::sendSms($val->order->customer->phone, $body, $date);
                        }
                    }
                }
            }
            return back()->with('status', 'Gửi tin hệ thống thành công !!!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Campaign::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Campaign::findOrFail($id);
        $data->delete();
        return 1;
    }
}
