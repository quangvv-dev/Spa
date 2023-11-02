<?php

namespace App\Http\Controllers\API\CSKH;

use App\Constants\ResponseStatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Branch;
use App\Models\TeamMember;
use App\Services\CskhService;
use Illuminate\Http\Request;

class CskhController extends BaseApiController
{

    public function __construct(CskhService $cskh)
    {
        $this->cskh = $cskh;
    }

    public function index(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        if (!empty($request->team_id)) {
            $members = TeamMember::where('team_id', $request->team_id)->pluck('user_id')->toArray();
        } else {
            $myTeam = TeamMember::where('user_id', $request->jwtUser->id)->first();
            $members = !empty($myTeam->members) ? $myTeam->members->pluck('user_id')->toArray() : null;
        }
        $input = $request->all();
        $tasks = $this->cskh->getDataTask($input);//công việc
        $orders = $this->cskh->getDataOrders($input);
        $data= $this->cskh->getDataNew($input);
        $payments = $this->cskh->getDataPayment($input);

        $users = $this->cskh->transformData($tasks, $orders, $data, $payments,null,$members);
        $users =  usort_key_max($users->toArray(),'all_payment');
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }
}
