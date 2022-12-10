<?php

namespace App\Http\Controllers\BE\Setting;

use App\Models\Status;
use App\Models\TimeStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::where('type',3)->get();
        $arr_id_time_status = TimeStatus::pluck('status_id')->toArray();

        foreach ($status as $item){
            if(!in_array($item->id,$arr_id_time_status)){
                TimeStatus::create(['status_id'=>$item->id]);
            }
        }
        $time_status = TimeStatus::all()->map(function ($m){
            $type_ngay = 1;
            $type_gio = 2;
            $type_phut = 3;

            if($m->expired_time >= 1440){
                $m->expired_time = $m->expired_time/1440;
                $m->type_expired_time = $type_ngay;
            } else if($m->expired_time >= 60){
                $m->expired_time = $m->expired_time/60;
                $m->type_expired_time = $type_gio;
            } else {
                $m->type_expired_time = $type_phut;
            }

            if($m->time_move_cskh >= 1440){
                $m->time_move_cskh = $m->time_move_cskh/1440;
                $m->type_move_cskh = $type_ngay;
            } else if($m->time_move_cskh >= 60){
                $m->time_move_cskh = $m->time_move_cskh/60;
                $m->type_move_cskh = $type_gio;
            } else {
                $m->type_move_cskh = $type_phut;
            }

            $m->customer_child = $m->customer_child ? json_decode($m->customer_child) : [];
            return $m;
        });
        return view('settings.time_status', compact('status', 'time_status'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = TimeStatus::where('status_id', $request->status_id)->first();
        if (!$status) {
            TimeStatus::create($request->all());
        }
        return back()->with('success', 'Thêm mới thành công !!!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type_ngay = 1;
        $type_gio = 2;

        $data = $request->except('type_expired_time','type_move_cskh');
        $data['expired_time'] = $request->expired_time;
        if($request->type_expired_time == $type_ngay){
            $data['expired_time'] = $request->expired_time*1440;
        } else if($request->type_expired_time == $type_gio){
            $data['expired_time'] = $request->expired_time*60;
        }

        $data['time_move_cskh'] = $request->time_move_cskh;
        if($request->type_move_cskh == $type_ngay){
            $data['time_move_cskh'] = $request->time_move_cskh*1440;
        } else if($request->type_move_cskh == $type_gio){
            $data['time_move_cskh'] = $request->time_move_cskh*60;
        }

        TimeStatus::find($id)->update($data);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeStatus::find($id)->delete();
    }
}
