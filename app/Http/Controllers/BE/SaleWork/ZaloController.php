<?php

namespace App\Http\Controllers\BE\SaleWork;

use App\Components\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use App\Services\UserPersonalService;
use App\Services\UserService;

class ZaloController extends Controller
{
    public function __construct()
    {
        $this->header = ['client-id' => 1335, 'token' => 'NFGor2u5iV3F+jH2F1mYtyIyvpCCvwqJ/pUNde/kWLGZGkuQ2/VNCJw5XypRX3Qs'];
        $this->converstionUrl = 'https://salework.net/api/open/zalo/v1/conversation/list';
        $this->converstionDetailUrl = 'https://salework.net/api/open/zalo/v1/conversation';
    }

    public function conversationList()
    {
       $abc =  GuzzleHttpCall($this->converstionUrl,'GET',$this->header);
       dd($abc);
    }
}
