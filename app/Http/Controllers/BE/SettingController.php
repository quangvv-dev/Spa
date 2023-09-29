<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\BankContants;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Location;
use App\Models\PaymentBank;
use App\Models\Status;
use App\Models\UserFilterGrid;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    private $fileUpload;

    public function __construct(Filesystem $fileUpload)
    {
        $this->middleware('permission:settings', ['only' => ['index']]);

        $this->fileUpload = $fileUpload;
    }

    public function store(Request $request)
    {
        setting(['view_customer_sale' => $request->value])->save();
        return setting('view_customer_sale');
    }

    public function index()
    {
        $branchs = Branch::get();
        $location = Location::pluck('name', 'id')->toArray();
        $locations = Location::all();
        $banks = PaymentBank::all();
        $banks_code = BankContants::bank;
        return view('settings.index', compact('branchs', 'location', 'locations', 'banks', 'banks_code'));
    }

    public function storeBranch()
    {
        Branch::create([
            'name' => 'Chi Nhánh',
            'location_id' => StatusCode::CUM_MIEN_BAC,
        ]);
    }

    public function storeBank()
    {
        PaymentBank::create([
            'bank_code' => 'ICB',
            'account_number' => '110',
            'account_name' => 'NGUYEN VAN A',
            'branch_id' => '1',
        ]);
    }

    public function deleteBank(PaymentBank $bank)
    {
        $bank->delete();
        return 1;
    }

    public function updateBranch(Request $request, Branch $id)
    {
        $branch = $id;
        $input = $request->all();
        $branch->update($input);
        return 1;
    }

    public function updateBank(Request $request, PaymentBank $bank)
    {
        $input = $request->all();
        $bank->update($input);
        return 1;
    }


    public function indexAdmin()
    {
        return view('super_admin.index');
    }

    /**
     * update data hệ thống
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRank(Request $request)
    {
        $input = $request->except('_token');
        if (count($input)) {
            foreach ($input as $key => $item) {
                $item = $item ? str_replace(',', '', $item) : 0;
                setting([$key => $item,])->save();
            }
        };
        return back()->with('success', 'Đã cập nhật thông tin thành công !!!');
    }

    /**
     * update data hệ thống
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        $input = $request->except('_token');
        $input['accept_duplicate_phone'] = $input['accept_duplicate_phone'] ?? 'off';
        if ($request->hasFile('logo_website')) {
            $input['logo_website'] = $this->fileUpload->uploadUserImage($input['logo_website']);
        }
        if (count($input)) {
            foreach ($input as $key => $item) {
                setting([$key => $item])->save();
            }
        }
        return back()->with('success', 'Đã cập nhật thông tin thành công !!!');
    }

    public function destroy(Branch $id)
    {
        $branch = $id;
        $customer = Customer::where('branch_id', $branch->id)->first();
        if (isset($customer) && $customer) {
            return 0;
        } else {
            $branch->delete();
            return 1;
        }
    }

    public function phanbo()
    {
        $branchs = Branch::search()->pluck('name', 'id');// chi nhánh
        $telesales = User::whereIn('role', [UserConstant::TELESALES, UserConstant::TP_SALE])->pluck('full_name', 'id');
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        return view('settings.phanbo', compact('branchs', 'telesales', 'status'));

    }

    public function postPhanBo(Request $request)
    {
        $customers = Customer::select('id')->where('branch_id', $request->branch_id)
            ->whereIn('status_id', $request->status_id)
            ->when(isset($request->start_date), function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($request->start_date) . " 00:00:00",
                    Functions::yearMonthDay($request->end_date) . " 23:59:59",
                ]);
            })->pluck('id')->toArray();
        $telesale = $request->telesales_id;
        $key = count($request->telesales_id);
        $number_key = (int)round(count($customers) / $key);

        for ($i = 1; $i <= $key; $i++) {
            $bd = 0;
            if ($i > 1) {
                $bd = $number_key * ($i - 1);
            }
            $arr = array_slice($customers, $bd, $number_key);

            Customer::whereIn('id', $arr)->update(['telesales_id' => $telesale[$i - 1]]);
        }

        return back()->with('status', 'Đã cập nhật thông tin khách hàng thành công !!!');

    }

    public function storeLocation(Request $request)
    {
        Location::create(['name' => 'Tên cụm']);
        return 1;
    }

    public function updateLocation(Request $request, $id)
    {
        Location::find($id)->update($request->all());
        return 1;
    }

    public function deleteLocation($id)
    {
        if ($id <= 3) {
            return 0;
        } else {
            Location::find($id)->delete();
            return 1;
        }
    }

    public function userFilterGrid(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['user_id'] = $user->id;
        $user_filter = UserFilterGrid::where('user_id', $user->id)->where('url', $request->url)->first();
        if ($user_filter) {
            $user_filter->update($data);
        } else {
            UserFilterGrid::create($data);
        }

        return 1;
    }
}
