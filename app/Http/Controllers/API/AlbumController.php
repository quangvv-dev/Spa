<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AlbumController extends BaseApiController
{
    /**
     * CREATE IMAGE
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $images = [];
        $doc = Album::where('customer_id', $input['customer_id'])->first();

        if (isset($doc) && $doc) {
            if (count($input['images'])) {
                $images = json_decode($doc->images);
                foreach ($input['images'] as $item) {
                    $images[] = [
                        'fileName' => $item,
                        'date' => Carbon::now()->format('d/m/Y'),
                    ];
                }

                $doc->images = json_encode($images);
                $doc->save();
            }
        } else {
            if (count($input['images'])) {
                foreach ($input['images'] as $item) {
                    $images[] = [
                        'fileName' => $item,
                        'date' => Carbon::now()->format('d/m/Y'),
                    ];
                }
                $input['images'] = json_encode($images);
                $doc = Album::create($input);
            }
        }
        $data = new AlbumResource($doc);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * DELETE IMAGE ALBUM
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id)
    {
        $doc = Album::where('customer_id', $id)->first();
        if (isset($doc) && $doc) {
            $img_default = json_decode($doc->images);
            $key = array_search($request->images, array_column($img_default, 'fileName'));
            if (is_numeric($key)) {
                unlink(public_path('/images/album/' . $img_default[$key]->fileName));
                unlink(public_path('/images/album/thumb/' . $img_default[$key]->fileName));
                unset($img_default[$key]);
                $doc->images = json_encode(array_values($img_default));
                $doc->save();
            }
            $data = new AlbumResource($doc);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } else {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'NOT FOUND ABLMUM');
        }

    }

    /**
     * Danh sách album
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }
        $input = $request->all();
        $customer = Customer::select('id', 'full_name', 'phone', 'branch_id')->where('phone', $input['phone'])->first();
        if (isset($customer) && $customer) {
            $data = [
                'customer_id' => $customer->id,
                'name' => $customer->full_name,
                'phone' => $customer->phone,
                'branch_id' => $customer->branch_id,
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        }
        return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'NOT FOUND CUSTOMER ALBUM');

    }

    /**
     * Chi tiết Album
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $input = $request->all();
        $doc = Album::where('customer_id', $id)->first();

        if (empty($doc)) {
            $input['customer_id'] = $id;
            $doc = Album::create($input);
        }
        $data = new AlbumResource($doc);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

}
