@php
    $all_customer = 0;
    $call = 0;
    $receive = 0;
@endphp
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white">STT</th>
            <th class="text-white text-center">Ngày tạo</th>
            <th class="text-white text-center">Chiến dịch</th>
            <th class="text-white text-center">Tổng khách nhận được</th>
            <th class="text-white text-center">Khách đã gọi</th>
            <th class="text-white text-center">Khách đã đến</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($response))
            @foreach($response as $k => $s)
                @php
                    $all_customer   += $s->all_customer;
                    $call           += $s->call;
                    $receive        += $s->receive;
                @endphp
                <tr>
                    <th scope="row">{{$k+1}}</th>
                    <td class="text-center">{{@$s->created_at}}</td>
                    <td class="text-center">{{@$s->name}}</td>
                    <td class="text-center">{{@$s->all_customer}}</td>
                    <td class="text-center">{{@$s->call}}</td>
                    <td class="text-center">{{@$s->receive}}</td>
                </tr>
            @endforeach
            <tr class="fixed">
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center bold">Tổng cộng</td>
                <td class="text-center bold">{{@number_format($all_customer)}}</td>
                <td class="text-center bold">{{@number_format($call)}}</td>
                <td class="text-center bold">{{@number_format($receive)}}</td>
            </tr>
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="6">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    {{--<div class="pull-left">--}}
    {{--<div class="page-info">--}}
    {{--{{ 'Tổng số ' . $docs->total() . ' bản ghi ' . (request()->search ? 'found' : '') }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="pull-right">--}}
    {{--{{ $docs->appends(['search' => request()->search ])->links() }}--}}
    {{--</div>--}}
</div>
