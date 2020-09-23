<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\StatusCode;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        setting([
            'view_customer_sale' => $request->value,
        ])->save();
        return setting('view_customer_sale');
    }

    public function index()
    {
        return view('settings.index');
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
}
