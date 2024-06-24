<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\ChamCong;
use App\Models\Department;
use App\Models\HistoryImportSalary;
use App\Models\Salary;
use App\Services\FirebaseService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;

class StatisticController extends Controller
{
    protected $firebase;
    protected $database;
    public function __construct(FirebaseService $firebaseService)
    {
        $this->middleware('permission:cham_cong.list', ['only' => ['index']]);
        $this->firebase = $firebaseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!count($request->all())) {
            $request->merge(['branch_id' => 1]);
        }
        $year = $request->year ?: now()->format('Y');

        if ($request->month) {
            $end = Carbon::create($year, $request->month)->endOfMonth()->format('d');
        } else {
            $end = now()->endOfMonth()->format('d');
        }
        $docs = User::select('id', 'full_name', 'approval_code', 'department_id')
            ->when(isset($request->branch_id),function ($q) use ($request){
                $q->where('branch_id',$request->branch_id);
            })->whereNotNull('approval_code')->get()->map(function ($item) use ($end, $year, $request) {
            $approval = [];
            $late = [];
            $early = [];
            for ($i = 1; $i <= $end; $i++) {
                $curentDate = $request->month ? Carbon::create($year, $request->month)->startOfMonth()->addDays($i - 1)->format('Y-m-d')
                    : now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');
                $docs = ChamCong::select('date_time_record')->where('approval_code', $item->approval_code)->whereDate('date_time_record', $curentDate)
                    ->orderBy('date_time_record')->get()->toArray();
                if ($item->approval_code) {
                    if (count($docs) < 2) {
                        $approval[$i] = 0;
                    } else {
                        $startDate = new Carbon($docs[0]['date_time_record']);
                        $latedMax =  new Carbon($startDate->format("Y-m-d") . " 18:30:00");
                        $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
                        if ($endDate > $latedMax) {
                            $diff = round((strtotime($latedMax) - strtotime($startDate)) / 60 / 60, 1);
                        }else{
                            $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
                        }
                        $approval[$i] = $diff > 10.5 ? 1 : abs(round($diff / 10.5, 2));
                        $late[] = (strtotime($startDate->format('H:i')) - strtotime('08:00')) / 60;
                        $early[] = (strtotime('18:30') - strtotime($endDate->format('H:i'))) / 60;
                    }
                } else {
                    $approval[$i] = 0;
                }
            }
            $item->approval = $approval;
            $item->late = $late > 0 ? $late : 0;
            $item->early = $early > 0 ? $early : 0;
            return $item;
        })->filter(function ($fl) {
            if (!empty($fl->approval_code)) {
                return $fl;
            }
        });
        if($request->ajax()){
            return view('cham_cong.statistic.ajax', compact('end', 'docs'));
        }
        $branches = Branch::pluck('name','id')->toArray();
        return view('cham_cong.statistic.index', compact('end', 'docs','branches'));
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
        $abc = DB::table('Settings')->where('setting_key', 2)->first();
        $abc = \GuzzleHttp\json_decode($abc->setting_value);

//        ChamCong::create($input);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDetail(Request $request)
    {
        $user = User::where('id', $request->user_id)->with(['department', 'donTu' => function ($query) use ($request) {
            $query->where('date', Carbon::createFromFormat('d-m-Y',$request['date'])->format('Y-m-d'))->with('reason');
            return $query;
        }, 'chamCong' => function ($query2) use ($request) {
            $query2->whereBetWeen('date_time_record', [
                Functions::createYearMonthDay($request['date']) . ' 00:00:00',
                Functions::createYearMonthDay($request['date']) . ' 23:59:59',
            ])->orderBy('date_time_record');
            return $query2;
            }])->first();
        return $user;
    }

    public function showHistory(Request $request)
    {
        $approval_code = Auth::user()->approval_code?:'HN1';
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $docs = ChamCong::where('approval_code', $approval_code)->whereDate('date_time_record', $date)->get()->toArray();
        if (count($docs) < 2) {
            $startDate = isset($docs[0]) ? new Carbon($docs[0]['date_time_record']) : '';
            $machineStart = isset($docs[0]) && $docs[0]['type'] == StatusConstant::ACTIVE ? '(Đơn)' : '(Máy)';
            $approval = [
                'approval' => 0,
                'time_work' => 0,
                'history_chot' => !empty($startDate) ? ($startDate->format('H:i').$machineStart): '-',
                'time' => !empty($startDate) ? $startDate->format('H:i'): '-',
            ];
        } else {
            $startDate = new Carbon($docs[0]['date_time_record']);
            $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
            $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
            $machineStart = $docs[0]['type'] == StatusConstant::ACTIVE ? '(Đơn)' : '(Máy)';
            $machineEnd = $docs[count($docs) - 1]['type'] == StatusConstant::ACTIVE ? '(Đơn)' : '(Máy)';
            $approval = [
                'approval' => $diff > 9.5 ? 1 : round($diff / 9.5, 2),
                'time_work' => round($diff - 1.5, 2),
                'history_chot' => $startDate->format('H:i') . $machineStart . '<br>' . $endDate->format('H:i') . $machineEnd,
                'time' => $startDate->format('H:i') . ' - ' . $endDate->format('H:i'),
            ];

        }

        return $approval;
    }

