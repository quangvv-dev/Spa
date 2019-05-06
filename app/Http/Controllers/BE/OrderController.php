<?php

namespace App\Http\Controllers\BE;

use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $service = Services::orderBy('category_id', 'asc')->orderBy('id', 'desc')->get()->pluck('name',
            'id')->prepend('-Chọn-', '');
        view()->share([
            'service' => $service,
        ]);
    }

    public function index()
    {
        $title = 'Tạo đơn hàng';
        return view('order.index', compact('title'));
    }

    public function getInfoService(Request $request)
    {
        $id = $request->id ? $request->id : '';
        if (isset($id) && $id) {
            $data = Services::find($id);
            return $data;
        }
    }
}
