{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div id="chart-sracked" class="chartsh c3"--}}
{{--             style="max-height: 256px; position: relative;"></div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div id="chart-pie2" style="width: 500px; height: 300px;"></div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="table-responsive">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">SĐT mới</th>
            <th class="text-white text-center">Số lần trao đổi</th>
            <th class="text-white text-center">Lịch hẹn</th>
            <th class="text-white text-center">Đơn hàng</th>
            <th class="text-white text-center">Doanh thu</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center"><h2>{{ $countCustomer }}</h2></td>
            <td class="text-center"><h2>{{ $groupComments }}</h2></td>
            <td class="text-center"><h2>{{ $books }}</h2></td>
            <td class="text-center"><h2>{{ $orders['sum'] }}</h2></td>
            <td class="text-center"><h2>{{ number_format($orders['count']) }} </h2>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="piechart-1"></div>
    </div>
    {{--    <div class="col-md-6">--}}
    {{--        <div id="piechart-3"></div>--}}
    {{--    </div>--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div id="piechart-2"></div>--}}
    {{--    </div>--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div id="piechart-5"></div>--}}
    {{--    </div>--}}
    <div class="col-md-6">
        <div id="piechart-4"></div>
    </div>
</div>
<div class="col-md-2" style="margin-bottom: 7px;">
    {!! Form::select('type',[2=>'Sản phẩm',1=>'Dịch vụ'], $type, array( 'id'=>'type','class' => 'form-control','required'=>true)) !!}
</div>
<div class="table-responsive">
    <table class="table card-table table-vcenter table-bordered text-nowrap table-primary" id="revenue_product">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Sản phẩm/ Dịch vụ</th>
            <th class="text-white text-center">Số đơn</th>
            <th class="text-white text-center">Doanh thu</th>
        </tr>
        </thead>
        <tbody>
        @foreach($service1 as $k =>$service)
            @if($service->count >0)
                <tr>
                    <td class="text-center">{{$k+1}}</td>
                    <td class="text-center">{{ @$service->service->name.'- '.@$service->booking_id }}</td>
                    <td class="text-center">{{ @$service->count_order}}</td>
                    <td class="text-center"><h3>{{@number_format($service->count)}}</h3></td>
                </tr>
            @endif
        @endforeach

        </tbody>
    </table>
    <div class="pull-right">
        {{ $service1->appends(['search' => request()->search ])->links() }}
    </div>
</div>
@include('customers.script')
