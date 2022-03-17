<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\StatusConstant;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Source;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LandipageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:source.list', ['only' => ['index']]);
        $this->middleware('permission:source.edit', ['only' => ['update']]);
        $this->middleware('permission:source.add', ['only' => ['store']]);
        $this->middleware('permission:source.delete', ['only' => ['destroy']]);
        $this->middleware('permission:source.update', ['only' => ['updateAcceptSource']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->all();

        $search['searchType'] = StatusConstant::TYPE_CONNECT_LADIPAGE;
        $sources = Source::search($search)->paginate(20);

        $categories = Category::pluck('name','id');
        $sales = User::where('department_id',2)->pluck('full_name','id');
        $branch_ids = Branch::pluck('name','id');
        $marketings = User::where('department_id',3)->pluck('full_name','id')->prepend('', '');

        if ($request->ajax()) {
            return view('marketing.source_landipage.ajax',compact('sources'));

        }
        return view('marketing.source_landipage.index',compact('marketings','categories','sources','sales','branch_ids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
//        $select_tat_ca_sale = "0";
//        if (in_array($select_tat_ca_sale, $request->sale_id)) {
//            $search['user_active'] = DepartmentConstant::USER_ACTIVE;
//            $search['department_id'] = DepartmentConstant::SALE;
//            $data['sale_id'] = User::search($search)->pluck('id')->map(function ($m) {
//                return (string)$m;
//            });
//        } else {
//            $data['sale_id'] = json_encode($request->sale_id);
//        }
        $data['sale_id'] = json_encode($request->sale_id);
        $data['mkt_id'] = Auth::user()->id;
        $data['category_id'] = json_encode($request->category_id);
        $data['type'] = StatusConstant::TYPE_CONNECT_LADIPAGE;

        $source = Source::create($data);
        $link = url('/api/Contact/ReceiveData/sc/' . $source->id);
        $source->update(['form_html' => $link]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $source = Source::find($id);
        $data['name'] = $request->name;
        if($request->category_id){
            $data['category_id'] = json_encode($request->category_id);
        }
        if($request->sale_id){
            $data['sale_id'] = json_encode($request->sale_id);
        }
        $source->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('source_fb',$id)->first();
        if ($customer){
            return 0;
        }

        $source = Source::find($id);
        if ($source->accept == 1) {
            $message = 'Source đã được sử dụng không được xóa';
        } else {
            $source->delete();
            $message = 'Đã xóa thành công !';
        }
        return response()->json([
            'message' => $message
        ]);
    }

    public function updateAcceptSource(Request $request)
    {
        $data['accept'] = $request->value == 'true' ? 1 : 0;
        Source::find($request->id)->update($data);

        return response()->json([
            'statusCode' => true,
        ]);
    }
}
