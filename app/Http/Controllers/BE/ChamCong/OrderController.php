<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public $time = [];
    public function __construct()
    {
        $this->time = [
            1=> '00:00',
            2=> '00:30',
            3=> '01:00',
            4=> '01:30',
            5=> '02:00',
            6=> '02:30',
            7=> '03:00',
            8=> '03:30',
            9=> '04:00',
            10=> '04:30',
            11=> '05:00',
            12=> '05:30',
            13=> '06:00',
            14=> '06:30',
            15=> '07:00',
            16=> '07:30',
            17=> '08:00',
            18=> '08:30',
            19=> '09:00',
            20=> '09:30',
            21=> '10:00',
            22=> '10:30',
            23=> '11:00',
            24=> '11:30',
            25=> '12:00',
            26=> '12:30',
            27=> '13:00',
            28=> '13:30',
            29=> '14:00',
            30=> '14:30',
            31=> '15:00',
            32=> '15:30',
            33=> '16:00',
            34=> '16:30',
            35=> '17:00',
            36=> '17:30',
            37=> '18:00',
            38=> '18:30',
            39=> '19:00',
            40=> '19:30',
            41=> '20:00',
            42=> '20:30',
            43=> '21:00',
            44=> '21:30',
            45=> '22:00',
            46=> '22:30',
            47=> '23:00',
            48=> '23:30'
            ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docs = Order::paginate(20);
        return view('cham_cong.order.index',compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $time = $this->time;
        $type = 1;
        if($type == 1){
            return view('cham_cong.order.order_type.don_nghi',compact('time'));
        } else if($type == 2){
            return view('cham_cong.order.order_type.don_check_in_out',compact('time'));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('cham_cong.order.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
