<?php

function getTime($dataTime)
{
    $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

    if ($dataTime == 'TODAY') {
        return $today;
    }

    if ($dataTime == 'YESTERDAY') {
        return Carbon::yesterday()->format('Y-m-d');
    }

    if ($dataTime == 'THIS_WEEK') {
        return [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')];
    }

    if ($dataTime == 'LAST_WEEK') {
        return ([Carbon::today()->dayOfWeek === 0 ?
            Carbon::today()->previous(0) :
            Carbon::today()->previous(0)->previous()->format('Y-m-d'), Carbon::today()->previous(6)->addDay()->format('Y-m-d')]);
    }

    if ($dataTime == 'THIS_MONTH') {
        return ([Carbon::today()->startOfMonth()->format('Y-m-d'),
            Carbon::tomorrow()->format('Y-m-d')]);
    }

    if ($dataTime == 'LAST_MONTH') {
        return ([Carbon::today()->subMonth()->startOfMonth(), Carbon::today()->subMonth()->endOfMonth()]);
    }
}