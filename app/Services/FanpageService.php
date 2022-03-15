<?php
namespace App\Services;

use App\Helpers\Functions;
use App\Models\Fanpage;
use Illuminate\Support\Facades\Auth;

class FanpageService
{
    public function index($request)
    {
        $user_id = Auth::user()->id;

        $token = $request->session()->has('login-facebook1') ? $request->session()->get('login-facebook1')->token : null;
        $method = 'GET';
        $uri = 'https://graph.facebook.com/v13.0/me/accounts';
        $field = 'picture,id,name,access_token,tasks';

        if (!empty($token)) $datas = Functions::getDataFaceBook($token, $method, $uri, $field);

        $fanpages = Fanpage::search($request->all());
        $fanpages1 = clone $fanpages;
        if (isset($datas) && count($datas) && empty($request->searchPageId) && empty($request->searchName)) {
            $fanpages_arr = $fanpages->pluck('page_id')->toArray();
            foreach ($datas as $item) {
                $page_id = $item->id;
                $fb_avatar = '/images/fpage/'.@uploadFromUrl($item->picture->data->url);

                if (in_array($page_id, $fanpages_arr)) {

                    $fanpages = Fanpage::where('page_id', $page_id)->first();
                    if (isset($fanpages) && !empty($fanpages->avatar)) {
                        Functions::unlinkUpload2($fanpages->avatar);
                    }

                    Fanpage::where('page_id', $page_id)->update([
                        'access_token' => $item->access_token,
                        'avatar' => @$fb_avatar
                    ]);
                } else {

                    Fanpage::create([
                        'access_token' => $item->access_token,
                        'user_id' => $user_id,
                        'page_id' => $item->id,
                        'name' => $item->name,
                        'avatar' => @$fb_avatar,
                        'role_text' => in_array('MANAGE', $item->tasks) ? 'Quản trị viên' : 'Biên tập viên',
                        'used' => 0,
                        'source_id' => 0
                    ]);
                }
            }
        }

        return $fanpages1;
    }
}
