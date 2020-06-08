<?php

namespace App\Helpers;

use nusoap_client;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;

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
     * check action trang thai khach hang in rules
     *
     * @param $config
     * @return array
     */
    public static function checkRuleStatusCustomer($config)
    {
        return array_filter($config, function ($k) {
            return $k->type == 'actor' && $k->value == 'staff';
        });
    }

    /**
     * check action sendsms in array Rules
     *
     * @param $config
     * @return array
     */
    public static function checkRuleSms($config)
    {
        return array_filter($config, function ($k) {
            return $k->type == 'action' && $k->value == 'send_sms';
        });
    }

    /**
     * check action create job in array Rules
     *
     * @param $config
     * @return array
     */
    public static function checkRuleJob($config)
    {
        return array_filter($config, function ($k) {
            return $k->type == 'action' && $k->value == 'create_job';
        });
    }

    /**
     * get time action in rules
     *
     * @param $sms
     * @return string
     */
    public static function getExactlyTime($sms)
    {
        $exactly_value = '';
        $time_type = @array_values($sms)[0]->configs->time_type;
        if ($time_type == 'exactly') {
            $exactly_value = Carbon::parse(@array_values($sms)[0]->configs->exactly_value)->format('d-m-Y H:s');
        } elseif ($time_type == 'delay') {
            $delay_unit = @array_values($sms)[0]->configs->delay_unit;
            $delay_value = @array_values($sms)[0]->configs->delay_value;
            if ($delay_unit == 'hours') {
                $exactly_value = Carbon::now('Asia/Ho_Chi_Minh')->addHour((int)$delay_value)->format('d-m-Y H:s');
            } else {
                $exactly_value = Carbon::now('Asia/Ho_Chi_Minh')->addDays((int)$delay_value)->format('d-m-Y H:s');
            }

        }
        return $exactly_value;
    }

    /**
     * convert sdt
     *
     * @param $phone
     *
     * @return string
     */
    public static function convertPhone($phone)
    {
        return '84' . (int)$phone;
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
     * @param string $namevalidate
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

    /**
     * SMS VMG BRANDNAME
     *
     * @param        $phone
     * @param        $sms_text
     * @param string $send_after
     */
    public static function sendSmsV2($phone, $sms_text, $send_after = '')
    {
        $client = new nusoap_client("http://brandsms.vn:8018/VMGAPI.asmx?wsdl", 'wsdl', '', '', '', '');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false;
        $err = $client->getError();
        if ($err) {
            echo '<h2>Test-Constructor error</h2><pre>' . $err . '</pre>';
        }
        $result = $client->call('BulkSendSms',
            [
                'msisdn' => $phone,
                'alias' => 'VMGtest',
                'message' => $sms_text,
                'sendTime' => $send_after,
                //                'sendTime'         => '15/08/2019 15:32',
                'authenticateUser' => 'vmgtest1',
                'authenticatePass' => 'vmG@123b',
            ], '', '', ''
        );

        $err = $client->getError();
        if (!$err) {
            return 1;
        }
    }

    public static function sendSmsV3($phone, $sms_text, $send_after = '')
    {
        $data = [
            'to' => $phone,
            'from' => "ROYAL SPA",
            'message' => $sms_text,
            'scheduled' => $send_after,//15-01-2019 16:05
            'requestId' => "",
            'useUnicode' => 0,//sử dụng có dấu hay k dấu
            'type' => 1 // CSKH hay QC
        ];
        $data = json_encode((object)$data);
        $base_url = 'http://api.brandsms.vn:8018/api/SMSBrandname/SendSMS';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c24iOiJyb3lhbHNwYSIsInNpZCI6ImFmZTIxOWQ4LTdhM2UtNDA5MS05NjBmLThmZjViNGI4NzRhMiIsIm9idCI6IiIsIm9iaiI6IiIsIm5iZiI6MTU4OTM1NDE4MCwiZXhwIjoxNTg5MzU3NzgwLCJpYXQiOjE1ODkzNTQxODB9.Hx8r30IR1nqAkOClihx0n9upfvgOg1f-E3MwNEwWT-0';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $error_code = json_decode($response)->errorCode;
        if ($error_code == '000') {
            return 1;
        }
    }

    /**
     * SMS VIETTEL
     *
     * @param $phone
     * @param $sms_text
     */
    public static function sendSmsBK($phone, $sms_text)
    {
        $client = new nusoap_client("http://203.190.170.43:9998/bulkapi?wsdl", 'wsdl', '', '', '', '');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false;
        $err = $client->getError();
        if ($err) {
            echo '<h2>Test-Constructor error</h2><pre>' . $err . '</pre>';
        }
        $result = $client->call('wsCpMt',
            [
                'User' => 'smsbrand_royal_spa',
                'Password' => '123456a@',
                'CPCode' => 'ROYAL_SPA',
                'UserID' => $phone,
                'RequestID' => '1',
                'ReceiverID' => $phone,
                'ServiceID' => 'ROYAL-SPA',
                'CommandCode' => 'bulksms',
                'ContentType' => '0',
                'Content' => $sms_text,
            ], '', '', ''
        );

        $err = $client->getError();
        if (!$err) {
            return 1;
        }

    }
}
