<div class="bxh bxh-container" style="border:1px solid transparent;">
    @php $int =0;$i =0; @endphp
    @foreach($data as $value)
        @php $int++ ;
        if ($int>=10)
        @endphp
        <div {{$int>10?'style=display:none':''}} class="item-rank" style="right: {{$int*9}}%;top: {{$int*2}}%">
            <div class="king-sale">
                <img src="{{$int==1?'https://pushsale.vn/Portals/_default/Skins/APP/images/bxh/bxh2.png':''}}">
            </div>
            <div class="avatar-container  blink">
                <img class="avatar-img" src="{{asset(@$value['avatar'])}}">
            </div>
            <div class="item-info {{'item-info'.($int)}}">
                <div class="item-stt">{{$int==1 ?'#'.($int):($int)}}</div>
                <div class="item-tennv">{{@$value['full_name']}}</div>
                <div class="">{{number_format($value['gross_revenue'])}}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="table-responsive tableFixHead">
    <table class="table card-table table-center text-nowrap table-primary">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-white text-center">Nhân viên</th>
            <th class="text-white text-center">Số công liệu trình</th>
            <th class="text-white text-center">Tiền công</th>
            <th class="text-white text-center">Tổng số đơn hàng (upsale)</th>
            <th class="text-white text-center">Doanh số</th>
            <th class="text-white text-center">Doanh thu</th>
            <th class="text-white text-center">Hoa hồng</th>
        </tr>
        </thead>
        <tbody>
        @if(@count($data))
            @foreach($data as $k => $s)
                <tr>
                    <td class="text-center"><a href="javascript:void(0)" id="click_detail" data-id="{{$s['id']}}">
                            <i class="fas fa-info-circle"></i>
                            {{@$s->full_name}}</a>
                    </td>
                    <td class="text-center">{{@number_format($s['days'])}}</td>
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
