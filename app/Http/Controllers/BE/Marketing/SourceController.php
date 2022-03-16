<?php

namespace App\Http\Controllers\BE\Marketing;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->all();
        $search['searchType'] = StatusConstant::TYPE_CONNECT_FACEBOOK;
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
//        dd($data);
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
        $customer = Customer::where('source_id',$id)->first();
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
        $user = Auth::user();
        $data['accept'] = $request->value == 'true' ? 1 : 0;
        $id = $request->id;
        if ($user->department_id == UserConstant::ADMIN) {
            Source::find($id)->update($data);
            $status_code = true;
        } else {
            $status_code = false;
        }
        return response()->json([
            'statusCode' => $status_code,
        ]);
    }
}
