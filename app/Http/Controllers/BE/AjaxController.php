<?php

namespace App\Http\Controllers\BE;

use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;

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

    public function indexPost()
    {
        return view('post.index');
    }

    public function store(Request $request)
    {
        $fileName = $this->imageService->store($request->image, $request->folder);
        return $request->folder . '/' . $fileName;
    }

    public function destroy(Request $request)
    {
        Log::info('AjaxController.delete() ' . $request->url);
        File::delete($request->url);
        return 1;
    }

}
