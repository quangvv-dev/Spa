<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class StatusConstant
{
    const RECEIVE = 2;
    const CALL = 1;
    const NOT_CALL = 0;

    const ACTIVE = 1;
    const INACTIVE = 0;

    const GOOGLE_ADS = 1;
    const FACEBOOK_ADS = 2;
    const ZALO_ADS = 3;
    const TIKTOK_ADS = 4;

    const TYPE_CONNECT_FACEBOOK = 1;
    const TYPE_CONNECT_LADIPAGE = 2;
    const TYPE_CONNECT_WEBSITE = 3;

    const TASK_TODO = 1;
    const TASK_FAILED = 6;
    const TASK_DONE = 3;

    const CHUA_QUA_HAN = 0; // trạng thái chưa quá hạn
    const QUA_HAN = 1; // trạng thái quá hạn
    const MOVE_CSKH = 2; // trạng thái đã chuyển về trưởng phòng
}