    public function history(Request $request)
    {
        $year = isset($request->year)?$request->year:Carbon::now()->format('Y');
        $approval = [];
        $approval_code = Auth::user()->approval_code?:'HN1';

        if($request->month){
            $end = Carbon::create($year, $request->month)->endOfMonth()->format('d');
        } else {
            $end = now()->endOfMonth()->format('d');
        }
        for ($i = 1; $i <= $end; $i++) {
            $curentDate = isset($request->month) ? Carbon::create($year, $request->month)->startOfMonth()->addDays($i - 1)->format('Y-m-d')
                : now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');
            $docs = ChamCong::where('approval_code', $approval_code)->whereDate('date_time_record', $curentDate)->get()->toArray();
            $curentDay = now()->format('d');
            if (count($docs) < 2) {
                $startDate = isset($docs[0]) ? new Carbon($docs[0]['date_time_record']) : '';
                $approval[$i] = [
                    'approval' => 0,
                    'time' => !empty($startDate) ? $startDate->format('H:i') . ' - Không có' : '',
                    'donTu' => '',
                ];
                $approval[$i]['off'] = ($curentDay > $i && $approval[$i]['approval'] == 0) ? 1 : 0;
            } else {
                $startDate = new Carbon($docs[0]['date_time_record']);
                $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
                $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
                $check = $docs[0]['type'] == UserConstant::ACTIVE ? $startDate->format('H:i') : ($docs[count($docs) - 1]['type'] == UserConstant::ACTIVE ? $endDate->format('H:i') : '');
                $approval[$i] = [
                    'approval' => $diff > 9.5 ? 1 : round($diff / 9.5, 2),
                    'time' => $startDate->format('H:i') . ' - ' . $endDate->format('H:i'),
                    'donTu' => $check,
                ];
                $approval[$i]['off'] = ($curentDay > $i && $approval[$i]['approval'] == 0) ? 1 : 0;

            }
        }
        if ($request->ajax()){
            return $approval;
        }
        return view('cham_cong.statistic.history', compact('approval'));
    }

    public function importSalary(Request $request)
    {
        if (!$request->date || !$request->name || !$request->file || !$request->branch_id) {
            return redirect()->back()->with('status', 'Vui lòng điền đủ thông tin');
        }
        $date = explode('-', $request->date);
        $month = $date[0];
        $year = $date[1];

        if ($request->hasFile('file')) {
            $data['name'] = $request->name;
            $data['user_id'] = Auth::id();
            $data['branch_id'] = $request->branch_id;
            $history = HistoryImportSalary::create($data);
            Excel::load($request->file('file')->getRealPath(), function ($render) use ($month, $year, $history) {
                $result = $render->toArray()[0];
                $lastrow = $render->noHeading()->toArray()[0];
                $theFirstRow = $lastrow[0];
                foreach ($result as $k => $row) {
                    if (!$row['ma_nhan_vien']) {
                        break;
                    }
                    $key = $theFirstRow;
                    $value = array_values($row);
                    $input['approval_code'] = $row['ma_nhan_vien'];
                    $input['all_total'] = $row['tong_tien'];
//                    $input['key'] = $theFirstRow;
//                    $input['value'] = array_values($row);
                    $input['data'] = json_encode(['key' => $key, 'value' => $value]);
                    $input['month'] = $month;
                    $input['year'] = $year;
                    $input['history_import_salary_id'] = $history->id;
                    Salary::create($input);
                }
            });


            return redirect()->back()->with('status', 'Tải bảng lương thành công');
        }

        return redirect()->back()->with('status', 'Đã có lỗi xảy ra');
    }

