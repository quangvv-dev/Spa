<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class StatusCode
{
    const NAM       = 1;
    const NU        = 0;
    const HIGHLIGHT = 1;
    const NONE      = 0;
    const CITY      = 'city';
    const ACCEPT    = 'accept';
    const COUNTRY   = 'country';
    const COMMON    = 1;
    const SILVER    = 2;
    const GOLD      = 3;
    const PLATINUM  = 4;
    const DIAMOND   = 5;
    const GROUP_CUSTOMER   = 1; // NHÓM KHÁCH HÀNG
    const SOURCE_CUSTOMER   = 2;// NGUỒN KHÁCH HÀNG : fb, TOOL, GOOLE ...
    const RELATIONSHIP   = 3;// MÔI QUAN HỆ : MỚI, ĐÃ MUA sp ...
}
