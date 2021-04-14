<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Components\Filesystem\Filesystem;
use App\Models\Branch;
use Illuminate\Http\Request;


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
        return view('settings.index', compact('branchs'));
    }

    public function storeBranch()
    {
        Branch::create([
            'name' => 'Chi Nhánh',
        ]);
    }

    public function updateBranch(Request $request, Branch $id)
    {
        $branch = $id;
        $input = $request->all();
        $branch->update($input);
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
        if ($request->hasFile('logo_website')) {
            $input['logo_website'] = $this->fileUpload->uploadUserImage($input['logo_website']);
        }
        if (count($input)) {
            foreach ($input as $key => $item) {
                setting([$key => $item])->save();
            }
        };
        return back()->with('success', 'Đã cập nhật thông tin thành công !!!');
    }
}
