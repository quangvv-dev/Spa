<?php

namespace App\Helpers;

use App\Constants\StatusCode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use nusoap_client;
use function PHPSTORM_META\elementType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\WalletHistory;
use App\Models\Status;
use App\Models\Customer;

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
     * Random voucher
     *
     * @param length
     *
     * @return random String
     */
    public static function generateRandomNumber($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNumber;
    }

    /**
     * check action trang thai khach hang in rules
     *
     * @param $config
     *
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
     *
     * @return array
     */
    public static function checkRuleSms($config)
    {
        return array_filter($config, function ($k) {
            return $k->type == 'action' && $k->value == 'send_sms';
        });
    }

    /**
     * replace variable to data
     *
     * @param $input
     * @param $text
     *
     * @return mixed
     */
    public static function replaceTextForUser($input, $text)
    {
        $text = isset($input['full_name']) ? str_replace('%full_name%', $input['full_name'], $text) : $text;
        $text = isset($input['phone']) ? str_replace('%phone%', $input['phone'], $text) : $text;
        $text = isset($input['branch']) ? str_replace('%branch%', $input['branch'], $text) : $text;
        $text = isset($input['phoneBranch']) ? str_replace('%phoneBranch%', $input['phoneBranch'], $text) : $text;
        $text = isset($input['addressBranch']) ? str_replace('%addressBranch%', $input['addressBranch'], $text) : $text;
        return $text;

    }

    /**
     * check action create job in array Rules
     *
     * @param $config
     *
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
     *
     * @return string
     */
    public static function getExactlyTime($sms)
    {
        $exactly_value = '';
        $time_type = @$sms->configs->time_type;
        if ($time_type == 'exactly') {
            $exactly_value = Carbon::parse(@$sms->configs->exactly_value)->format('d-m-Y H:s');
        } elseif ($time_type == 'delay') {
            $delay_unit = @$sms->configs->delay_unit;
            $delay_value = @$sms->configs->delay_value;
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

    public static function unlinkUpload2($path)
    {
        if (!empty($path)) {
            @unlink(public_path($path));
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

    public static function checkUploadImage1($request, $doc, $path)
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
//        dd($khac,$khop);

        //trường hợp xóa ảnh và upload thêm ảnh mới
        if (!$khac == [] && $request->hasFile('input24')) {
            $imgs = [];
            foreach ($khac as $k => $v) {
                self::unlinkUpload2('uploads/' . $path . '/' . $v);
            }

            if (count($request->input24)) {
                foreach (@$request->input24 as $k => $v) {
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
        } elseif (!$khac == [] && !$request->hasFile('input24')) { //trường hợp chỉ xóa ảnh
            foreach ($khac as $k => $v) {
                self::unlinkUpload2('uploads/' . $path . '/' . $v);
            }
            $imgs = [];
            foreach (@$khop as $k => $v) {
                $imgs[] = $v;
            }
            return $request->merge(['images' => json_encode($imgs)]);
        } elseif ($khac == [] && $request->hasFile('input24')) { //trường hợp chỉ upload thêm ảnh
            $imgs = [];
            if (count($request->input24)) {
                foreach (@$request->input24 as $k => $v) {
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

    public static function yearMonthDayTime($date)
    {
        return \Carbon\Carbon::createFromFormat('d/m/Y H:i', $date)->format('Y-m-d H:i');
    }

    public static function yearMonthDayTimeFormat($date, $format = 'Y-m-d')
    {
        return \Carbon\Carbon::createFromFormat('d/m/Y H:i', $date)->format($format);
    }

    public static function createYearMonthDay($date)
    {
        return \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }

    public static function getTime($date)
    {
        return \Carbon\Carbon::parse($date)->format('H:i:s');
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
        curl_setopt_array($curl, [
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "token: $token",
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $error_code = !empty(json_decode($response)) ? json_decode($response)->errorCode : 404;
        if ($error_code == '000') {
            return 1;
        }else{
            \DB::table('settings')->insert(['setting_key' => 'logSms', 'setting_value' => json_encode($error_code)]);
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

    /**
     * tong tien KH da thanh toan
     *
     * @param $id
     *
     * @return int
     */
    public static function sumOrder($id)
    {
        $total = Order::select('id', 'gross_revenue')->where('member_id', $id);
        $wallet = WalletHistory::select('id', 'gross_revenue')->where('customer_id', $id);
        $all_price = (int)$total->sum('gross_revenue') + (int)$wallet->sum('gross_revenue');
//        $total = (int)$payment + (int)$wallet;
        $money = [
            'total' => $total->count(),
            'payment' => $all_price,
        ];
        return $money;
    }

    public static function getStatusWithCode($code)
    {
        $status = Status::where('code', 'like', '%' . $code . '%')->first();
        return isset($status) && $status ? $status->id : 0;
    }

    /**
     * Update hang khach hang
     *
     * @param $customer_id
     *
     * @return int
     */
    public static function updateRank($customer_id)
    {
        $total = Functions::sumOrder($customer_id);
        $customer = Customer::find($customer_id);
        $statusVip = Functions::getStatusWithCode('khach_vip');

        $silver = setting('silver') ?: 0;
        $gold = setting('gold') ?: 0;
        $platinum = setting('platinum') ?: 0;

        if (isset($silver) && isset($gold) && isset($platinum)) {

            if ($silver <= $total['total']) {
                $status = Functions::getStatusWithCode('nguoi_mua_hang');
            } elseif ($gold <= $total['total']) {
                $status = Functions::getStatusWithCode('khach_hang');
            }
            if ($platinum <= $total['payment'] && !empty($statusVip) && $customer->status_id != $statusVip) {
                $status = $statusVip;
            }

            if (isset($status) && $status) {
                $customer->status_id = $status;
                $customer->save();
            }
        }
        return 1;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return LengthAwarePaginator
     * @var array
     */
    public static function customPaginate($items, $page = null, $perPage = StatusCode::PAGINATE_20, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public static function paginationArray($page, $temp, $paginate = StatusCode::PAGINATE_10)
    {
//        krsort($temp);
        if ($page && $page > 1) {
            $temp = array_slice($temp, $paginate * ($page - 1) + 1, $paginate);
        } else {
            $temp = array_slice($temp, 0, $paginate);
        }
        return $temp;
    }

    public static function addSearchDateTime($request)
    {
        $date_check = Carbon::now()->subDays(7)->format('d/m/Y');
        $date = Carbon::now()->format('d/m/Y');

        $request->merge(['start_date' => $date_check . ' 00:00']);
        $request->merge(['end_date' => $date . ' 23:59']);
    }

    public static function addSearchDate($request)
    {
        $date_check = Carbon::now()->subDays(7)->format('d/m/Y');
        $date = Carbon::now()->format('d/m/Y');

        $request->merge(['start_date' => $date_check]);
        $request->merge(['end_date' => $date]);
    }

    public static function addSearchDateFormat($request, $format = 'd/m/Y')
    {
        $date_check = Carbon::now()->subDays(7)->format($format);
        $date = Carbon::now()->format($format);
        $request->merge(['start_date' => $date_check]);
        $request->merge(['end_date' => $date]);
    }

    /**
     * @param $token
     * @param $method
     * @param $uri
     * @param $field
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getDataFaceBook($token, $method, $uri, $field)
    {
        $params = [
            'query' => [
                'access_token' => $token,
                'fields' => $field,
            ],
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request($method, $uri, $params);

            if ($res->getStatusCode() == 200) { // 200 OK
                $response_data = $res->getBody()->getContents();
                $datas = json_decode($response_data)->data;
                return $datas;
            }
        } catch (\Exception $e) {
            report($e);
            return [];
        }

    }

    /**
     * xử lý mã hóa VNPAY
     *
     * @param $inputData
     * @param $vnp_Url
     * @param $vnp_HashSecret
     *
     * @return mixed
     */
    public static function hasReturnUrlVNPAY($inputData, $vnp_Url, $vnp_HashSecret)
    {
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . $key . "=" . $value;
            } else {
                $hashData .= $key . "=" . $value;
                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashData);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    public static function returnMessage($code)
    {

        switch ($code) {
            case '00':
                $data['RspCode'] = '00';
                $data['Message'] = 'Confirm Success';
                break;
            case '01':
                $data['RspCode'] = '01';
                $data['Message'] = 'Order not found';
                break;
            case '02':
                $data['RspCode'] = '02';
                $data['Message'] = 'Order already confirmed';
                break;
            case '97':
                $data['RspCode'] = '97';
                $data['Message'] = 'Chữ ký không hợp lệ';
                break;
            case '99':
                $data['RspCode'] = '99';
                $data['Message'] = 'Unknown error';
                break;
            default:
                $data = [];
        }
        return $data;
    }

    /**
     * Check time Expired OTP
     *
     * @param $otp
     * @return int
     */
    public static function checkExpiredOtp($otp)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $now = strtotime($now);
        $to = strtotime($otp->updated_at);
        $distance = round(($now - $to) / 60);
        if ($distance < 16) {
            return 1; // còn hiệu lực OTP 15p
        } else {
            return 0;// OTP hết hiệu lực
        }
    }

    public static function returnPercentRoseYta($yta1, $yta2, $type)
    {
        if(!$yta1 && !$yta2){
            return '';
        }
        if ($type == 'chinh') {
            if ($yta1 && $yta2) {
                return setting('exchange_yta1');
            } else {
                return setting('exchange_yta_single');
            }
        } else {
            if(empty($yta2)){
                return '';
            }
            return setting('exchange_yta2');
        }
    }
    public static function returnPercentRoseSupport($tv1, $tv2, $type)
    {
        if(!$tv1 && !$tv2){
            return '';
        }
        if ($type == 'chinh') {
            if ($tv1 && $tv2) {
                return setting('exchange_support1');
            } else {
                return setting('exchange_support_single');
            }
        } else {
            if(empty($tv2)){
                return '';
            }
            return setting('exchange_support2');
        }
    }

}
