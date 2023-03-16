<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class OrderConstant
{
    const THE_REST = 1; //còn nợ
    const NONE_REST = 2;//đã thanh toán

    const NHAP_KHO = 1;//Nhập Kho
    const XUAT_KHO = 2;//Xuất kho
    const TIEU_HAO = 3;//Tiêu Hao
    const HONG_VO = 4;//Hỏng vỡ
    const TANG_KHACH = 5;//Hỏng vỡ

    const IS_UPSALE = 1;//đơn upsale
    const NON_UPSALE = 0;//đơn mới

    const WALLET_TYPE_ROSE = 1; // ví nhận hoa hồng
    const WALLET_TYPE_RECEIVE = 2; // chuyển tiền sang ví
    const WALLET_TYPE_MONEY = 3;// Rút tiền từ ví ctv


    const TYPE_DON_NGHI = 0;
    const TYPE_DON_CHECKIN_CHECKOUT = 1;

    const CHO_DUYET = 0; //đơn chờ duyệt
    const DUYET = 1;    //đơn đã duyệt
    const KHONG_DUYET = 2; //đơn không duyệt
}
