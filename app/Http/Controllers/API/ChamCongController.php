<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Models\ChamCong;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChamCongController extends BaseApiController
{
    public function store(Request $request)
    {
//        $data = "{\"NameMachine\":\"HN1\",\"Info\":[{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 1:58:07 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:11 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:19 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/7\/2023 8:54:42 AM\",\"IndRedID\":\"1\"}]}";
        $data = $request->all();
        \DB::table('settings')->insert(['setting_key'=>'cham_cong','setting_value'=>\GuzzleHttp\json_encode($data)]);

        $input = [];
//        $array_approval_code = User::pluck('approval_code')->toArray();

        foreach ($data['Info'] as $item) {
            $date = Carbon::parse($item['DateTimeRecord'])->format('Y-m-d H:i:s');
            $isset = ChamCong::where('name_machine', $data['NameMachine'])->where('ind_red_id', $item['IndRedID'])->where('date_time_record', $date)->first();
            $approval_code = $data['NameMachine'].'.'.$item['IndRedID'];

//            if(in_array($approval_code,$array_approval_code)){
            if (empty($isset)) {
                $input[] = [
                    'name_machine'     => $data['NameMachine'],
                    'machine_number'   => $item['MachineNumber'],
                    'date_time_record' => $date,
                    'ind_red_id'       => $item['IndRedID'],
                    'approval_code'    => $approval_code,
                    'created_at'       => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                    'updated_at'       => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ];
            }
//            }

        }
        ChamCong::insert($input);
        return $this->responseApi(ResponseStatusCode::OK,'Đẩy chấm công thành công!!');
    }
}
