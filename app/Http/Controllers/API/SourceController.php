<?php

namespace App\Http\Controllers\API;

use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceController extends Controller
{
    public function storeCustomerLandipage(Request $request, $id)
    {
        try {
            $source = Source::find($id);
            $customer_search = Customer::where('phone', $request->phone)->first();
            if ($customer_search) {
                return response()->json([
                    'code' => 200,
                    'messages' => 'Khách hàng đã tồn tại',
                ]);
            }
            if (empty($source) || empty($source->accept)) {
                return response()->json([
                    'code' => 404,
                    'messages' => 'NOT FOUND SOURCE',
                ]);
            }
            if (empty($request->phone) || empty($request->name)) {
                return response()->json([
                    'code' => 400,
                    'messages' => 'NOT FOND PHONE OR NAME',
                ]);
            }

            $sales = json_decode($source->sale_id);
            $data = $request->only('name', 'phone', 'message');
            $data['source_id'] = 30;
            $data['source_fb'] = $source->id;
            $data['status_id'] = Functions::getStatusWithCode('moi');
            $data['carepage_id'] = $source->mkt_id;
            $data['mkt_id'] = $source->mkt_id;
            $data['telesales_id'] = count($sales) > 2 ? $sales[$source->position] : $sales[0];
            $data['gender'] = 0;
            $data['branch_id'] = $source->branch_id;
            $data['full_name'] = $request->name;
            if (is_array($request->message)) {
                $data['description'] = implode("||", $request->message);
            } else {
                $data['description'] = $request->message;
            }

//            $data['expired_time_boolean'] = CustomerConstant::QUA_HAN;
//
//            $date = date('Y-m-d H:i:s');
//            if (!empty($customer)) {
//                $data['duplicate'] = 1;
//                $date_check = date('Y-m-d H:i:s', strtotime('+30day', strtotime($customer->updated_at)));
//                if ($date <= $date_check && $id == $customer->source_id) {
//                    return response()->json([
//                        'code' => 401,
//                        'messages' => 'Trùng số, trùng source trong 30 ngày !',
//                    ]);
//
//                } else {
//                    $data['user_id'] = $customer->user_id;
//                }
//            } else {
//                $position = $source->position < (count($sales) - 1) ? ($source->position + 1) : 0;
//                $source->update(['position' => $position]);
//            }

            $position = $source->position < (count($sales) - 1) ? ($source->position + 1) : 0;
//            dd($source->position,$sales,$position);
            $source->update(['position' => $position]);

            $cusstomer = Customer::create($data);
            $abc = json_decode($source->category_id);
            if (count($abc)) {
                foreach ($abc as $item) {
                    CustomerGroup::create(
                        [
                            'customer_id' => $cusstomer->id,
                            'category_id' => $item,
                            'branch_id' => $source->branch_id,
                            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d h:i:s')
                        ]
                    );
                }
            }
            $cusstomer->update(['account_code' => 'KH' . $cusstomer->id]);
            return response()->json([
                'code' => 200,
                'messages' => 'SUCCESS',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'code' => 401,
                'messages' => $exception->getMessage(),
            ]);
        }

    }
}
