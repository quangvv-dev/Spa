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
        $this->header = ['client-id' => env('CLIENT_ID_SW', 1335), 'token' => env('TOKEN_SW', 'NFGor2u5iV3F+jH2F1mYtyIyvpCCvwqJ/pUNde/kWLGZGkuQ2/VNCJw5XypRX3Qs')];
        $this->converstionUrl = 'https://salework.net/api/open/zalo/v1/conversation/list?group=0';
        $this->converstionDetailUrl = 'https://salework.net/api/open/zalo/v1/conversation/';
    }

    public function conversationList(Request $request)
    {
        try {
            $url = $this->converstionUrl . (isset($request->phone) ? '&search=' . $request->phone : '');
            $abc = GuzzleHttpCall($url, 'GET', $this->header);
            return response()->json($abc);
        }catch (\Exception $exception){
            dd($exception->getMessage(),$this->header);
        }
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