    public function salary(Request $request){
        $month = $request->month ?: date('m');
        $year = $request->year?:date('Y');

        if($request->user_id){
            $user_code = User::find($request->user_id)->code;
        } else {
            $user_code = Auth::user()->code;
        }
        $docs = Salary::where('approval_code',$user_code)->where('month',$month)->where('year',$year)->first();
        if($docs){
            $key = json_decode($docs->data)->key;
            $value = json_decode($docs->data)->value;
        } else {
            $key = [];
            $value = [];
        }
        if($request->ajax()){
            return view('cham_cong.salary.ajax',compact('docs','key','value'));
        }
        return view('cham_cong.salary.index',compact('docs','key','value'));
    }
    public function historyImportSalary(){
        $branches = Branch::select('name','id')->get();
        $docs = HistoryImportSalary::orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
        return view('cham_cong.salary.history',compact('docs','branches'));
    }

    public function detailHistory($id){
        $docs =  Salary::where('history_import_salary_id',$id)->with('historySalary')->get()->map(function ($item){
            $item['key'] = json_decode($item->data)->key;
            $item['value'] = json_decode($item->data)->value;
            return $item;
        });
        return view('cham_cong.salary.detail_history',compact('docs'));
    }

    public function deleteImportSalary($id){
        HistoryImportSalary::find($id)->update(['status'=>0]);
        Salary::where('history_import_salary_id',$id)->delete();
        return 1;
    }

    public function exportDataApproval(Request $request){
        $year = $request->year ?: now()->format('Y');

        if ($request->month) {
            $end = Carbon::create($year, $request->month)->endOfMonth()->format('d');
            $current_month = $request->month;
        } else {
            $end = now()->endOfMonth()->format('d');
            $current_month = date('m');
        }

        $date_start = Functions::createYearMonthDay('01'.'-'.$current_month.'-'.$year) . " 00:00:00";
        $date_end = Functions::createYearMonthDay($end.'-'.$current_month.'-'.$year) . " 23:59:59";
        if($request->branch_id){
            $array_approval_code = User::where('branch_id',$request->branch_id)->whereNotNull('approval_code')->pluck('approval_code')->toArray();
        } else {
            $array_approval_code = [];
        }

        $data = ChamCong::select('id','name_machine','date_time_record','type','approval_code')
            ->when(isset($date_start) && isset($date_end), function ($q) use ($date_start,$date_end) {
                $q->whereBetween('date_time_record', [$date_start,$date_end]);
            })->when(count($array_approval_code),function ($q) use ($array_approval_code){
                $q->whereIn('approval_code',$array_approval_code);
            })->orderBy('approval_code')->orderBy('date_time_record')->get()->map(function ($m){
                $user = User::where('approval_code',$m->approval_code)->first();
                if($user){
                    $m->name_display = $user->name_display;
                    $m->vi_tri = $user->is_leader == 1 ? 'Trưởng phòng' : 'Nhân viên';
                    $department = Department::find($user->department_id);
                    if($department){
                        $m->department_name = $department->name;
                    } else {
                        $m->department_name = '';
                    }
                    $branch = Branch::find($user->branch_id);
                    if($branch){
                        $m->branch_name = $branch->name;
                    } else {
                        $m->branch_name = '';
                    }
                }else {
                    $m->name_display = '';
                    $m->department_name = '';
                    $m->vi_tri = '';
                    $m->branch_name = '';
                }
                $m->date = Functions::dayMonthYear($m->date_time_record);
                $m->time = Functions::getTime($m->date_time_record);
                $m->type = $m->type == 0 ? 'Máy chấm công' : 'Đơn từ';
                return $m;
            });
        Excel::create('Đơn hàng (' . date("d/m/Y") . ')', function ($excel) use ($data){
            $excel->sheet('Sheet 1', function ($sheet)  use ($data){
                $sheet->cell('A1:J1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
                $sheet->row(1, [
                    'Mã',
                    'Mã NV',
                    'Họ tên',
                    'Vị trí',
                    'Phòng ban',
                    'Ngày chốt',
                    'Giờ chốt',
                    'Nguồn',
                    'Mã máy chấm công',
                    'CN'
                ]);
                if(count($data)){
                    $i = 1;
                    foreach ($data as $item){
                        $i++;
                        $sheet->row($i, [
                            $item->approval_code,
                            @$item->user->code,
                            $item->name_display,
                            $item->vi_tri,
                            $item->department_name,
                            $item->date,
                            $item->time,
                            $item->type,
                            $item->name_machine,
                            $item->branch_name
                        ]);
                    }
                }

            });
        })->export('xlsx');
    }

}
