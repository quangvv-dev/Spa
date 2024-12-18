<?php

function getTime($dataTime)
{

    $today = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

    if ($dataTime == 'TODAY') {
        return $today;
    }

    if ($dataTime == 'YESTERDAY') {
        return Carbon\Carbon::yesterday('Asia/Ho_Chi_Minh')->format('Y-m-d');
    }

    if ($dataTime == 'THIS_WEEK') {
        return [
            Carbon\Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->format('Y-m-d') . " 00:00:00",
            Carbon\Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->format('Y-m-d') . " 23:59:59",
        ];
    }

    if ($dataTime == 'LAST_WEEK') {
        return [
            date("Y-m-d", strtotime("last week monday")) . " 00:00:00",
            date("Y-m-d", strtotime("last week sunday")) . " 23:59:59",
        ];
    }

    if ($dataTime == 'THIS_MONTH') {
        return ([
            Carbon\Carbon::today()->startOfMonth()->format('Y-m-d'),
            Carbon\Carbon::today()->endOfMonth()->format('Y-m-d'),
        ]);
    }

    if ($dataTime == 'LAST_MONTH') {
        return ([
            Carbon\Carbon::today()->subMonth()->startOfMonth()->format('Y-m-d'),
            Carbon\Carbon::today()->subMonth()->endOfMonth()->format('Y-m-d'),
        ]);
    }
}

function replaceNumberFormat($number)
{
    return str_replace(',', '', $number);
}

function ApiResult($code = null, $msg = null, $data = null, $error = null, $debug = null)
{
    $response = ['code' => $code, 'msg' => $msg, 'data' => $data, 'error' => $error, 'debug' => $debug];
    return response()->json($response, $code);
}

function getUser($id)
{
    $data = \App\User::select('id', 'full_name')->find($id);
    return isset($data) && $data ? $data : [];
}

function chooseColorPHP($status)
{
    switch ($status) {
        case 1:
            $color = '#63cff9';
            break;
        case 2:
            $color = '#dccf34';
            break;
        case 3:
            $color = '#d03636';
            break;
        case 4:
            $color = '#4bcc4b';
            break;
        case 5:
            $color = '#808080';
            break;
        default:
//            code to be executed if n is different from all labels;
    }
    return $color ?: '';

}

/**
 * Random màu
 *
 * @param int $length
 *
 * @return string
 */
function generateRandomColor($length = 6)
{
    $characters = '0123456789ABCDEF';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return '#' . $randomString;
}

function findIndexOfKey($key_to_index, $array)
{
    return array_search($key_to_index, array_keys($array));
}

function replaceVariable($content, $name = '', $phone = '', $branch = '', $phoneBranch = '', $addressBranch = '')
{
    $content = str_replace('%full_name%', $name, $content);
    $content = str_replace('%phone%', $phone, $content);
    $content = str_replace('%branch%', $branch, $content);
    $content = str_replace('%phoneBranch%', $phoneBranch, $content);
    $content = str_replace('%addressBranch%', $addressBranch, $content);
    return $content;

}

/**
 * Sắp xếp từ lớp tới nhỏ theo key
 *
 * @param $data
 * @param $key
 *
 * @return mixed
 */
function usort_key_max($data, $key)
{
    usort($data, function ($a, $b) use ($key) {
        return $a[$key] <= $b[$key];
    });
    return $data;
}

/**
 * Sắp xếp mảng từ nhỏ tới lớn theo key
 *
 * @param $data
 * @param $key
 *
 * @return mixed
 */
function usort_key_min($data, $key)
{
    usort($data, function ($a, $b) use ($key) {
        return $a[$key] >= $b[$key];
    });
    return $data;
}

