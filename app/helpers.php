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
