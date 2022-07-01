{{--<div class="card-header" style="margin-bottom: 11%;border-bottom: none;">--}}
    {{--<div class="bxh bxh-container" style="border:1px solid transparent;">--}}
        {{--@foreach($data as $value)--}}
            {{--@php $int++ ;--}}
        {{--if ($int>=10)--}}
            {{--@endphp--}}
            {{--<div {{$int>10?'style=display:none':''}} class="item-rank" style="right: {{$int*9}}%;top: {{$int*2}}%">--}}
                {{--<div class="king-sale">--}}
                    {{--<img src="{{$int==1?asset('default/bxh2.png'):''}}">--}}
                {{--</div>--}}
                {{--<div class="avatar-container  blink">--}}
                    {{--<img class="avatar-img" src="{{asset(@$value['avatar'])}}">--}}
                {{--</div>--}}
                {{--<div class="item-info {{'item-info'.($int)}}" style="font-size: 12px">--}}
                    {{--<div class="item-stt">{{$int==1 ?'#'.($int):($int)}}</div>--}}
                    {{--<div class="item-tennv">{{@$value['full_name']}}</div>--}}
                    {{--<div >{{number_format($value['gross_revenue'])}}</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
@php $i =0; @endphp

<div class="table-responsive tableFixHead">
    <table class="table card-table table-center text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">STT</th>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Số công chính</th>
            <th class="text-white text-center">Số công phụ</th>
            <th class="text-white text-center">Tiền công liệu trình</th>
            <th class="text-white text-center">Tổng số đơn hàng (upsale)</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Hoa hồng</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($data))
            @foreach($data as $s)
                @php $i ++; @endphp
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td class="text-center"><a href="javascript:void(0)" id="click_detail" data-id="{{$s['id']}}">
                            <i class="fas fa-info-circle"></i>
                            {{@$s['full_name']}}</a>
                    </td>
                    <td class="text-center">{{@number_format($s['days'])}}</td>
                    <td class="text-center">{{@number_format($s['days_phu'])}}</td>
                    <td class="text-center">{{@number_format($s['price'])}}</td>
                    <td class="text-center">{{@number_format($s['orders'])}}</td>
                    <td class="text-center">{{@number_format($s['all_total'])}}</td>
                    <td class="text-center">{{@number_format($s['gross_revenue'])}}</td>
                    <td class="text-center">{{@number_format($s['earn'])}}</td>
                </tr>
        </tbody>
        @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="10">Không tồn tại dữ liệu</td>
            </tr>
        @endif
    </table>
</div>
