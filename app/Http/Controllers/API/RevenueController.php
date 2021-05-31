<?php

namespace App\Http\Controllers\API;

use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Constants\ResponseStatusCode;

class RevenueController extends BaseApiController
{

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct()
    {
        //code
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        });
        $schedules = Schedule::getBooks($input);
        $groupComment = GroupComment::when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);

        $customers_old = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['old_start']) && isset($input['old_start']), function ($q) use ($input) {
            $q->whereBetween('old_start', [Functions::yearMonthDay($input['old_start']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        });

        $data = [
            'phone'         => $customers->count(),
            'schedules'     => $schedules,
            'groupComment'  => $groupComment->count(),

        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }


}
