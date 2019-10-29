<?php

namespace App\Http\Controllers\BE;

use App\Helpers\Functions;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Quản lý nội dung tin nhắn';
        $category = Category::has('services')->with('services')->get()->pluck('name','id');
        $services = [];
        $phone = [];
//        $category = Category::has('services')->with('services')->get();
//        if (count($category)) {
//            foreach ($category as $item) {
//                foreach ($item->services as $value) {
//                    $services[] = $value->id;
//                }
//            }
//        }
//        $order_detail = OrderDetail::groupBy('order_id')->has('order')->with('order')->whereIn('booking_id',
//            $services)->get();
//        if (count($order_detail)) {
//            foreach ($order_detail as $val) {
//                if (isset($val->order->customer) && $val->order->customer->phone) {
//                    dd($val->order->customer->phone);
//                    $phone[] = $val->order->customer->phone;
//                }
//            }
//        }
//        dd($order_detail);
        return view('sms.index', compact('title','category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        setting([
            'sms_cskh'         => $request->sms_cskh,
            'sms_csnv'         => $request->sms_csnv,
            'sms_birthday_kh'  => $request->sms_birthday_kh,
            'sms_cskh_booking' => $request->sms_cskh_booking,
        ])->save();
        return redirect()->back();
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
        //
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
        //
    }
}
