@extends('layout.app')
    @section('content')
{{--        <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>--}}
        <main id="maincontent" class="page-main wrapper payment">
            <div class="row row-cards">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="page-title-box">
                            <h4 class="page-title float-left"></h4>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
                <div class="row" style="">
                    <div class="col-sm-12 col-lg-9 ">
                        <div class="invoice">
                            <div class="text-center"><strong style="font-size: 20px">ĐƠN HÀNG BÁN</strong></div>
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr class="trfirst">
                                        <td style="width:50%">
                                            <b>Tên khách hàng:</b>&nbsp; <a class="blue" href="">{{session('info-temp')->full_name}}</a>
                                        </td>
                                        <td style="width:50%">
                                            <b>Người xử lý:</b>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%">
                                            <b>Địa chỉ email:</b>&nbsp; {{@session('info-temp')->email}}
                                        </td>
                                        <td style="width:50%">
                                            <b>Ngày xử lý:</b>&nbsp;

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%">
                                            <b>Điện thoại:</b>&nbsp;{{@session('info-temp')->phone}}
                                        </td>
                                        <td style="width:50%">
                                            <b>Phương thức thanh toán:</b>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%">
                                            <b>Ngày thanh toán:</b> {{$historyOrder->payment_date}}
                                        </td>
                                        <td style="width:50%">
                                            <b></b>&nbsp;

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered mt10">
                                    <tbody>
                                    <tr class="bold b-gray">
                                        <td class="padding5">STT</td>
                                        <td class="padding5">Mã khóa học</td>
                                        <td class="padding5">Tên khóa học</td>
                                        <td class="padding5">Đơn giá</td>
                                        <td class="padding5">VAT (%)</td>
                                        <td class="padding5">CK (%)</td>
                                        <td class="padding5">CK (đ)</td>
                                        <td class="padding5">Thành tiền</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold" colspan="7">Tổng</td>
                                        <td class="tr bold">{{number_format($order->gross_revenue)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold" colspan="7">Chiết khấu trước thuế %</td>
                                        <td class="tr">0</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold" colspan="7">Thuế VAT %</td>
                                        <td class="tr"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold" colspan="7">Tổng cộng</td>
{{--                                        <td class="tr bold">{{number_format(\App\Helpers\Functions::totalPrice($arrLectureCart))}}</td>--}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

{{--                    <div class="col-sm-12 col-md-3 no-padd bor-r" id="right_panel">--}}
{{--                        <div>--}}
{{--                            <div class="col-md-12 no-padd box-cont">--}}
{{--                                <div id="attachments" class="files padding">--}}
{{--                                    <div>--}}
{{--                                        <div id="progress" class="progress" style="display:none">--}}
{{--                                            <div class="progress-bar progress-bar-success" role="progressbar"></div>--}}
{{--                                        </div>--}}
{{--                                        <div id="files" class="files"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="box-cont col-md-12 no-padd content-pay">--}}
{{--                                <h3 class="bor-bot uppercase font12 mg0 bold padding5">Thanh toán--}}
{{--                                    <span class="status {{$order->status == \App\Constants\OrderConstant::DA_THANH_TOAN ? 'da-thanh-toan' : 'cho-xu-ly'}}">--}}
{{--                                        ({{$order->status == \App\Constants\OrderConstant::DA_THANH_TOAN ? 'Đã thanh toán' : 'Đang chờ xử lý'}})--}}
{{--                                    </span></h3>--}}

{{--                                <div class="padding col-md-12">--}}
{{--                                    <table>--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th width="56%"></th>--}}
{{--                                            <th width="44%"></th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        <tr>--}}
{{--                                            <td class="mb5">Đã thanh toán:</td>--}}
{{--                                            <td class="tr mb5" id="gross_revenue1">{{$order->status == \App\Constants\OrderConstant::DA_THANH_TOAN ? number_format($order->total_price) : ''}}</td>--}}
{{--                                        </tr><tr>--}}
{{--                                            <td class="mb5">Còn lại:</td>--}}
{{--                                            <td class="tr mb5" id="the_rest">0</td>--}}
{{--                                        </tr>--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="detail-pay-dvh position col-md-12 no-padd">--}}
{{--                                <h3 class="bor-bot uppercase font12 mg0 bold padding5">Lịch sử thanh toán</h3></div>--}}
{{--                            <div class="col-md-12 no-padd">--}}
{{--                                <table class="table table-bordered">--}}
{{--                                    <thead class="b-gray">--}}
{{--                                    <tr class="bor-bot">--}}
{{--                                        <th class="tl pl10 gray" width="30%" style="text-transform:initial;">Ngày</th>--}}
{{--                                        <th class="tc gray" width="30%" style="text-transform:initial;">Số tiền</th>--}}
{{--                                        <th class="tc gray" width="60%" style="text-transform:initial;">Ghi chú</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody id="payment-history">--}}
{{--                                        @foreach($historyOrder as $item)--}}
{{--                                            <tr data-payment-id="628">--}}
{{--                                                <td class="tc pl10">{{date('d-m-Y', strtotime($item->payment_date))}}</td>--}}
{{--                                                <td class="tc">{{number_format($item->price)}}</td>--}}
{{--                                                <td>{{$item->description}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="row">
                    <div class="list_task_footer col-md-12 padding">
                        <div class="fl task_footer_box cancel_order">
                            <button class="btn btn-default fr ml5">
                                <a href="/home">Trở lại</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

