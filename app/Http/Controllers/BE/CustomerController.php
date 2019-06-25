<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Status;
use App\Services\CustomerService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Excel;

class CustomerController extends Controller
{
    private $customerService;

    /**
     * UserController constructor.
     *
     * @param Filesystem $fileUpload
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $branch = Status::where('type', StatusCode::BRANCH)->pluck('name', 'id')->toArray();// chi nhánh
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        view()->share([
            'status'         => $status,
            'group'          => $group,
            'source'         => $source,
            'branch'         => $branch,
            'telesales'      => $telesales,
            'marketingUsers' => $marketingUsers,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $statuses = Status::get();
        $title = 'Danh sách khách hàng';
        $customers = Customer::search($request);

        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('customers', 'statuses', 'title'))->render());
        }

        return view('customers.index', compact('customers', 'statuses', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới khách hàng';
        return view('customers._form', compact('title'));
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
        $input = $request->all();
        $input['mkt_id'] = $request->mkt_id;

        $this->customerService->create($input);

        return redirect('customers')->with('status', 'Tạo người dùng thành công');
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
    public function edit(User $customer)
    {
        $user['birthday'] = Functions::dayMonthYear($customer->birthday);
        $title = 'Sửa khách hàng';
        return view('customers._form', compact('customer', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {
        $input = $request->except('image');
        @$date = Functions::yearMonthDay($request->birthday);
        $input['birthday'] = isset($date) && $date ? $date : '';
        $input['password'] = bcrypt($request->password);
        $input['telesales_id'] = $request->telesales_id;
//        dd($input['telesales_id']);

//        if ($request->image) {
//            $input['avatar'] = $this->fileUpload->uploadUserImage($request->image);
//        }
        $customer->update($input);

        return redirect(route('customers.index'))->with('status', 'Cập nhật khách hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $customer)
    {
        $customer->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }

    public function checkUniquePhone(Request $request)
    {
        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer)
            return false;

        return true;
    }

    public function exportCustomer()
    {
        $now = Carbon::now()->format('d/m/Y');
        $data = Customer::orderBy('id', 'desc')->with('orders');
        //        $rq = $request->all();
//        if ($rq['search']) {
//            $data = $data->where('name', 'like', '%' . $rq['search'] . '%')
//                ->orWhere('email', 'like', '%' . $rq['search'] . '%')
//                ->orWhere('phone', 'like', '%' . $rq['search'] . '%');
//        }
        $data = $data->get();
        Excel::create('Khách hàng (' . $now . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:Q1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'ID',
                    'Tên khách hàng',
                    'Mã khách hàng',
                    'Số điện thoại',
                    'Sinh nhật',
                    'Giới tính',
                    'Link Facebook',
                    'Địa chỉ',
                    'Ngày tạo',
                    'Số đơn',
                    'Tổng doanh thu',
                    'ID người phụ trách',
                    'ID người tư vấn',
                    'ID nhóm KH',
                    'ID nguồn KH',
                    'ID Mối quan hệ',
                    'Mô tả',
                ]);
                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$ex->id,
                            @$ex->full_name,
                            @$ex->account_code,
                            @$ex->phone,
                            @$ex->birthday,
                            @$ex->GenderText,
                            @$ex->facebook,
                            @$ex->address,
                            @$ex->created_at,
                            @$ex->orders->count(),
                            @(int)$ex->orders->sum('all_total'),
                            @$ex->marketing->full_name,
                            @$ex->telesale->full_name,
                            @$ex->category->name,
                            @$ex->source_customer->name,
                            @$ex->status->name,
                            @$ex->description,
                            // (@$ex->type == 0) ? 'Tài khoản thường' : 'Tài khoản VIP',
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }

    public function importCustomer(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    User::create([
                        'full_name'    => $row['name'],
                        'account_code' => \bcrypt('123456'),
                        'email'        => $row['email'],
                        'phone'        => $row['sdt'],
                        'birthday'     => 1,
                        'gender'       => $row['type'] == 'Tài khoản VIP' ? 1 : 0,
                        'address'      => $row['address'],
                        'facebook'     => $row['birth_day'],
                        'created_at'   => Carbon::now()->format('Y-m-d H:s'),
                        'updated_at'   => $row['birth_day'],
                        'description'  => $row['gioi_tinh'] == 'Nam' ? 0 : 1,
                    ]);
                }
            });
        }
        return redirect('admin/customers');
    }
}
