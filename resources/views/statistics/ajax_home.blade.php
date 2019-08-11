<style>
    .padding-bottom {
        padding-bottom: 10px;
    }
</style>

<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Khách hàng mới</th>
            <th class="text-white text-center">Tương tác</th>
{{--            <th class="text-white text-center">Hoạt động</th>--}}
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh thu</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center"><h2>{{$customer}}</h2></td>
            <td class="text-center"><h2>{{$books + $receive +$comment}}</h2></td>
{{--            <td class="text-center"><h2>0</h2></td>--}}
            <td class="text-center"><h2>{{$orders}}</h2></td>
            <td class="text-center"><h2>{{number_format((int)$commision+($price_customer?:0 * 20000))}}</h2></td>
        </tr>
        <tr>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Facebook :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Tool Facebook :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Hotline :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Khách Giới Thiệu :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        updating ...
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Trao đổi :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{$comment}}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Lịch hẹn :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{$books}}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Đã đến :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{$receive}}
                    </div>
                </div>
                {{--                <div class="col row padding-bottom">--}}
                {{--                    <div class="col-md-8 col-xs-6 title">--}}
                {{--                        Cuộc gọi :--}}
                {{--                    </div>--}}
                {{--                    <div class="col-md-4 col-xs-6 title">--}}
                {{--                        0--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </td>
            {{--            <td class="text-center">3</td>--}}
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Đơn hàng :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{$orders}}
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Khách hàng mới mua dịch vụ :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{number_format((int)$price_customer * 20000)}}
                    </div>
                </div>
                <div class="col row padding-bottom">
                    <div class="col-md-8 col-xs-6 title">
                        Hoa hồng :
                    </div>
                    <div class="col-md-4 col-xs-6 title">
                        {{number_format((int)$commision)}}
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    {{--<div class="col-md-6">--}}
    {{--<div id="piechart_relation_account" class="row tc">--}}
    {{--</div>--}}
    {{--<div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>--}}
    {{--</div>--}}
    <div class="col-md-6">
        <div id="piechart-1"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-2"></div>
    </div>
</div>
<div class="row">
    {{--<div class="col-md-6">--}}
    {{--<div id="piechart_relation_account" class="row tc">--}}
    {{--</div>--}}
    {{--<div class="ct-tooltip" style="display: none; left: 252px; top: -33px;"></div>--}}
    {{--</div>--}}
    <div class="col-md-6">
        <div id="piechart-3"></div>
    </div>
    <div class="col-md-6">
        <div id="piechart-4"></div>
    </div>
</div>
