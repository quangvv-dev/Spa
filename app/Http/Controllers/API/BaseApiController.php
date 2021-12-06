<?php
/**
 * Created by PhpStorm.
 * User: tungltdev
 * Date: 17/01/2019
 * Time: 10:24
 */

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//use Symfony\Component\HttpFoundation\File\UploadedFile;

class BaseApiController extends Controller
{
    protected $error = [];

    public function responseApi($code, $message = "", $data = [])
    {
        return response()->json([
            'code' => $code,
            'messages' => $message,
            'data' => !empty($data) ? $data : [],
        ]);
    }

    public function validator($request, array $validate, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request->all(), $validate, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->error = $validator->messages()->toArray();
        }
        return $this->error;
    }

    /**
     * upload chung
     *
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function apiUpload(Request $request)
    {
        $validate = [
//            'nameValidate' => "required",
            'folder' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
//        $namevalidate = $request->nameValidate ?: '';
        $folder = $request->folder ?: '';
        $destinationPath = public_path() . '/images/' . $folder;
        $thumb_path = public_path() . '/images/' . $folder . '/thumb';
        if (!is_dir($destinationPath)) {
            @mkdir($destinationPath, 0777, true);
            @copy(public_path() . '/images/index.html', $destinationPath . '/index.html');
            @copy(public_path() . '/images/.ignore', $destinationPath . ' /.gitignore');
        }
        if (!is_dir($thumb_path)) {
            @mkdir($thumb_path, 0777, true);
            @copy(public_path() . '/images/index.html', $thumb_path . '/index.html');
            @copy(public_path() . '/images/.ignore', $thumb_path . ' /.gitignore');
        }
        if ($request->hasFile('images')) {
            $media_file = $request->images;
            $imgs = [];
            if (@count(@$media_file)) {
                foreach ($media_file as $k1 => $v1) {

                    $filename = $v1->getClientOriginalName();
                    $v1->move('images/' . $folder, $filename);
                    $path_file = base_path() . '/public/images/' . $folder . '/' . $filename;
                    $path_file_new = base_path() . '/public/images/' . $folder . '/thumb/' . $filename;
                    $command = 'cp ' . $path_file . ' ' . $path_file_new;
                    exec($command);
                    // to finally create image instances
                    $size = '480x480';
                    $new_name = $path_file_new;
                    // @codingStandardsIgnoreLine
                    $cmd = "convert $new_name -resize $size\> -auto-orient -size $size xc:white +swap -gravity center -composite $new_name";
                    exec($cmd, $output_laravel);
                    $imgs[] = $filename;
                }
            }
            return $imgs;
        }
    }
}
