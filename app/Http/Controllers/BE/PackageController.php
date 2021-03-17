<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\PackageWallet;
use App\Services\PackageService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PackageController extends Controller
{
    private $walletService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(PackageService $walletService)
    {

        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $title = "Quản lý gói nạp";
        $docs = PackageWallet::search($input)->paginate(StatusCode::PAGINATE_10);

        if ($request->ajax()) {
//            dd($docs);
            return Response::json(view('package.ajax', compact('docs', 'title'))->render());
        }

        return view('package.index', compact('docs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới gói nạp';
        return view('package._form', compact('title'));
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
        $input['price'] = $request->price ? str_replace(',', '', $request->price) : 0;
        $input['order_price'] = $request->order_price ? str_replace(',', '', $request->order_price) : 0;

        $this->walletService->create($input);
        return redirect(route('package.index'))->with('status', 'Thêm mới gói thành công');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doc = $this->walletService->find($id);
        $title = 'Cập nhật gói nạp';

        return view('package._form', compact('doc', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $input['price'] = $request->price ? str_replace(',', '', $request->price) : 0;
        $input['order_price'] = $request->order_price ? str_replace(',', '', $request->order_price) : 0;

        $this->walletService->update($input, $id);

        return redirect(route('package.index'))->with('status', 'Cập nhật gói thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->walletService->delete($id);
        return 1;
    }
}
