<?php

namespace App\Http\Controllers\BE\Personal;

use App\Components\Filesystem\Filesystem;
use App\Constants\DirectoryConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\LeaveReason;
use App\Models\PersonalImage;
use App\Models\Salary;
use App\Services\UserPersonalService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;

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
            'name' => PersonalImage::CCCD_FRONT,
            'link' => null,
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
        $data = User::get();

        return view('statistics.personal.index');
    }
}
