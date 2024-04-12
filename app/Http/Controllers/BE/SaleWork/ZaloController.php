<?php

namespace App\Http\Controllers\BE\SaleWork;

use App\Components\Filesystem\Filesystem;
use App\Constants\DirectoryConstant;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\LeaveReason;
use App\Models\PersonalImage;
use App\Models\Salary;
use App\Models\Status;
use App\Models\UserPersonal;
use App\Services\UserPersonalService;
use App\Services\UserService;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZaloController extends Controller
{
    public function __construct(UserService $userService, UserPersonalService $personalService, Filesystem $fileUpload)
    {
        $this->header = ['client-id' => 1335, 'token' => 'NFGor2u5iV3F+jH2F1mYtyIyvpCCvwqJ/pUNde/kWLGZGkuQ2/VNCJw5XypRX3Qs'];
        $this->converstionUrl = 'https://salework.net/api/open/zalo/v1/conversation/list';
        $this->converstionDetailUrl = 'https://salework.net/api/open/zalo/v1/conversation';
    }

    public function conversationList()
    {
       return GuzzleHttpCall($this->converstionUrl,'GET',$this->header);
    }
}
