<?php

namespace App\Http\Controllers\API\ChamCong;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Http\Controllers\API\BaseApiController;
use App\Models\ChamCong;
use App\Models\Salary;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChamCongController extends BaseApiController
{
    public function store(Request $request)
    {
//        $data = "{\"NameMachine\":\"HN1\",\"Info\":[{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 1:58:07 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:11 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:19 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/7\/2023 8:54:42 AM\",\"IndRedID\":\"1\"}]}";
        \DB::table('settings')->insert(['setting_key' => 'chamcong', 'setting_value' => json_encode($request->all())]);
        $data = $request->all();
        $input = [];
        $array_approval_code = User::select('approval_code')->whereNotNull('approval_code')->pluck('approval_code')->toArray();
        foreach ($data['Info'] as $item) {
            if (str_contains($item['DateTimeRecord'], 'SA') || str_contains($item['DateTimeRecord'], 'CH')) {
                $date = str_replace('SA', 'AM', $item['DateTimeRecord']);
                $date = str_replace('CH', 'PM', $date);
                $date = date_create_from_format('d/m/Y g:i:s A', $date)->format('Y-m-d H:i:s');
            }elseif (str_contains($item['DateTimeRecord'], 'AM') || str_contains($item['DateTimeRecord'], 'PM')) {
                $date = date_create_from_format('d/m/Y g:i:s A', $item['DateTimeRecord'])->format('Y-m-d H:i:s');
            } else {
                $date = Carbon::parse($item['DateTimeRecord'])->format('Y-m-d H:i:s');
            }
            $isset = ChamCong::where('name_machine', $data['NameMachine'])->where('ind_red_id', $item['IndRedID'])
                ->where('date_time_record', $date)->first();
            $approval_code = $data['NameMachine'] . '.' . $item['IndRedID'];

            if (in_array($approval_code, array_values($array_approval_code))) {
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
            }
        }
        ChamCong::insert($input);
        return $this->responseApi(ResponseStatusCode::OK, 'Đẩy chấm công thành công!!');
    }

    public function salary(Request $request)
    {
        $month = $request->month ?: date('m');
        $year = $request->year ?: date('Y');
        $user = $request->jwtUser;
        if ($user->approval_code) {
            $approval_code = $user->approval_code;
        } else {
            $approval_code = User::find($user->id)->approval_code;
        }
        $docs = Salary::where('approval_code', $approval_code)->where('month', $month)->where('year', $year)->first();
        if ($docs) {
            $data = [
                'title' => json_decode($docs->data)->key,
                'value' => json_decode($docs->data)->value,
            ];
        } else {
            $data = [
                'title' => [],
                'value' => [],
            ];
        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function history(Request $request)
    {
        $user = $request->jwtUser;
        if ($user->approval_code) {
            $approval_code = $user->approval_code;
        } else {
            $approval_code = User::find($user->id)->approval_code;
        }
        $year = isset($request->year) ? $request->year : Carbon::now()->format('Y');
        $approval = [];
        $approval_code = $approval_code ?: 'HN1';
        if ($request->month) {
            $end = Carbon::create($year, $request->month)->endOfMonth()->format('d');
        } else {
            $end = now()->endOfMonth()->format('d');
        }
        $curentMonth = $request->month < 10 ? '0' . $request->month : $request->month;
        for ($i = 1; $i <= $end; $i++) {
            $curentDate = isset($request->month) ? Carbon::create($year,
                $request->month)->startOfMonth()->addDays($i - 1)->format('Y-m-d')
                : now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');
            $docs = ChamCong::where('approval_code', $approval_code)->whereDate('date_time_record',
                $curentDate)->get()->toArray();
            if (count($docs) < 2) {
                $startDate = isset($docs[0]) ? new Carbon($docs[0]['date_time_record']) : '';
                $approval[] = [
                    'day'      => $i,
                    'approval' => 0,
                    'time'     => !empty($startDate) ? $startDate->format('H:i') . ' - Không có' : '',
                    'donTu'    => '',
                    'late'    => 0,
                    'early'    => 0,
                    'full_day' => $year . '-' . $curentMonth . '-' . ($i < 10 ? '0' . $i : $i),
                ];
            } else {
                $startDate = new Carbon($docs[0]['date_time_record']);
                $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
                $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
                $check = $docs[0]['type'] == UserConstant::ACTIVE ? 'in' : ($docs[count($docs) - 1]['type'] == UserConstant::ACTIVE ? 'out' : '');
                $late = (strtotime($startDate->format('H:i')) - strtotime('08:00')) / 60;
                $early = (strtotime('17:30') - strtotime($endDate->format('H:i'))) / 60;

                $approval[] = [
                    'day'      => $i,
                    'approval' => $diff > 9.5 ? 1 : round($diff / 9.5, 2),
                    'time'     => $startDate->format('H:i') . ' - ' . $endDate->format('H:i'),
                    'donTu'    => $check,
                    'late'  => $late > 0 ? $late : 0,
                    'early' => $early > 0 ? $early : 0,
                    'full_day' => $year . '-' . $curentMonth . '-' . ($i < 10 ? '0' . $i : $i),
                ];
            }
        }
        $total = collect($approval);
        $data = [
            'total'  => [
                'approval' => $total->sum('approval'),
                'early'    => $total->sum('early'),
                'late'     => $total->sum('late'),
            ],
            'record' => $approval,
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function showHistory(Request $request)
    {
        $user = $request->jwtUser;
        if ($user->approval_code) {
            $approval_code = $user->approval_code;
        } else {
            $approval_code = User::find($user->id)->approval_code;
        }
//        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $docs = ChamCong::where('approval_code', $approval_code)->whereDate('date_time_record',
            $request->date)->get()->toArray();
        if (count($docs) < 2) {
            $startDate = isset($docs[0]) ? new Carbon($docs[0]['date_time_record']) : '';
            $machineStart = isset($docs[0]) && $docs[0]['type'] == StatusConstant::ACTIVE ? 'in' : '';
            $approval = [
                'approval'     => 0,
                'time_work'    => 0,
                'history_chot' => !empty($startDate) ? ($startDate->format('H:i') . $machineStart) : '-',
                'time'         => !empty($startDate) ? $startDate->format('H:i') : '-',
            ];
        } else {
            $startDate = new Carbon($docs[0]['date_time_record']);
            $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
            $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
            $machineStart = $docs[0]['type'] == StatusConstant::ACTIVE ? '(Đơn)' : '(Máy)';
            $machineEnd = $docs[count($docs) - 1]['type'] == StatusConstant::ACTIVE ? '(Đơn)' : '(Máy)';
            $approval = [
                'approval'     => $diff > 9.5 ? 1 : round($diff / 9.5, 2),
                'time_work'    => round($diff - 1.5, 2),
                'history_chot' => $startDate->format('H:i') . $machineStart . ' - ' . $endDate->format('H:i') . $machineEnd,
                'time'         => $startDate->format('H:i') . ' - ' . $endDate->format('H:i'),
            ];
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $approval);
    }

}
