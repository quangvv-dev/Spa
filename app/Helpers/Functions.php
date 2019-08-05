<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Functions
{
    /**
     * Random voucher
     *
     * @param length
     *
     * @return random String
     */
    public static function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Convert vi to en
     *
     * @param $str
     *
     * @return string|string[]|null
     */
    public static function vi_to_en($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }

    /**
     * UploadImage
     *
     * @param UploadedFile $file
     * @param              $path
     * @param string       $namevalidate
     *
     * @return null
     */
    public static function uploadImage(UploadedFile $file, $path, $namevalidate = 'img_file')
    {
        $destinationPath = public_path() . '/uploads/' . $path;
//        $thumbPath = public_path() . '/uploads/' . $path . '/thumb/';
        if (!is_dir($destinationPath)) {
            @mkdir($destinationPath, 0777, true);
            @copy(public_path() . '/uploads/index.html', $destinationPath . '/index.html');
            @copy(public_path() . '/uploads/.ignore', $destinationPath . ' /.gitignore');
        }
//        if (!is_dir($thumbPath)) {
//            @mkdir($thumbPath, 0777, true);
//            @copy(public_path() . '/uploads/index.html', $thumbPath . '/index.html');
//            @copy(public_path() . '/uploads/.ignore', $thumbPath . ' /.gitignore');
//        }
        $extension = $file->getClientOriginalExtension();
        if (in_array($extension, explode(',', 'jpg,jpeg,png,JPG,JPEG,PNG'))) {
            $filename = $file->getClientOriginalName();
            $picture = str_slug(substr($filename, 0, strrpos($filename, "."))) . '_' . time() . '.' . $extension;
            $image = $file->move($destinationPath, $picture);
            // if ($image) {
            //     $sourcePath = $image->getPath() . '/' . $image->getFilename();
            //     Thumbnail::generate_image_thumbnail($sourcePath, $thumbPath . $image->getFilename());
            //     return $image->getFileInfo()->getFilename();
            // }
            return $image->getFileInfo()->getFilename();
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                $namevalidate => [
                    trans('validation . mimes',
                        ['attribute' => $namevalidate, 'values' => 'jpg,jpeg,png,JPG,JPEG,PNG']),
                ],
            ]);
            throw $error;
        }
    }

    public static function getImageModels($model, $path, $field = 'images', $index = 0)
    {
        $val = @$model->$field ?: null;
        if (is_array($val)) {
            $val = $val[$index];
        }
        if (empty($val) || !file_exists(public_path("uploads/$path/$val"))) {
            return asset('default/no-image.png');
        }
        $val = asset("uploads/$path/$val");
        return $val;
    }

    public static function unlinkUpload($path, $name)
    {
        if (!empty($name)) {
            @unlink(public_path('uploads/' . $path . '/' . $name));
            @unlink(public_path('uploads/' . $path . '/thumb_' . $name));
        }
    }

    /**
     * Upload multiple file-input
     *
     * @param $request
     * @param $doc
     * @param $path
     *
     * @return mixed
     */
    public static function checkUploadImage($request, $doc, $path)
    {
        $khac = [];
        @$khop = array_intersect($doc->images, !empty($request->image) ? $request->image : []);
        $khop = empty($khop) ? [] : $khop;
        if (!empty($doc->images)) {
            foreach ($doc->images as $k => $v) {
                if (!in_array($v, $khop)) {
                    $khac[] = $v;
                }
            }
        }
        //trường hợp xóa ảnh và upload thêm ảnh mới
        if (!$khac == [] && $request->hasFile('img_file')) {
            $imgs = [];
            foreach ($khac as $k => $v) {
                self::unlinkUpload('services', @$v);
            }
            if (count($request->img_file)) {
                foreach (@$request->img_file as $k => $v) {
                    $img = self::uploadImage($v, $path);
                    $imgs[] = $img;
                }
            }
            @$imgs = array_merge($khop, $imgs);
            $imgs2 = [];
            foreach ($imgs as $k1 => $v) {
                $imgs2[] = $v;
            }
            return $request->merge(['images' => @json_encode($imgs2)]);
        } elseif (!$khac == [] && !$request->hasFile('img_file')) { //trường hợp chỉ xóa ảnh
            foreach ($khac as $k => $v) {
                self::unlinkUpload($path, @$v);
            }
            $imgs = [];
            foreach (@$khop as $k => $v) {
                $imgs[] = $v;
            }
            return $request->merge(['images' => json_encode($imgs)]);
        } elseif ($khac == [] && $request->hasFile('img_file')) { //trường hợp chỉ upload thêm ảnh
            $imgs = [];
            if (count($request->img_file)) {
                foreach (@$request->img_file as $k => $v) {
                    $img = self::uploadImage($v, $path);
                    $imgs[] = $img;
                }
            }
            $imgs = array_merge($khop, $imgs);
            $request->merge(['images' => json_encode($imgs)]);
        }
    }

    public static function dayMonthYear($date)
    {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }

    public static function yearMonthDay($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

}
