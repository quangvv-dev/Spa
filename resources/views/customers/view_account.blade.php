@extends('layout.app')
@section('_style')
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{asset('/assets/plugins/wysiwyag/richtext.min.css')}}" rel="stylesheet"/>
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('zoom-image/css/style.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('zoom-image/css/mobilelightbox.css') }}" media="all">
    <link href="{{ asset('css/progres-bar.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/container-arrow.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('/assets/plugins/simple-lightbox/simple-lightbox.min.css')}}"/>

    <style>
        /*#snoAlertBox1 {*/
            /*position: absolute;*/
            /*z-index: 1400;*/
            /*top: 2%;*/
            /*right: 4%;*/
            /*margin: 0px auto;*/
            /*text-align: center;*/
            /*display: none;*/
        /*}*/

        /*#snoAlertBox2 {*/
            /*position: absolute;*/
            /*z-index: 1400;*/
            /*top: 2%;*/
            /*right: 4%;*/
            /*margin: 0px auto;*/
            /*text-align: center;*/
            /*display: none;*/
        /*}*/

        /*th.text-white.text-center {*/
            /*font-size: 12px;*/
        /*}*/

        /*td.text-center {*/
            /*font-size: 13px;*/
        /*}*/

        /*.margin-left-10 {*/
            /*margin-left: 10px;*/
        /*}*/

        /*.container {*/
            /*max-width: 90%;*/
        /*}*/

        /*a#edit-history-order {*/
            /*color: #007bff !important;*/
            /*font-weight: 600 !important;*/
        /*}*/

        /** {*/
            /*font-size: 14px;*/
        /*}*/

        /*.avatar {*/
            /*border-radius: 50%;*/
        /*}*/

        /*.tabs-menu1 ul li :hover {*/
            /*color: #3b8fec;*/
            /*border-bottom: 3px solid #3b8fec;*/
        /*}*/

        /*.card i {*/
            /*color: #3b8fec;*/
        /*}*/
        /*ul#textcomplete-dropdown-1{*/
            /*z-index: 9999 !important;*/
        /*}*/
        /*.content-custom{*/
            /*max-width: 98%;*/
        /*}*/
        /*!*.page-header{*!*/
            /*!*margin: 0.5rem 0 1.5rem;*!*/
        /*!*}*!*/

        body {
            font-family: svn-small;
        }
        .banner__top {
            background: url("../layout/images/background.png") no-repeat;
            background-size: 100% 100%;
        }
        .banner__top .left {
            padding-top: 44px;
            padding-left: 24px;
        }
        .banner__top .left .dot{
            font-size: 33px;
            padding-bottom: 20px;
        }
        .banner__top .right {
            padding-top: 35px;
            padding-right: 16px;
        }
        .banner__info {
            display: flex;
            align-items: center;
            background: var(--bg-main);
            padding: 6.5px 8px;
            border-radius: 8px;
        }
        .banner__background {
            background: radial-gradient(120.26% 166.07% at -4.23% -32.74%, #1A2749 0%, #253763 36.39%, #121B34 75.39%, #0C1124 100%)
            /* warning: gradient uses a rotation that is not supported by CSS and may not behave as expected */
        ;
            border-radius: 0 0 16px 16px;
        }

        .banner__menu {
            margin-left: 15%;
            height: 52px;
        }

        .banner__menu__item {
            background-position-x: 0px;
            padding-left: 27.5px;
            background-repeat: no-repeat;
            cursor: pointer;

            padding-bottom: 10px;
            display: flex;
            align-items: center;
            margin-top: 13px;
            font-family: svn-small;
            background-position-y: -3px;
            color: #fff;
        }

        .banner__menu__item.active{
            color: var(--color-primary);
            border-bottom: 2px solid;

        }
        .banner__menu__item:hover{
            color: var(--color-primary);
        }




        .communicate {
            background-image: url("../layout/images/communicate.png");
        }

        .communicate.active {
            background-image: url("../layout/images/communicate_active.png");
        }

        .appointment {
            background-image: url("../layout/images/Calendar.png");
        }

        .appointment.active {
            background-image: url("../layout/images/Calendar_active.png");
        }

        .order {
            background-image: url("../layout/images/order.png");
        }

        .order.active {
            background-image: url("../layout/images/order_active.png");
        }

        .calendar {
            background-image: url("../layout/images/CalendarDots.png");
        }

        .calendar.active {
            background-image: url("../layout/images/CalendarDots.png");
        }

        .wallet {
            background-image: url("../layout/images/Dollar.png");
        }

        .wallet.active {
            background-image: url("../layout/images/Dollar.png");
        }

        .gift {
            background-image: url("../layout/images/Gift.png");
        }

        .gift.active {
            background-image: url("../layout/images/Gift.png");
        }

        .discout {
            background-image: url("../layout/images/Discount.png");
        }

        .discout.active {
            background-image: url("../layout/images/Discount.png");

        }

        .hotline {
            background-image: url("../layout/images/Hotline.png");
        }

        .hotline.active {
            background-image: url("../layout/images/Hotline_active.png");
        }

        .albums {
            background-image: url("../layout/images/Album.png");
        }

        .albums.active {
            background-image: url("../layout/images/Album.png");
        }

        .contract {
            background-image: url("../layout/images/Contract.png");
        }

        .contract.active {
            background-image: url("../layout/images/Contract.png");
        }

        .content__left .box {
            border: 1px solid #2E2E2E;
            background: var(--bg-main);
            border-radius: 16px;
            margin-top: 8px;
        }
        .content__left .box span{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .content__left .box .item{
            margin-bottom: 12px;
            border-bottom: 1px solid #2e2e2e;
            padding-bottom: 12px;
        }

        .content__left .box .box__button{
            background: radial-gradient(120.26% 166.07% at -4.23% -32.74%, #1A2749 0%, #253763 36.39%, #121B34 75.39%, #0C1124 100%) padding-box, linear-gradient(130.35deg, #FAF9F7 -2.76%, #2AABE2 53.97%) border-box;
            color: #fff;
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 0 30px;
        }

        .content__right {
            width: 100%;
            /* height: 679px; */
            border-radius: 16px;
            border: 1px solid #2E2E2E;
            position: relative;
        }

        .content__right .content__right__header{
            font-size: 24px;
            font-weight: 700;
            padding: 24px 24px 16px 24px;
            border-bottom:1px solid #2e2e2e;
        }
        .content__right .content__right__body{
            height: 625px;
            overflow-y: auto;
        }
        .content__right .content__right__body .item{
            padding: 24px;
            border-bottom:1px solid #2e2e2e;
            position: relative;
        }
        .last-item {
            margin-bottom: 117px;
        }

        .content__right .content__right__body .item .time{
            border-left: 1px solid;
            padding-left: 8px;
            line-height: 1;
        }
        .content__right .content__right__body .item.high-light{
            background-color: #1b1b1b;
        }
        .content__right .content__right__footer {
            position: absolute;
            border: 0;
            bottom: 0;
            width: 100%;
        }

        .content__right .content__right__footer input {
            background: #2e2e2e;
            padding: 24px 16px;
            font-size: 16px;
            border-radius: 9px;
            outline: none;
            border: none;
            color: #fff;
            width: 100%;
        }
        .content__right .content__right__footer .send {
            position: absolute;
            right: 56px;
            bottom: 48px;
        }
        .content__right .content__right__footer .send img:first-child{
            margin-right: 16px;
        }
        .chat-tag-icon {
            position: absolute;
            top: 0;
            left: 0;
            padding: 4px;
        }
        .ant-avatar {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-variant: tabular-nums;
            line-height: 1.5715;
            list-style: none;
            font-feature-settings: "tnum", "tnum";
            position: relative;
            display: inline-block;
            overflow: hidden;
            color: #fff;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
            width: 32px;
            height: 32px;
            line-height: 32px;
            border-radius: 50%;
            background-color: rgb(150, 217, 201);
        }
    </style>
    @php
        $roleGlobal = auth()->user()?:[];
    @endphp
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="font-size: 0.8rem">
        <div class="d-flex justify-content-between mt-16" style="height: 33px;">
            <div class="d-flex align-items-center gap-4 pointer">
                <img src="{{asset('layout/images/Back.png')}}" alt="">
                <a href="{{ route('customers.index') }}"><span style="color: #fff">Quay lại</span></a>
            </div>
            <div class="">
                <a href="{{ route('customers.edit', $customer->id) }}">
                    <button class="btn btn-gradient btn-icon line-height-1" type="button">
                        <img src="{{asset('layout/images/Edit.png')}}" alt="">
                        <span>Chỉnh sửa</span>
                    </button>
                </a>
            </div>
        </div>


        <div class="banner mt-16">
            <div class="banner__top" style="height: 116px;">
                <div class="d-flex justify-content-between">
                    <div class="left d-flex align-items-center gap-8">
                        <div class="d-flex align-items-center gap-16">
                            <img src="{{$customer->avatar?:'/default/noavatar.png'}}" width="85" height="85" alt="" style="border-radius: 50%;">
                            <span class="color-white linear-text fs-24">{{ $customer->full_name }}</span>
                        </div>

                        <span class="color-white dot">.</span>
                        <div class="fs-16 color-info">
                            <img src="{{asset('layout/images/ChatTeardropDots_active.png')}}" alt="" style="padding-right: 4px;">
                            <span>{{ @$customer->status->name }}</span>
                        </div>
                        <span class="color-white dot">.</span>
                        <div class="color-white banner__info">
                            <img src="{{asset('layout/images/Scan.png')}}" alt="" style="padding-right: 6px;">
                            <span class="fs-14">{{$customer->account_code}}</span>
                        </div>
                        <span class="color-white dot">.</span>
                        <div class="color-white banner__info">
                            <img src="{{asset('layout/images/Call.png')}}" alt="" style="padding-right: 6px;">
                            <span class="fs-14">{{auth()->user()->permission('phone.open') ? $customer->phone : str_limit($customer->phone, 7, 'xxx')}}</span>
                        </div>
                    </div>
                    <div class="right">
                        {{--<img src="{{asset('layout/images/QR.png')}}" alt="" width="65" height="65">--}}
                        <div id="qrcodeTable" style="width: 65px;height: 65px;"></div>
                    </div>
                </div>
            </div>
            <div class="banner__background">
                <div class="banner__menu d-flex align-items-center gap-16 fs-16" style="">
                    <ul class="nav panel-tabs gap-24">
                        <li class=""><a href="#tab5" class="banner__menu__item communicate active" data-toggle="tab">Trao đổi</a>
                        </li>
                        <li><a href="#tab7" class="banner__menu__item appointment" id="click_tab_7" data-id="{{$customer->id}}"
                               data-toggle="tab">Lịch hẹn</a></li>
                        <li>
                            <a href="#tab6" class="banner__menu__item order" id="click_tab_6" data-id="{{$customer->id}}"
                               data-toggle="tab">Đơn hàng</a></li>
                        <li>
                            <a href="#tab8" class="banner__menu__item calendar" id="click_tab_8" data-id="{{$customer->id}}"
                               data-toggle="tab">Lịch CSKH</a></li>
                        @if(empty($permissions) || !in_array('package.customer',$permissions))
                            <li>
                                <a href="#tab10" class="banner__menu__item wallet" id="click_tab_10" data-id="{{$customer->id}}"
                                   data-toggle="tab">Ví tiền</a></li>
                        @endif
                        {{--                                            <li><a href="#tab9" id="click_tab_9" data-phone="{{$customer->phone}}"--}}
                        {{--                                                   data-toggle="tab">Tin nhắn</a></li>--}}
                        <li>
                            <a href="#tabGift" class="banner__menu__item gift" id="click_tab_gift" data-id="{{$customer->id}}"
                               data-toggle="tab">Quà Tặng</a></li>
                        <li>
                            <a href="#tab11" class="banner__menu__item discout" id="click_tab_11" data-phone="{{$customer->phone}}"
                               data-toggle="tab">Khuyến mại</a></li>
                        <li>
                            <a href="#tab12" class="banner__menu__item hotline" id="click_tab_12" data-phone="{{$customer->phone}}"
                               data-toggle="tab">Tổng đài</a></li>
                        <li>
                            <a href="#tab13" class="banner__menu__item albums" id="click_tab_13" data-id="{{$customer->id}}"
                               data-toggle="tab">ALBUMS</a></li>
                        <li>
                            <a href="#tab14" class="banner__menu__item contract" id="click_tab_14" data-id="{{$customer->id}}"
                               data-toggle="tab">Hợp đồng</a></li>
                        <li>
                            <input type="hidden" class="chat-page_id" value="{{@$customer->page_id}}">
                            <input type="hidden" class="chat-sender_id" value="{{@$customer->FB_ID}}">
                            <input type="hidden" class="chat-token" value="{{@$customer->fanpage->access_token}}">
                        </li>
                    </ul>
                </div>
            </div>
        </div>







        <div class="">
            {{--<div class="card-header">--}}
                {{--<div class="col-md-3 no-padd font16"><a class="fl mr10 pic">--}}
                        {{--<img class="avatar" src="{{$customer->avatar?:'/default/noavatar.png'}}"></a>--}}
                    {{--<span class="bold uppercase ">  &nbsp;{{ $customer->full_name }}  </span>--}}
                    {{--<div class="display" id="toolbox" style="width: 28px; height: 20px">--}}
                        {{--<a title="Sửa tài khoản" href="{{ route('customers.edit', $customer->id) }}">--}}
                            {{--<i class="fas fa-pencil-alt"></i></a>--}}
                        {{--<a id="btn_del_account" rel="tooltip"--}}
                           {{--data-placement="bottom"--}}
                           {{--data-original-title="Xóa" class="ml5">--}}
                            {{--<i class="gf-icon-hover icon-remove mr5"></i>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-3 position" rel="tooltip">--}}
                    {{--<div class="no-padd tc mg0">--}}
                        {{--<h1 style="font-size:24px;color: #f36a26;" class="bold mg0">{{number_format($customer->wallet)}}--}}
                            {{--VNĐ</h1>--}}
                        {{--<p>Số dư ví</p></div>--}}
                {{--</div>--}}
                {{--<div class="col-md-1 position" rel="tooltip"></div>--}}

                {{--<div class="col-md-2 no-padd bor-l pl20 mg0 pt10 position hoverlastactive" rel="tooltip"--}}
                     {{--data-original-title="Click thay đổi người phụ trách" data-placement="bottom">--}}
                    {{--<div class="show_change_am" style="cursor:pointer">--}}
                        {{--<div class="avatar">--}}
                            {{--<img class="avatar"--}}
                                 {{--src="{{!empty($customer->telesale->avatar)?$customer->telesale->avatar:'/default/noavatar.png'}}">--}}
                        {{--</div>--}}
                        {{--<div class="info-avatar"><p class="account_manager_name"><a--}}
                                    {{--class="gfname">{{ @$customer->telesale->full_name }}</a>--}}
                            {{--</p>--}}
                            {{--<p class="gray1 font12">Người phụ trách</p></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-1 no-padd tc bor-l mg0"></div>--}}
                {{--<div class="col-md-2 no-padd tc bor-l mg0"><h1 style="font-size:24px;color: #f36a26"--}}
                                                               {{--class="bold mg0">{{number_format($customer->orders->sum('gross_revenue'))}}--}}
                        {{--VNĐ</h1>--}}
                    {{--<p>Giá trị</p></div>--}}
            {{--</div>--}}
            {{--<div style="height:5px" class="color-picker-bg-41"></div>--}}
            <div class="d-flex gap-8" style="margin-top: 8px;">
                <div class="content__left w-232">

                    <div class="d-flex align-items-center w-232 p-16" style="gap: 21px;background-image: url({{asset('layout/images/bg_wallet.png')}});height: 61px;border-radius: 16px;">
                        <span class="color-main">Số dư ví</span>
                        <span class="fs-28">{{number_format($customer->wallet)}}</span>
                    </div>
                    <div class="box p-16">
                        <div class="d-flex align-items-start gap-4">
                            <img src="{{!empty($customer->telesale->avatar)?$customer->telesale->avatar:'/default/noavatar.png'}}" width="36" height="36" alt="" style="border-radius: 50%;">
                            <div class="" style="margin-top: -5px;">
                                <span class="fs-16">{{ @$customer->telesale->full_name }}</span>
                                <div class="fs-12 color-dark">The Pyo Hà Nội</div>
                                <div class="d-flex align-items-center gap-8">
                                    <img src="{{asset('layout/images/Hotline_active.png')}}" width="12" height="12" alt="">
                                    <span class="fs-12 color-info">Người phụ trách</span>
                                </div>
                            </div>
                        </div>
                        <div class="box__button mt-16">
                            <img src="{{asset('layout/images/Iocn.png')}}" alt="">
                            <span>DT: {{number_format($customer->orders->sum('gross_revenue'))}}</span>
                        </div>
                    </div>

                    <div class="full2 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2">
                            <div class="row">
                                <div class="col-md-8">
                                    <span class="uppercase pb5 mb10 font12 bold mg0">Mối quan hệ</span>
                                    <div>{{ @$customer->status->name }}</div></div>
                                <div class="col-md-4 qrcode-container">
                                    <div id="qrcodeTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="full2 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-random mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Nguồn</span>
                                        </i>
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ @$customer->source_customer->name }}</div>
                                </div>
                                <div class="col-md-4">
                                    <span class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-user mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Người tạo</span>
                                        </i>
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ @$customer->marketing->full_name }}</div>
                                </div>
                                <div class="col-md-4">
                                    <span class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-calendar mr5 gray margin-left-10 tooltip-nav">&nbsp;
                                            <span class="tooltiptext">Ngày Tạo</span>
                                        </i>
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <div
                                        class="text-a">{{ \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <span class="uppercase pb5 mb10 font12 bold mg0"><i
                                            class="fa fa-shopping-cart mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Đơn</span>
                                        </i>
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ $customer->orders->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border padding mt10 ml2">
                        <div class="infor-top-ct">
                            <span class="uppercase mb10 fs-16 linear-text bold mg0 " style="margin-bottom: 10px!important;">Thông tin khách hàng</span>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Chi nhánh:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->branch->name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Người phụ trách:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->telesale->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">CSKH:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->cskh->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Liên hệ cuối:</p>
                                <p class="word-wrap text-danger"> &nbsp;{{ @diffTime($customer->last_time) }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Nhóm giới tính:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->genitive->name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Nguồn KH:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->source_customer->name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Sinh nhật:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->birthday }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Mối quan hệ:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->status->name }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Ngày tạo:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->created_at }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Giới tính:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->genderText }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Mô tả:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->description }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Số đơn hàng:</p>
                                <p class="word-wrap "> &nbsp;{{ $customer->orders->count() }}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Tổng doanh thu:</p>
                                <p class="word-wrap">
                                    &nbsp;{{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Tổng số tương tác:</p>
                                <p class="word-wrap">&nbsp;0</p>
                            </div>
                            <div class="mb10 clearfix fs-14"><p class="bold pr5 fl">Giá trị:</p>
                                <p class="word-wrap">
                                    &nbsp;{{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                 {{---------- Trao đổi--------}}
                <div class="no-padd spanfull2 padding" style="width: calc(100% - 232px)">
                    <div class="">
                        <div class="panel panel-primary">
                            @if(count($customer->historyStatus))
                                <div class="tab-menu-heading" style="padding: 3px">
                                    @include('customers._include.container_arrow')
                                </div>
                            @endif
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content" style="font-size: 15px;">
                                    <div class="tab-pane active " id="tab5">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="content__right">
                                                <div class="content__right__header font-sopher">
                                                    Trao đổi
                                                </div>
                                                <div class="p-24">
                                                    {!! Form::open(array('url' => url('group_comments/'.request()->segment(count(request()->segments())) ), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                                                    <input type="text" name="messages" placeholder="Nhập tin nhắn....." style="background: #2e2e2e;padding: 24px 16px;width: 100%;color: #fff">
                                                    <img id="blah" src="#" class="d-none" width="42" height="42" style="position: absolute; top: 38px; right: 115px;object-fit: cover;"/>

                                                    <div class="send">
                                                        <div class="form-group required">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn btn-file">
                                                                        <span class="fileupload-new">
                                                                             <img src="{{asset('layout/images/Image_3.png')}}" class="pointer upload-file" alt="">
                                                                        </span>
                                                                        <span class="fileupload-exists">
                                                                            <img src="{{asset('layout/images/Image_3.png')}}" class="pointer upload-file" alt="">
                                                                        </span>
                                                                        <input type="file" name="image_contact" accept="image/*" class="btn-default upload"/>
                                                                    </button>
                                                                    <button type="submit" class="btn">
                                                                        <img src="{{asset('layout/images/Send.png')}}" class="pointer" alt="" type="submit">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{ Form::close() }}
                                                </div>
                                                <div class="content__right__body" id="registration-form">
                                                    @include('group_comment.ajax')
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tab6">
                                        <div class="card-header row">
                                            <div class="col-md-8" style="display: flex">
                                                <div class="button">
                                                    <a href="javascript:void(0)" data-value=""
                                                       class="type-order btn btn-warning">Tất cả</a>
                                                    <a href="javascript:void(0)" data-value="1"
                                                       class="type-order btn btn-success">Dịch vụ</a>
                                                    <a href="javascript:void(0)" data-value="2"
                                                       class="type-order btn btn-danger">Sản phẩm</a>
                                                    <a href="javascript:void(0)" data-value="3"
                                                       class="type-order btn btn-info">S.phẩm & D.vụ</a>
                                                </div>
                                                <input type="hidden" id="order_value">
                                                <div class="select" style="margin-left: 4px">
                                                    {!! Form::select('the_rest', $the_rest, null, array('class' => 'form-control','id'=>'the_rest','placeholder'=>'Tất cả đơn')) !!}
                                                </div>

                                            </div>
                                            <div class="col relative">
                                                @if($roleGlobal->permission('order.add'))
                                                    <a class="right btn btn-primary text-white"
                                                       data-toggle="modal"
                                                       data-target="#roleTypeModal">Tạo mới</a>
                                                @endif
                                            </div>
                                            @include('order.role_type_modal')

                                        </div>
                                        <div id="order_customer">
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab7">
                                        @include('schedules.index')
                                    </div>
                                    <div class="tab-pane" id="tab8">
                                        <div class="card-header row">
                                            <div class="col">
                                                {{--@if($roleGlobal->permission('tasks.index'))--}}
                                                <a class="right btn btn-primary text-white"
                                                   data-toggle="modal"
                                                   data-target="#modalTask" id="createTask">Tạo mới</a>
                                                {{--@endif--}}
                                            </div>
                                        </div>
                                        <div class="col index-task"></div>
                                        @include('tasks.modal')
                                    </div>
                                    {{--    Modal thêm --}}
                                    @include('schedules.modal')
                                    {{--    END Modal thêm --}}
                                    <div class="tab-pane " id="tab10">
                                        @if(count($wallet))
                                            @include('wallet.history')
                                        @endif
                                    </div>
                                    <div class="tab-pane" id="tab9">
                                        <div id="content_tab9">
                                            @if(count($history))
                                                @include('sms.history')
                                            @endif
                                        </div>
                                        @include('customers.modal-sendSMS')
                                    </div>
                                    <div class="tab-pane " id="tab11">
                                        @if(count($customer_post))
                                            @include('post.history')
                                        @endif
                                    </div>
                                    <div class="tab-pane " id="tab12">
                                        @include('call_center.customer')
                                    </div>
                                    <div class="tab-pane" id="tab13">
                                        @include('albums.index')
                                    </div>
                                    <div class="tab-pane" id="tabGift">
                                        @include('gifts.ajax')
                                    </div>
                                    <div class="tab-pane" id="tab14">
                                        @include('customers._include.contact')
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/js/player.js"></script>
@endsection
@section('_script')
    <script src="{{ asset('zoom-image/js/mobilelightbox.js') }}"></script>
    <script src="{{ asset('zoom-image/js/main.js') }}"></script>
    <script src="{{asset('/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script src="{{asset('assets/js/util.js')}}"></script> <!-- util functions included in the CodyHouse framework -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script src="{{asset('js/jquery.textcomplete.min.js')}}"></script>
    <script src="{{asset('assets/plugins/simple-lightbox/simple-lightbox.min.js?v2.8.0')}}"></script>

    <script type="text/javascript">

        $('.autocomplete-textarea').textcomplete([{
            match: /(^|\s)@(\w*(?:\s*\w*))$/,

            search: function (query, callback) {
                let data = [{
                    name: "Tên khách hàng",
                    value: "%full_name%"
                },{
                    name: "Chi nhánh",
                    value: "%branch%"
                }, {
                    name: "SĐT chi nhánh",
                    value: "%phoneBranch%"
                },{
                    name: "Địa chỉ chi nhánh",
                    value: "%addressBranch%"
                }];
                callback(data);
            },

            template: function (hit) {
                // phan hien thi o dropdown
                let html = `
            <a class="tag-item" href="">
            <span class="label">${hit.name} <img width="40" src='{{asset('/assets/images/brand/logo.png')}}'/></span>
            </a>`;
                return html;
            },

            replace: function (hit) {
                // phan hien thi khi
                return hit.value.trim();
            }
        }]);

        // $(document).ready(function () {
        $(document).on('click', '#save_schedules', function (e) {
            let name = $('#update_status :selected').text();
            let ids = $('#update_id').val();
            $.post($('.formUpdateSchedule').attr('action'), $('.formUpdateSchedule').serialize(), function (data) {
                $('#updateModal').modal('hide');
            });
            $(".status[data-id='" + ids + "']").html(name);
        })
        $(document).on('click', '#click_tab_7', function () {
            const id = $(this).data('id');
            $('#tab7').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {schedules: 1, member_id: id}
            }).done(function (data) {
                $('#tab7').html(data);
            });
        })
        $(document).on('click', '.name-task', function () {
            $('#modalUpdateTask').modal('show');
            let id = $(this).data('id');
            $.ajax({
                url: "/ajax/tasks/"+id,
                method: "get",
                // data: {member_id: id}
            }).done(function (data) {
                $('#name_update').val(data.name);
                $('.date_update').val(data.date_from.toLocaleString());
                console.log(data,'123123');
                $('.time_from').val(data.time_from).change();
                // $('.time_to').val(data.time_to);
                $('#updateType').val(data.type).change();
                $('#description_update').val(data.description);
                $('.formUpdateTask').attr('action', "/tasks/"+data.id).change();

                // $('#order_customer').html(data);
            });
        });
        $(document).on('click', '#click_tab_6', function () {
            const id = $(this).data('id');
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {member_id: id}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        });
        $(document).on('click', '#click_tab_14', function () {
            const id = $(this).data('id');
            $('#tab14').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {contact: id}
            }).done(function (data) {
                $('#tab14').html(data);
            });
        });

        $(document).on('click', '#click_tab_gift', function () {
            const id = $(this).data('id');
            $('#tabGift').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url('gifts') }}",
                method: "get",
                data: {customer_id: id}
            }).done(function (data) {
                $('#tabGift').html(data);
            });
        })
        $(document).on('click', '#click_tab_8', function () {
            const id = $(this).data('id');
            $('.index-task').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {tasks: id}
            }).done(function (data) {
                $('.index-task').html(data);
            });
        })

        $(document).on('click', '.type-order', function () {
            const id = $(this).data('value') > 0 ? $(this).data('value') : "";
            $('#order_value').val(id).change();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {role_type: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        })
        $(document).on('change', '#the_rest', function () {
            let id = $(this).val();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {the_rest: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        })
        $(document).on('click', ' #order_customer.page-link', function () {
            let id = $(this).html();
            let the_rest = $('#the_rest').val();
            let role_type = $('#order_value').val();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {the_rest: the_rest, role_type: role_type, page_order: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
            return false
        })

        {{--$(document).on('click', '#click_tab_9', function () {--}}
        {{--    const phone = $(this).data('phone');--}}
        {{--    $('#content_tab9').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');--}}

        {{--    $.ajax({--}}
        {{--        url: "{{url()->current() }}",--}}
        {{--        method: "get",--}}
        {{--        data: {history_sms: phone}--}}
        {{--    }).done(function (data) {--}}
        {{--        $('#content_tab9').html(data);--}}
        {{--    });--}}
        {{--})--}}
        $(document).on('click', '#click_tab_10', function () {
            const id = $(this).data('id');
            $('#tab10').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {history_wallet: id}
            }).done(function (data) {
                $('#tab10').html(data);
            });
        })
        $(document).on('click', '#click_tab_11', function () {
            const phone = $(this).data('phone');
            $('#tab11').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {post: phone}
            }).done(function (data) {
                $('#tab11').html(data);
            });
        })
        $(document).on('click', '#click_tab_12', function () {
            const phone = $(this).data('phone');
            $('#tab12').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {call_center: phone}
            }).done(function (data) {
                $('#tab12').html(data);
            });
        })
        $(document).on('click', '#click_tab_13', function () {
            const id = $(this).data('id');
            $('#tab13').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {albums: id}
            }).done(function (data) {
                $('#tab13').html(data);
            });
        })
        $(document).on('dblclick', '.order-type', function () {
            const id = $(this).data('id');
            let target = $(this);
            target.empty();

            $.ajax({
                url: "{{ Url('ajax/orders/') }}" + '/' + id,
                method: "get",
                data: {id: id}
            }).done(function (data) {
                let html = "";

                html +=
                    `<select class="list-type form-control select2" data-id=" ` + data.order.id + `" name="type">`;
                html +=
                    `<option value="2" ` + (2 === data.order.type ? "selected" : "") + `> Trong liệu trình </option>
                            <option value="3" ` + (3 === data.order.type ? "selected" : "") + `> Đã bảo hành </option>
                            <option value="4" ` + (4 === data.order.type ? "selected" : "") + ` > Đang bảo lưu </option>
                        </select>`;

                target.append(html);

                $('.select2').select2({ //apply select2 to my element
                    allowClear: true
                });
            });
        });

        $(document).on('change', '.list-type', function (e) {
            let target = $(this);
            const id = target.data('id');
            const type = target.val();

            $.ajax({
                url: "{{ Url('ajax/update-type-orders/') }}" + '/' + id,
                method: "put",
                data: {
                    type: type,
                }
            }).done(function (data) {
                target.parent().parent().find('.order-type').html(data);
            });
        });

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        var historys = '';
        var order_details = '';

        $(document).on('click', '#edit-history-order', function (e) {
            e.preventDefault();
            $('.data-history-update-order').empty();
            let id = $(this).data('order-id');
            let html = `<option value="0" >Tất cả</option>`;
            $.ajax({
                type: 'get',
                url: "{{ Url('ajax/services-with-order/') }}" + "/" + id,
                success: function (res) {
                    res.forEach(element => {
                        html += `<option value="` + element.id + `">` + element.name + `</option>`;
                    });
                    $('#list_service').html(html);
                }
            })
            $.ajax({
                url: "{{ Url('ajax/orders/') }}" + '/' + id,
                method: "get",
            }).done(function (data) {
                let html = '';
                historys = data.history_update_orders;
                order_details = data.order_details;
                // console.log(data.history_update_orders.reverse());

                data.history_update_orders.reverse().forEach(function (item, index) {
                    let name = item.service != null ? item.service.name : '';
                    var name_type = '';
                    if (item.type == 0) {
                        name_type = 'Trừ liệu trình';
                    }
                    if (item.type == 1) {
                        name_type = 'Đã bảo hành';
                    }
                    if (item.type == 2) {
                        name_type = 'Đang bảo lưu';
                    }
                    let fullname = item.user && item.user.full_name ?item.user.full_name:'';
                    let name_support = item.support && item.support.full_name ?item.support.full_name:'';
                    let name_support2 = item.support2 && item.support2.full_name ?' | '+item.support2.full_name:'';
                    html += '<tr >' + '<td class="text-center">' + index + '</td>' +
                        '<td class="text-center">' + item.created_at + '</td>' +
                        '<td class="text-center">' + fullname + '</td>' +
                        '<td class="text-center">' + name_support +name_support2 +'</td>' +
                        '<td class="text-center">' + name + '</td>' +
                        '<td class="text-center">' + (item.description ? item.description : '') + '</td>' +
                        '<td class="text-center">' + (name_type ? name_type : '') + '</td>' +
                        '<td class="text-center"><a class="sum_history_order" href="javascript:void(0)" data-id="' + item.id + '"data-type="' + item.type + '"data-order="' + item.order_id + '"> <i class="fas fa-trash-alt"></i></a></td>' + '</tr>';
                });
                $('.data-history-update-order').append(html);
                $('#largeModal').modal("show");
            });

            $(document).change('#list_service', function () {
                let id = $('#list_service').val();
                let html = '';
                console.log(id, 'idđ');
                historys.forEach(function (item, index) {
                    let name = item.service != null ? item.service.name : '';
                    let service_id = item.service != null ? item.service.id : 0;
                    var name_type = '';
                    if (item.type == 0) {
                        name_type = 'Trừ liệu trình';
                    }
                    if (item.type == 1) {
                        name_type = 'Đã bảo hành';
                    }
                    if (item.type == 2) {
                        name_type = 'Đang bảo lưu';
                    }
                    if (service_id == id || id == 0) {
                        html += '<tr >' + '<td class="text-center">' + index + '</td>' +
                            '<td class="text-center">' + item.created_at + '</td>' +
                            '<td class="text-center">' + item.user.full_name + '</td>' +
                            '<td class="text-center">' + name + '</td>' +
                            '<td class="text-center">' + (item.description ? item.description : '') + '</td>' +
                            '<td class="text-center">' + (name_type ? name_type : '') + '</td>' +
                            '<td class="text-center"><a class="sum_history_order" href="javascript:void(0)" data-id="' + item.id + '"data-type="' + item.type + '"data-order="' + item.order_id + '"> <i class="fas fa-trash-alt"></i></a></td>' + '</tr>';
                    }
                });
                let detail = order_details.filter(f => f.booking_id == id);
                $('#count_service').html(detail.length > 0 ? 'Số buổi còn lại: ' + detail[0].days : '');
                $('.data-history-update-order').html(html);

            });

            $('body').delegate('.sum_history_order', 'click', function () {
                const order_id = $(this).data('order');
                const id = $(this).data('id');
                const type = $(this).data('type');
                $.ajax({
                    type: 'PUT',
                    url: "{{ Url('ajax/orders_sum/') }}" + "/" + order_id,
                    data: {
                        history_id: id,
                        type: type,
                    },
                    success: function (res) {
                        if (res == 'Success') {
                            alert("Xử lý liệu trình thành công");
                        } else if (res == "Failed")
                            alert("Số liệu trình đã hết");
                        window.location.reload();
                    }
                })
                // })
            });

        });

        $(document).on('click', '.edit-order', function () {
            let id = $(this).data('order-id');
            let html = "";
            //
            $.ajax({
                type: 'get',
                url: "{{ Url('ajax/services-with-order/') }}" + "/" + id,
                success: function (res) {
                    res.forEach(element => {
                        html += `<option value="` + element.id + `">` + element.name + `</option>`;
                    });
                    $('#service_modal').html(html);
                    $('#updateHistoryOrderModal').modal('show');
                }
            })
            //
            $('.save-update-history-order').click(function () {
                swal({
                    title: 'Bạn có muốn xử  liệu trình ?',
                    showCancelButton: true,
                    cancelButtonClass: 'btn-secondary waves-effect',
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'OK'
                }, function () {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ Url('ajax/orders/') }}" + "/" + id,
                        data: $('#historyUpdateOrrder').serialize(),
                        success: function (res) {
                            if (res == 'Success')
                                alert("Cập nhật liệu trình thành công");
                            else if (res == "Failed")
                                alert("Số liệu trình đã hết");
                            window.location.reload();
                        }
                    })
                })
            });
        });

        $(function (e) {
            $('.messages').richText();
        });

        $(document).on('click', '.btn-edit-comment', function (e) {
            const target = $(e.target).parent().parent().parent().parent();
            const group_comment_id = $(this).data('id');

            $.ajax({
                url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/edit",
                method: "get",
            }).done(function (data) {

                let html = `
            {!! Form::open(array('method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                    <div class="col-md-12">
                        <textarea name="messages" class="form-control message" rows="3" data-id="` + data.id + `">` + data.messages + `</textarea>
                    </div>
                    <div class="col-xs-12 col-md-12 file-upload">
                        <div class="form-group required">
                            <div class="fileupload fileupload-new"
                                 data-provides="fileupload">
                                 <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px">

                                </div>
                                <button type="button" class="btn btn-default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                                    <input type="file" name="image_contact" accept="image/*" class="btn-default upload" data-id="11"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button style="float: right; margin-top: 10px;" type="submit"
                                class="btn btn-success update-messages">Gửi
                        </button>
                    </div>
                    {{ Form::close() }}`;
                $(target).find('.comment').empty();
                $(target).find(".comment").append(html);
            });
        });

        $(document).on('click', '.update-messages', function (e) {
            e.preventDefault();
            const target = $(e.target).parent().parent().parent().parent();
            let formData = new FormData();
            const messages = $(target).find('.message').val();
            const image_contact = $(target).parent().parent().find('.upload')[0].files[0];
            formData.append('image_contact', image_contact);
            formData.append('messages', messages);

            const id = $(target).find('.message').data('id');

            $.ajax({
                url: "{{ Url('group-comments/') }}" + "/" + id + "/edit",
                method: "post",
                processData: false,
                contentType: false,
                data: formData
            }).done(function (data) {
                window.location.reload();
            });
        });

        $(document).on('click', '.btn-delete-comment', function (e) {
            const target = $(e.target).parent().parent().parent().parent();
            const group_comment_id = $(this).data('id');

            const result = confirm("Bạn muốn xoá tin nhắn này?");
            if (result) {
                $.ajax({
                    url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/delete",
                    method: "delete",
                }).done(function () {
                    $(target).parent().find(".row").remove();
                });
            }
        });

        $(document).ready(function () {
            $(document).on('dblclick', '.status', function (e) {
                let target = $(e.target).parent();
                $(target).find('.status').empty();
                let id = $(this).data('id');
                let html = '';

                $.ajax({
                    url: "{{ Url('ajax/status-schedules/') }}",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="status-result form-control" data-id="' + data.schedule_id + '" name="status">' +
                        '<option value="">' + "Chọn trạng thái" + '</option>';
                    data.data.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".status").append(html);
                });
            });

            $(document).on('change', '.status-result', function (e) {
                let target = $(e.target).parent();
                let status = $(target).find('.status-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ Url('ajax/schedules/') }}" + '/' + id,
                    method: "put",
                    data: {
                        status: status
                    }
                }).done(function () {
                    window.location.reload();
                });
            });

            $('body').delegate('.update', 'click', function (e) {
                let id = $(this).attr("data-id");
                let link = 'schedules/edit/' + id;
                $.ajax({
                    url: window.location.origin + '/' + link,
                    method: "get",
                }).done(function (data) {
                    $('#update_id').val(data['id']);
                    $('#update_date').val(data['date']);
                    $('#update_time1').val(data['time_from']);
                    $('#update_time2').val(data['time_to']);
                    $('#update_status').val(data['status']);
                    $('#update_note').val(data['note']);
                    $('#update_type').val(data['type']).change();
                    $('#update_category').val(data['category_id']).change();
                    $('.branch').val(data['branch_id']).change();
                    $('#update_action').val(data['person_action']).change();
                });
            });
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
                startDate: new Date(),
            });
            $("#fvalidate").validate({
                rules: {
                    note: {
                        required: true
                    },
                    time_from: {
                        required: true
                    },
                    time_to: {
                        required: true
                    },
                },
                messages: {
                    note: "Không được để trống !!!",
                    time_from: "Không được để trống !!!",
                    time_to: "Không được để trống !!!",
                },
            });
        });
        // });
        // $(document).on('click','#click_tab_14',function () {
        //     let page_id = $('.chat-page_id').val();
        //     let sender_id = $('.chat-sender_id').val();
        //     let token = $('.chat-token').val();
        //     getMessage(page_id,sender_id,token);
        // })
    </script>
    <script src="{{asset('js/jquery.qrcode.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            jQuery('#qrcodeTable').qrcode({
                text	: "{{$customer->account_code}}",
                height:65,
                width:65
            });
        });
    </script>
    <script>
        $(document).on("click", ".upload-file", function () {
            $(".file").click();
        });

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file);
                $("#blah").removeClass("d-none");
            }
        }
    </script>
    {{--@include('message_fb.js_chat_app')--}}
@endsection
