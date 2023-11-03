<?php

namespace App\Http\Controllers\BE\Personal;

use App\Components\Filesystem\Filesystem;
use App\Constants\DirectoryConstant;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\LeaveReason;
use App\Models\PersonalImage;
use App\Models\Salary;
use App\Models\Status;
use App\Models\UserPersonal;
use App\Services\UserPersonalService;
use App\Services\UserService;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    public function __construct(UserService $userService, UserPersonalService $personalService, Filesystem $fileUpload)
    {
        $this->users = $userService;
        $this->personal = $personalService;
        $this->fileUpload = $fileUpload;
    }

    public function salary(Request $request, User $user)
    {
        $month = $request->month ?: date('m');
        $year = $request->year ?: date('Y');
        $docs = Salary::where('approval_code', $user->code)->where('month', $month)->where('year', $year)->first();
        if ($docs) {
            $key = json_decode($docs->data)->key;
            $value = json_decode($docs->data)->value;
        } else {
            $key = [];
            $value = [];
        }
        if ($request->ajax()) {
            return view('users.include._form-salary', compact('docs', 'key', 'value', 'user'));
        }
        return view('users.include.salary-index', compact('docs', 'key', 'value', 'user'));
    }

    public function index(User $user)
    {
        $leave_reason = LeaveReason::select('id', 'name')->get();
        $positions = isset($user->department->position) ? $user->department->position : [];
        return view('users.include._personal', compact('user', 'positions', 'leave_reason'));
    }

    public function store(Request $request, User $user)
    {
        $params = $this->personal->compareData($request->except('_token'));
        if (isset($user->personal)) {
            $user->personal()->delete();
        }
        $user->personal()->create($params);
        return back();
    }

    public function image(User $user)
    {
        $labels = PersonalImage::NAME_LABEL;
        return view('users.include.image', compact('labels', 'user'));
    }

    public function storeImage(Request $request, User $user)
    {
        $user->personal_image()->create([
            'name'      => PersonalImage::CCCD_FRONT,
            'link'      => null,
            'type_file' => 'jpeg',
        ]);
        return back();
    }

    public function updateImage(Request $request, PersonalImage $image)
    {
        if ($request->hasFile('file_image')) {
            $request->merge(['type_file' => $request->file_image->getMimeType()]);
            $link = $this->fileUpload->uploadImageCustom($request->file_image, DirectoryConstant::PERSONAL_IMAGE);
            if (!empty($image->link)) {
                Functions::unlinkUpload2($image->link);
            }
            $request->merge(['link' => $link]);

        }
        $image->update($request->except('_token', 'file_image'));
        return back();
    }

    public function destroyImage(PersonalImage $image)
    {
        if (!empty($image->link)) {
            Functions::unlinkUpload2($image->link);
        }
        $image->delete();
        return 1;
    }

    public function statistics(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
//        $chart = $this->personal->chart($request->all());
        $chart = LeaveReason::select('name')->get();
        $users = User::search($request->all());
        $users2 = clone $users;
        $users3 = clone $users;
        $statistics = [
            'all'    => $users->count(),
            'active' => $users2->where('active', UserConstant::ACTIVE)->count(),
            'pause' => $users3->whereHas('personal', function ($qr) {
                $qr->whereNotNull('pause_time');
            })->count(),
        ];
        return view('statistics.personal.index', compact('statistics', 'chart'));
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {

                    if (!empty($row['ma_nv'])) {
                        $user = User::where('code', $row['ma_nv'])->first();
                        if (empty($user)) {
                            continue;
                        }
                        $user->personal()->delete();
                        $user->personal()->create([
                            'cccd'             => $row['so_cccd'],
                            'note'             => $row['gia_canh'],
                            'insurance_number' => $row['so_bhxh'],
                            'start_probation'  => !empty($row['ngay_bd_thu_viec']) ? Carbon::parse(trim($row['ngay_bd_thu_viec']))->format('Y-m-d') : null,
                            'start_work'       => !empty($row['ngay_lam_viec_chinh_thuc']) ? Carbon::parse(trim($row['ngay_lam_viec_chinh_thuc']))->format('Y-m-d') : null,
                            'insurance_time'   => !empty($row['ngay_bd_dong_bhxh']) ? Carbon::parse(trim($row['ngay_bd_dong_bhxh']))->format('Y-m-d') : null,
                            'leave_time'       => !empty($row['ngay_nghi_viec']) ? Carbon::parse(trim($row['ngay_nghi_viec']))->format('Y-m-d') : null,
                            'birthday'         => !empty($row['ngay_sinh']) ? Carbon::parse(trim($row['ngay_sinh']))->format('Y-m-d') : null,
                            'pause_time'       => !empty($row['ngay_tam_nghi']) ? Carbon::parse(trim($row['ngay_tam_nghi']))->format('Y-m-d') : null,
                        ]);
                    }
                }
            });
        }
        return back()->with('status', 'Cập nhật excel thành công');
    }
}
