<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\SocialConstant;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Services;
use App\Models\Source;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SourceController extends Controller
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
        $search['searchType'] = StatusConstant::TYPE_CONNECT_FACEBOOK;

        $user = Auth::user();

        if(!$user->permission('source.update')){
            $search['searchUser'] = $user->id;
        }
        $sources = Source::search($search)->paginate(20);

        $categories = Category::pluck('name','id');
        $sales = User::where('department_id',2)->pluck('full_name','id');
        $branch_ids = Branch::pluck('name','id');
        $marketings = User::where('department_id',3)->pluck('full_name','id')->prepend('', '');
        if($request->ajax()){
            return view('marketing.source_fb.ajax',compact('sources'));
        }
        return view('marketing.source_fb.index', compact('sources','sales','marketings','categories','branch_ids'));
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['name'] = $request->name;
        if($request->category_id){
            $data['category_id'] = json_encode($request->category_id);
        }
        if($request->sale_id){
            $data['sale_id'] = json_encode($request->sale_id);
        }
        $data['branch_id'] = $request->branch_id;
        $data['mkt_id'] = Auth::user()->id;
        $data['chanel'] = SocialConstant::FACEBOOK_ADS;
        Source::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('source_fb',$id)->first();
        if ($customer){
            return 0;
        }

        $user = Auth::user();
        $source = Source::find($id);
        if ($source->accept == 1) {
            $message = 'Source đã được sử dụng không được xóa';
        } else {
            if($user->id == $source->mkt_id){
                $source->delete();
                $message = 'Đã xóa thành công !';
            } else {
                $message = 'Bạn không có quyền xoá !';
            }
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
