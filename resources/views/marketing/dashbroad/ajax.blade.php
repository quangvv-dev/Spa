<div  class="tableFixHead" id="registration-form">
    <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
        <thead class="bg-primary text-white">
        <tr>
            <th class="text-center" colspan="8">THÔNG TIN NGUỒN</th>
            <th class="text-center" colspan="9">THÔNG TIN HIỆU QUẢ MARKETING</th>
        </tr>
        <tr class="tr1" style="text-transform:unset">
            <th class="text-center">STT</th>
            <th class="text-center">Marketing</th>
            <th class="text-center no-wrap">Nguồn dữ liệu</th>
            <th class="text-center">Nhóm dịch vụ</th>
            <th class="text-center">Kênh quảng cáo</th>
            <th class="text-center">Ngân sách</th>
            <th class="text-center">Số contact</th>
            <th class="text-center">Giá contact</th>
            <th class="text-center">Lịch hẹn</th>
            <th class="text-center">Lịch hẹn đến</th>
            <th class="text-center">Đơn chốt</th>
            <th class="text-center">Số $/KH đến</th>
            <th class="text-center no-wrap">Tỷ lệ đến/SĐT</th>
            <th class="text-center no-wrap">Doanh số</th>
            <th class="text-center no-wrap">Doanh thu</th>
        </tr>
        <tr class="number_index">
            <th class="text-center">(1)</th>
            <th class="text-center">(2)</th>
            <th class="text-center">(3)</th>
            <th class="text-center">(4)</th>
            <th class="text-center">(5)</th>
            <th class="text-center">(6)</th>
            <th class="text-center">(6.1)</th>
            <th class="text-center">(5)/(3)</th>
            <th class="text-center">(6)/(5)</th>
            <th class="text-center">(6.1)/(6)</th>
            <th class="text-center">(7)</th>
            <th class="text-center">(8)</th>
            <th class="text-center">(9)</th>
            <th class="text-center">(10)</th>
            <th class="text-center">(11)</th>
            {{--<th class="text-center">(12)</th>--}}
            {{--<th class="text-center">(13)</th>--}}
        </tr>
        </thead>
        <tbody>

        @if(count($source))
            @foreach($source as $i => $item)
                <tr class="">
                    <td class="text-center pdr10">{{$i}}</td>
                    <td class="text-center pdr10">{{@$item->user->full_name}}
                    <td class="text-center pdr10">{{$item->name}}
                        <a href="javascript:void(0)" class="btnThemLandingData" data-item="{{$item}}" data-name_product="{{$item->category_text}}"><i class="fa fa-plus"></i></a>
                    </td>
                    <td class="text-center pdr10">{{$item->category_text}}</td>
                    <td class="text-center pdr10">{{$item->chanel_text}}</td>
                    <td class="text-center pdr10">{{number_format($item->budget)}}</td>
                    <td class="text-center pdr10">{{$item->customers}}</td>
                    <td class="text-center pdr10">{{!empty($item->budget)&& !empty($item->customers)?number_format($item->budget/$item->customers):0}}</td>
                    <td class="text-center pdr10">{{$item->schedules}}</td>
                    <td class="text-center pdr10">{{$item->schedules_den}}</td>
                    <td class="text-center pdr10">{{$item->orders}}</td>
                    <td class="text-center pdr10">{{!empty($item->budget)&& !empty($item->schedules_den)?number_format($item->budget/$item->schedules_den):0}}</td>

                    <td class="text-center pdr10">{{!empty($item->schedules_den) && !empty($item->customers) ?round(($item->schedules_den/$item->customers)*100,1):0}}%
                    </td>
                    <td class="text-center pdr10">{{number_format($item->all_total)}}</td>
                    <td class="text-center pdr10">{{number_format($item->gross_revenue)}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>
</div>
