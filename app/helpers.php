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
            Carbon\Carbon::tomorrow()->format('Y-m-d'),
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
