<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Fanpage;
use App\Models\QuickReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SettingChatController extends Controller
{
    public function create($page_id)
    {
        return view('marketing.setting_quick_reply._form',compact('page_id'));
    }
    public function insertSettingChat(Request $request,$page_id){
        $data = $request->all();
        $arr_images = [];
        $dirUploadImage = '/uploads/quick_reply/';
        if($request->input24){
            foreach ($request->input24 as $item){
                $image_name = time() . '-' . $item->getClientOriginalName();
                $arr_images[] = $image_name;
                $item->move(public_path($dirUploadImage), $image_name);
            }
            $data['images'] = json_encode($arr_images);
            $data =  Arr::except($data, ['input24']);
        }
        $data['page_id'] = $page_id;
        $data['user_id'] = Auth::user()->id;
        QuickReply::create($data);
        return redirect('/marketing/setting-quick-reply/'.$page_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $page_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $page_id)
    {
        $docs = QuickReply::when(isset($request->message) ,function ($q) use ($request){
            $q->where('message','like','%'.$request->message.'%');
        })->where('page_id',$page_id)->paginate(StatusCode::PAGINATE_20);
        $fanpage = Fanpage::where('page_id',$page_id)->first();
        $list_fanpage = Fanpage::where('page_id','<>',$page_id)->where('used',1)->get();
        $list_quick_reply = QuickReply::where('page_id',$page_id)->get();
        if($request->ajax()){
            return view('marketing.setting_quick_reply.ajax',compact('docs','page_id'));
        }
        return view('marketing.setting_quick_reply.index',compact('docs','page_id','fanpage','list_fanpage','list_quick_reply'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $docs = QuickReply::find($id);
        return view('marketing.setting_quick_reply._form',compact('docs'));
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
        $item = QuickReply::find($id);
        Functions::checkUploadImage1($request, $item, 'quick_reply');
        $item->images = $request->images;
        $item->shortcut = $request->shortcut;
        $item->message = $request->message;
        $item->save();

        return redirect('/marketing/setting-quick-reply/'.$item->page_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quick = QuickReply::find($id);
        if($quick->images){
            foreach ($quick->images as $item){
                Functions::unlinkUpload2('uploads/quick_reply/'.$item);
            }
        }
        $quick->delete();
        return 1;
    }

    public function test(Request $request){
        $data = $request->all();
        $arr_image = [];
        $user_id = Auth::user()->id;
        if (count($data)){
            foreach ($data as $item){
                if($item['path'] == null){
                    $file['name'] = 'uploads/quick_reply/'.$item['name'];
                    $file['delete_image_server'] = 0;
                    $arr_image[] = $file;
                } else{
                    $file['name'] = 'uploads/tmp/'.$user_id.$item['name'];
                    file_put_contents($file['name'], file_get_contents($item['path']));
                    $file['delete_image_server'] = 1;
                    $arr_image[] = $file;
                }
            }
        }
        return $arr_image;
    }

    public function deleteImage(Request $request){
        $data = $request->all();
        if(count($data)){
            foreach ($data as $item){
                Functions::unlinkUpload2($item['name']);
            }
        }
        return 1;
    }

    public function importExcel(Request $request, $page_id){
        $message = QuickReply::where('page_id',$page_id);
        if ($request->hasFile('file') && ($request->file('file')->getClientMimeType() == Setting::ExcelType || $request->file('file')->getClientMimeType() == Setting::ExcelTypeV2)) {
            Excel::load($request->file('file')->getRealPath(), function ($render) use ($message,$page_id) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    if ($row['message']) {
                        $input = [
                            'shortcut' => $row['shortcut'],
                            'message' => $row['message'],
                            'page_id' => $page_id
                        ];

                        $check_exists = $message->where('message',$row['message'])->first();
                        if (!$check_exists) {
                            QuickReply::create($input);
                        }
                    }
                }

            });
            return redirect()->back()->with('success', 'Tải thành công');
        }
        return redirect()->back()->with('danger', 'File không đúng định dạng *xlsx');
    }

    public function syncQuick(Request $request, $page_id){
        $user = Auth::user();
        if(isset($request->list_quick)){

            if($request->is_add_push == "replace"){
                QuickReply::where('page_id',$request->page_id)->delete();
            }

            $quick = QuickReply::whereIn('id',$request->list_quick)->get();
            foreach ($quick as $item){
                $data['page_id'] = $request->page_id;
                $data['shortcut'] = $item->shortcut;
                $data['message'] = $item->message;
                $data['images'] = $item->images;
                $data['user_id'] = $user->id;

                QuickReply::create($data);
            }
        }
        return back();
    }

    public function getQuickReply($page_id)
    {
        $quickReply = QuickReply::where('page_id',$page_id)->get();
        return response()->json([
            'statusCode' => 200,
            'data' => $quickReply,
        ]);
    }
}