if (!function_exists('formatYMD')) {
    function formatYMD($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('checkRoleAlready')) {
    function checkRoleAlready()
    {
        $user = \Illuminate\Support\Facades\Auth::user()->branch_id;
        return $user;
    }
}

if (!function_exists('checkTeamLead')) {
    function checkTeamLead()
    {
        $user = \App\Models\Team::where('leader_id',
            \Illuminate\Support\Facades\Auth::user()->id)->with('teamMembers')->first();
        return isset($user->teamMembers) ? $user->teamMembers->pluck('user_id')->toArray() : [];
    }
}
if (!function_exists('myTeamMember')) {
    function myTeamMember()
    {
        $user = \App\Models\TeamMember::where('user_id',
            \Illuminate\Support\Facades\Auth::user()->id)->first();

        return !empty($user) ? \App\Models\TeamMember::where('team_id', $user->team_id)
            ->pluck('user_id')->toArray() : [];
//        return isset($user->members) ? $user->members->pluck('user_id')->toArray() : [];
    }
}

if (!function_exists('fcmSendCloudMessage')) {
    function fcmSendCloudMessage(
        $deviceToken = "",
        $title,
        $body,
//        $log_action = '',
//        $notification_id = null,
        $notification_type = 'notification',
        $push_data = []
    ) {
        //$deviceToken truyền mảng device hoặc 1 chuỗi device hoặc là 1 topic  ( '/topics/all' )
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = config('app.SERVER_KEY_FIREBASE');
        $fields = [
            'priority'     => 'high',
            'time_to_live' => 60 * 60 * 24,
        ];
        if (!empty($push_data)) {
            $fields['data'] = $push_data;
        }
        $fields['notification'] = [
            "body"  => $body,
            "title" => $title,
            "sound" => "default",
            "badge" => "1",
            "color" => "#990000",
            //            "click_action" => $action_web,
        ];
        // cấu hình android
        $fields['android'] = [
            'ttl'          => 3600 * 1000,
            'notification' => [
                'color' => '#f45342',
                //'icon'  => 'stock_ticker_update',
            ],
        ];

        // cấu hình ios
        $fields['apns'] = [
            'payload' => [
                'aps' => [
                    'badge' => 42,
                ],
            ],
        ];
        // cấu hình web
//        $fields['webpush'] = [
//            'notification' => [
//                "body"  => $body,
//                "title" => $title,
//            ],
//        ];

        if (is_array($deviceToken)) {
            $fields['registration_ids'] = $deviceToken;
        } else {
            $fields['to'] = $deviceToken;
        }
        $headers = [
            'Content-Type:application/json',
            'Authorization:key=' . $serverKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        @$rs = @json_decode($result);
        curl_close($ch);
//        if (@$rs->multicast_id) {
//            LogFcm::create([
//                'action'          => $log_action,
//                'notification_id' => $notification_id,
//                'type'            => $notification_type,
//                'multicast_id'    => $rs->multicast_id,
//                'success'         => $rs->success,
//                'failure'         => $rs->failure,
//                'canonical_ids'   => $rs->canonical_ids,
//                'results'         => $rs->results,
//                'body'            => $fields,
//            ]);
//        }
        return $rs;
    }
}

function uploadFromUrl($url)
{
    $name = str_slug(str_random(3) . '_' . time()) . '.png';
    $to = public_path() . '/images/fpage/' . $name;
    return saveImage($url, $to, $name);
}

function saveImage($url, $saveTo, $name)
{
    if (empty($url)) {
        return null;
    }
    $fp = fopen($saveTo, 'w+');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $code == 200 ? $name : null;
}

function getLocation()
{
    return \App\Models\Location::get()->pluck('name', 'id');
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else {
        if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

if (!function_exists('GuzzleHttpCall')) {
    function GuzzleHttpCall($path, $method = 'get', $header = [], $post_data = [])
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->$method($path, [
            'headers' => $header,
            'json'    => $post_data,
        ]);
        return json_decode($response->getBody());
    }
}

/**
 * funtion get set dữ liệu vào bảng settings
 */
if (!function_exists('dbSetting')) {
    function dbSetting($key, $value = "")
    {
        if (!empty($key) && !empty($value)) {
            $exists = \App\Models\DBSettings::where('setting_key', $key)->first();
            if (isset($exists) && $exists) {
                $exists->setting_value = $value;
                $exists->save();
            } else {
                $exists = \App\Models\DBSettings::create(['setting_key' => $key]);
            }
            return $exists->setting_value;

        } elseif (!empty($key)) {
            return @\App\Models\DBSettings::where('setting_key', $key)->first()->setting_value;
        } else {
            return "";
        }
    }

    if (!function_exists('diffTime')) {
        function diffTime($time = null)
        {
            $now = now();
            if (!empty($time)) {
                $countdown = strtotime($now) - strtotime($time);
                $days = ($countdown / 86400) >= 1 ? floor($countdown / 86400) : 0;
                $hours = floor(($countdown % 86400) / 3600);
                $minutes = round((($countdown % 86400) % 3600) / 60);

                return ($days > 0 ? $days . ' ngày ' : '') . ($hours > 0 ? $hours . ' giờ ' : '') . ($minutes > 0 && $days < 1 ? $minutes . ' phút' : '');
            }
            return '';
        }
    }
    if (!function_exists('diffTimeTwo')) {
        function diffTimeTwo($from = null, $to = null)
        {
            if (!empty($from)) {
                $countdown = strtotime($to) - strtotime($from);
                $days = ($countdown / 86400) >= 1 ? floor($countdown / 86400) : 0;
                $hours = floor(($countdown % 86400) / 3600);
                $minutes = round((($countdown % 86400) % 3600) / 60);

                return ($days > 0 ? $days . ' ngày ' : '') . ($hours > 0 ? $hours . ' giờ ' : '') . ($minutes > 0 && $days < 1 ? $minutes . ' phút' : '');
            }
            return '';
        }
    }

}

