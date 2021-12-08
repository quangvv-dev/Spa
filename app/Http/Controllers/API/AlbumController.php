<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Carbon\Carbon;
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
        $data['records'] = new AlbumResource($doc);

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
        $doc = Album::find($id);
        $img_default = json_decode($doc->images);
        $key = array_search($request->images, array_column($img_default, 'fileName'));
        if ($key) {
            unset($img_default[$key]);
            $doc->images = json_encode(array_values($img_default));
            $doc->save();
            $data['records'] = new AlbumResource($doc);
        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Danh sách album
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $doc = Album::search($input)->paginate(StatusCode::PAGINATE_10);
        $doc = AlbumResource::collection($doc);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $doc);
    }

}
