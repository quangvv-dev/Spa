<?php

function getTime($dataTime)
{
    $today = Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

    if ($dataTime == 'TODAY') {
        return $today;
    }

    if ($dataTime == 'YESTERDAY') {
        return Carbon\Carbon::yesterday()->format('Y-m-d');
    }

    if ($dataTime == 'THIS_WEEK') {
        return [Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')];
    }

    if ($dataTime == 'LAST_WEEK') {
        return ([Carbon\Carbon::today()->dayOfWeek === 0 ?
            Carbon\Carbon::today()->previous(0) :
            Carbon\Carbon::today()->previous(0)->previous()->format('Y-m-d'), Carbon\Carbon::today()->previous(6)->addDay()->format('Y-m-d')]);
    }

    if ($dataTime == 'THIS_MONTH') {
        return ([Carbon\Carbon::today()->startOfMonth()->format('Y-m-d'),
            Carbon\Carbon::tomorrow()->format('Y-m-d')]);
    }

    if ($dataTime == 'LAST_MONTH') {
        return ([Carbon\Carbon::today()->subMonth()->startOfMonth(), Carbon\Carbon::today()->subMonth()->endOfMonth()]);
    }
}