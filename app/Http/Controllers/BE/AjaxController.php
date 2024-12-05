<?php

namespace App\Http\Controllers\BE;

use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\CustomerPost;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Landipage;
use App\Models\Notification;
use App\Models\OrderDetail;
use App\Models\Post;
use App\Models\Role;
use App\Models\Services;
use App\Models\Status;
use App\Models\Category;
use App\User;
use App\Services\CustomerService;
use App\Constants\UserConstant;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;
use Illuminate\Support\Facades\Response;
use Excel;


class AjaxController extends Controller
{

    private $imageService;
    private $customerService;

    public function __construct(ImageService $imageService, CustomerService $customerService)
    {
        $this->middleware('permission:post.customer', ['only' => ['ListCustomerPost']]);

        $this->imageService = $imageService;
        $this->customerService = $customerService;
    }

    /**
     * Đếm số thông báo chưa đọc
     *
     * @param Request $request
     * @return mixed
     */
    public function countNotification(Request $request)
    {
        $data = Notification::where('user_id', $request->user_id)->where('status', NotificationConstant::UNREAD)->count();
        return $data;
    }

    /**
     * Danh sách thông báo ra modal
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNotification(Request $request)
    {
        $data = Notification::where('user_id', $request->user_id)->where('status', '<>', NotificationConstant::HIDDEN)
            ->orderByDesc('created_at')->take(StatusCode::PAGINATE_10)->get();
        return response($data);
    }

    /**
     * Update trạng thái đã đọc trên notification
     *
     * @param $id
     * @return int
     */
    public function updateNotification($id)
    {
        $data = Notification::findOrFail($id);
        $data->update(['status' => NotificationConstant::READ]);
        return 1;
    }

    /**
     * Danh sách thông báo ra view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNotificationOutView(Request $request)
    {
        $docs = Notification::where('user_id', Auth::user()->id)->where('status', '<>', NotificationConstant::HIDDEN)
            ->orderByDesc('created_at')->paginate(StatusCode::PAGINATE_10);
        return view('notifications.index', compact('docs'));
    }

    /**
     * Display post FrontEnd
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPost($id)
    {
        $post = Landipage::where('slug', $id)->first();
        if (empty($post)) abort(404);
        return view('landipage.index', compact('post'));
    }

    /**
     * Store img summerNote
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $fileName = $this->imageService->store($request->image, $request->folder);
        return $request->folder . '/' . $fileName;
    }

    /**
     * delete img summerNote
     *
     * @param Request $request
     * @return int
     */
    public function destroy(Request $request)
    {
        Log::info('AjaxController.delete() ' . $request->url);
        File::delete($request->url);
        return 1;
    }

    /**
     * create Customer Post FE
     *
     * @param Request $request
     * @return string
     */
    public function storeCustomerPost(Request $request)
    {
        $post = Post::find($request->id);
        $input = $request->except('slug');
        $customer = Customer::where('phone', $input['phone'])->first();
        if (isset($customer) && $customer) {
            $input['telesales_id'] = $customer->telesales_id;
        } else {
            $new_position = 0;
            if ($post->position < count($post->sale_id) - 1 && count($post->sale_id) > 1) {
                $new_position = $post->position + 1;
            }
            $post->position = $new_position;
            $post->save();
            $input['telesales_id'] = $post->sale_id[$post->position];
        }
        $input['post_id'] = $post->id;
        $input['group'] = $post->group;
        $input['branch_id'] = $post->branch_id ?: 0;
        CustomerPost::create($input);
        return 'Đăng ký thành công';
    }

    /**
     * Danh  sach KH nhan form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function ListCustomerPost(Request $request)
    {
        $status = [0 => "Chưa gọi", 1 => "Đã gọi", 2 => "Đã đến"];
        $telesales = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->pluck('full_name', 'id');
        $posts = Post::orderByDesc('id')->pluck('title', 'id')->toArray();
        $title = 'Danh sách khách hàng đăng ký form';
        $input = $request->all();
        $docs = CustomerPost::search($input)->paginate(StatusCode::PAGINATE_20);

        if ($request->ajax()) return Response::json(view('post.ajax_customer', compact('docs', 'title'))->render());

        return view('post.indexCustomer', compact('title', 'docs', 'posts', 'telesales', 'status'));
    }

    public function updateCustomerPost(Request $request)
    {
        $data = CustomerPost::whereIn('id', $request->ids);
        if (isset($request->telesales_id)) {
            $data->update([
                'telesales_id' => (int)$request->telesales_id,
            ]);
        }

        if (isset($request->status)) {
            $data->update([
                'status' => (int)$request->status,
            ]);
        }

        if (count($request->ids) == 1) {
            $data = $data->first()->telesales->full_name;
            return \response($data);
        }
    }

    public function findCustomerPost(Request $request)
    {
        $data = CustomerPost::find($request->id);
        $telesales = User::select('full_name', 'id')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get();

        $response = [
            'customer' => $data,
            'data' => $telesales,
        ];
        return \response($response);
    }

    /**
     * Chuyen data sang customer
     *
     * @param Request $request
     * @return int
     */
    public function convertCustomerPost(Request $request)
    {
        $data = CustomerPost::whereIn('id', $request->ids)->doesntHave('customer')->get();
        $status = Status::where('code', 'like', '%optin_form%')->first();
        $moi = Status::where('code', 'moi')->first();
        if (count($data)) {
            foreach ($data as $item) {
                $input = [
                    'phone' => $item->phone,
                    'full_name' => $item->full_name,
                    'telesales_id' => $item->telesales_id,
                    'mkt_id' => Auth::user()->id,
                    'source_id' => isset($status) && $status ? $status->id : 0,
                    'status_id' => $moi->id,
                    'gender' => 0,
                    'fb_name' => $item->full_name,
                    'branch_id' => $item->branch_id,
                ];
                $customer = $this->customerService->create($input);
                $this->customerService->update_code($customer);
                $category = Category::find($item->group);
                $customer->categories()->attach($category);
                CustomerPost::where('id', $item->id)->delete();
            }
        }
        return 1;
    }

    /**
     * Export customer post
     *
     * @param Request $request
     */
    public function exportCustomer(Request $request)
    {
        $input = $request->all();
        $campaign = $input['campaign'] ?: 'Tất cả form';
        $data = CustomerPost::search($input)->get();
        Excel::create($campaign, function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:G1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'STT',
                    'Tên khách hàng',
                    'Số điện thoại',
                    'Tư vấn thêm',
                    'Người phụ trách',
                    'Trạng thái',
                    'Từ Optin form'
                ]);
                $i = 0;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$i,
                            @$ex->full_name,
                            @$ex->phone,
                            @$ex->note,
                            @$ex->telesales->full_name,
                            (@$ex->status == 0) ? 'Chưa gọi' : ($ex->status == 1 ? 'Đã gọi' : 'Đã đến'),
                            @$ex->post->title
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }

    public function getServiceWithOrder($id)
    {
        $array = OrderDetail::select('booking_id')->where('order_id', $id)->pluck('booking_id')->toArray();
        return Services::whereIn('id', $array)->withTrashed()->get();
    }

    /**
     * Lấy quyền từ phòng ban.
     *
     * @param $id
     * @return array
     */
    public function getRoleWithDepartment($id)
    {
        $data = Role::where('department_id', $id)->get();
        return response()->json($data);
    }

}
