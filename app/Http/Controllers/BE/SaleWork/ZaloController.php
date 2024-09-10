<?php

namespace App\Http\Controllers\BE\SaleWork;

use App\Components\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use App\Services\UserPersonalService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ZaloController extends Controller
{
    public function __construct()
    {
        $this->header = ['client-id' => 1390, 'token' => 'sD35mnN40UZw+mPs2e4KswYztwe14sPjnEuJ5svBdruMO7TLlgUYbwFWPmf/oloB'];
        $this->converstionUrl = 'https://salework.net/api/open/zalo/v1/conversation/list?group=0';
        $this->converstionDetailUrl = 'https://salework.net/api/open/zalo/v1/conversation/';
    }

    public function conversationList(Request $request)
    {
        $url = $this->converstionUrl . (isset($request->phone) ? '&search=' . $request->phone : '');
        $abc = GuzzleHttpCall($url, 'GET', $this->header);
        return response()->json($abc);
    }

    public function detailConversation(Request $request, $id)
    {
        $url = $this->converstionDetailUrl . $id . '?limit=10';
        if ($request->timestamp) {
            $url = $url . '&timestamp=' . $request->timestamp;
        }
        $abc = GuzzleHttpCall($url, 'GET', $this->header);
        return response()->json($abc);
    }
}
