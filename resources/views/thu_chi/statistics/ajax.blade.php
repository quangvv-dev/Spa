<style>
    .font-30 {
        font-size: 20px;
    }

    .h4.text-center {
        color: cornflowerblue;
        font-weight: 600;
        margin-top: 10px;
    }
</style>

<div class="h4 text-center">THỰC THU</div>
<div class="row row-cards">
    <div class="col-md-4 col-xs-12">
        <div class="card overflow-hidden">
            <div class="card-body text-center bg-gradient-gray text-white">
                <div class="h5">Thực thu</div>
                <div class="h3 font-weight-bold mb-4 font-30">
                    {{@number_format($data['payment'] + $data['wallet_payment'] - $data['used'])}}</div>
                <div class="row">
                    <div class="col-12 row">
                        <div class="title col-5">Doanh thu:</div>
                        <div class="col-7">{{@number_format($data['gross_revenue'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Thu nợ:</div>
                        <div
                            class="col-7">{{$data['payment']>$data['gross_revenue'] ? number_format($data['payment']-$data['gross_revenue']):0}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Nạp ví:</div>
                        <div class="col-7">{{@number_format($data['wallet_payment'])}}</div>
                    </div>
                    <div class="col-12 row">
                        <div class="title col-5">Còn nợ:</div>
                        <div class="col-7">{{@number_format($data['payment']-$data['gross_revenue'])}}</div>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card  overflow-hidden bg-gradient-gray text-white">
            <div class="card-body text-center">
                <div class="h5">Tổng doanh số</div>
                <div class="h3 font-weight-bold mb-4 font-30">
                    <span class="">{{@number_format($data['all_total'] + $wallets['revenue'])}}</span>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Sản phẩm:</div>
                    <div class="col-7">{{@number_format($products['all_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Dịch vụ:</div>
                    <div class="col-7">{{@number_format($services['all_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">S.phẩm và Dịch vụ:</div>
                    <div class="col-7">{{@number_format($services['combo_total'])}}</div>
                </div>
                <div class="col-12 row">
                    <div class="title col-5">Nạp ví:</div>
                    <div class="col-7">{{@number_format($wallets['revenue'])}}</div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-gradient-orange" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="col-md-4 col-xs-12">--}}
        {{--<div class="card  overflow-hidden">--}}
            {{--<div class="card-body text-center bg-gradient-gray text-white">--}}
                {{--<div class="h5">Nguồn tiền từ đơn hàng</div>--}}
                {{--<div--}}
                    {{--class="h3 font-weight-bold mb-4 font-30">{{@number_format($data['payment'] + $wallets['payment'])}}</div>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-12 row">--}}
                        {{--<div class="title col-5">Tiền mặt:</div>--}}
                        {{--<div class="col-7">{{@number_format($list_payment['money'])}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-12 row">--}}
                        {{--<div class="title col-5">Thẻ:</div>--}}
                        {{--<div class="col-7">{{@number_format($list_payment['card'])}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-12 row">--}}
                        {{--<div class="title col-5">Chuyển khoản:</div>--}}
                        {{--<div class="col-7">{{@number_format($list_payment['CK'])}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-12 row">--}}
                        {{--<div class="title col-5">Tiêu từ ví:</div>--}}
                        {{--<div class="col-7">{{@number_format($wallets['used'])}}</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="progress progress-sm">--}}
                    {{--<div class="progress-bar bg-gradient-orange" style="width: 100%"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>


<div class="d-none col-xs-none d-md-block">
    <div class="h4 text-center">BIỂU ĐỒ</div>

    <div class="row row-cards">
        <div class="col-md-6">
            <div id="piechart-1" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-3" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-4" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-5" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-6" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-7" style="margin-left: 15px"></div>
        </div>
        <div class="col-md-6">
            <div id="piechart-8" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-12">
            <div id="column" style="margin-left: 15px"></div>
        </div>
    </div>
    <div class="row row-cards">
        <div class="col-md-12">
            <div id="column2" style="margin-left: 15px"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('js/loader.js')}}"></script>
