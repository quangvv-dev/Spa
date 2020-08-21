<?php

namespace App\Http\Controllers\BE;

use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\CustomerPost;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Notification;
use App\Models\Post;
use App\User;
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

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
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
        $post = Post::where('slug', $id)->first();
        return view('post.index', compact('post'));
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
        $post = Post::where('slug', $request->slug)->first();
        $input = $request->except('slug');
        $input['post_id'] = $post->id;
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
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id');
        $campaigns = Campaign::orderByDesc('id')->pluck('name', 'id')->toArray();
        $title = 'Danh sách khách hàng đăng ký form';
        $input = $request->all();
        $docs = CustomerPost::search($input)->paginate(StatusCode::PAGINATE_20);

        if ($request->ajax()) return Response::json(view('post.ajax_customer', compact('docs', 'title'))->render());

        return view('post.indexCustomer', compact('title', 'docs', 'campaigns', 'telesales', 'status'));
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
    }

    public function exportCustomer(Request $request)
    {
        $input = $request->all();
        $campaign = $input['campaign'] ?: 'Tất cả chiến dịch';
        $data = CustomerPost::search($input)->get();
        Excel::create('Khách hàng ' . $campaign, function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:Q1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'STT',
                    'Tên khách hàng',
                    'Số điện thoại',
                    'Tư vấn thêm',
                    'Trạng thái'
                ]);
                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$i,
                            @$ex->full_name,
                            @$ex->phone,
                            @$ex->note,
                            (@$ex->status == 0) ? 'Chưa gọi' : ($ex->status == 1 ? 'Đã gọi' : 'Đã đến'),
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }


}
