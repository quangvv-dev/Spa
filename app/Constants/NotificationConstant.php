<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class NotificationConstant
{
    const HIDDEN = 0;//Thông báo ẩn
    const UNREAD = 1;//Thông báo chưa đọc
    const READ = 2;//Thông báo đã đọc

    const CSKH = 2; //công việc CSKH
    const CALL = 1; //công việc gọi điện
    const THU_CHI = 3; // thu chi

    const LICH_HEN = 4;// THÔNG BÁO TỚI TIME HẸN LỊCH CỦA KHÁCH
    const CHUYEN_VI = 5;// CHUYỂN SỐ DƯ VÍ THÀNH CÔNG
    const NAP_VI = 6;//NẠP VÍ THÀNH CÔNG
    const TIN_QC = 7;//TIN GỬI HÀNG LOẠT
    const RUT_TIEN = 8;//TIN GỬI HÀNG LOẠT

}
