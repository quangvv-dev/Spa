<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class StatusCode
{
    const NAM = 1;
    const NU = 0;
    const HIGHLIGHT = 1;
    const NONE = 0;
    const CITY = 'city';
    const ACCEPT = 'accept';
    const COUNTRY = 'country';
    const COMMON = 1;
    const SILVER = 2;
    const GOLD = 3;
    const PLATINUM = 4;
    const DIAMOND = 5;
    const GROUP_CUSTOMER = 1; // NHÓM KHÁCH HÀNG
    const SOURCE_CUSTOMER = 2;// NGUỒN KHÁCH HÀNG : fb, TOOL, GOOLE ...
    const RELATIONSHIP = 3;// MÔI QUAN HỆ : MỚI, ĐÃ MUA sp ...
    const BRANCH = 4;// chi nhánh
    const NEW = 1;// mới

    const CALL = 1;// HẸN GỌI LẠI
    const BOOK = 2;// ĐẶT LỊCH
    const RECEIVE = 3;// ĐÃ ĐẾN
    const UN_RECEIVE = 4;// KHÔNG ĐẾN
    const CANCEL = 5;// HỦY

    const NULL = 1;
    const NOT_NULL = 0;

    const ALL = 0;//Tất cả nhóm KH

    const TYPE_ORDER_PROCESS = 0; //Trừ liệu trinh
    const TYPE_ORDER_GUARANTEE = 1; //Đã bảo
    const TYPE_ORDER_RESERVE = 2; //Đang bảo lưu

    const PRODUCT = 2; //sản phẩm
    const SERVICE = 1;//dịch vụ
}
