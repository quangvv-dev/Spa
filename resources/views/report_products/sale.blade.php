@extends('layout.app')
@section('_style')
    {{--<link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>--}}
    <style>
        .bxh-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .bxh .item-rank {
            width: 6.5%;
            height: 6.5%;
            display: inline-block;
            position: absolute;
        }

        .bxh .item-rank1 .king-sale {
            display: block;
        }

        .bxh .item-rank .avatar-container {
            border: 6px solid #f49000;
        }

        .bxh .item-rank .avatar-container {
            display: inline-block;
            height: 88px;
            width: 100%;
            overflow: hidden;
            border-radius: 50%;
            border: 6px solid #53628e;
        }

        .bxh .item-rank .king-sale {
            display: block;
        }

        .bxh .king-sale {
            display: none;
            text-align: center;
            position: absolute;
            width: 100%;
            margin-top: -40%;
        }

        .bxh .item-rank .item-info {
            text-align: center;
        }

        .item-info1 {
            color: #da0e35;
            font-weight: 600;
        }

        .item-info {
            text-align: center;
        }

        .page-main {
            background-color: #fff;
        }
    </style>
@endsection
@section('content')

    <div class="col-md-12 col-lg-12">
        {{--<div class="bxh bxh-container" style="border:1px solid transparent;">--}}
        {{--<div style="transform: rotate(-12.5deg); height: 8px; width: 100%; background-color: #cecece; position: absolute; top: 13.5%;"></div>--}}

        {{--@for($i=0;$i<10;$i++)--}}
        {{--<div class="item-rank" style="right: {{$i*9}}%;top: {{$i*2}}%" title="adam.sale68">--}}
        {{--<div class="king-sale">--}}
        {{--<img src="{{$i==0?'https://pushsale.vn/Portals/_default/Skins/APP/images/bxh/bxh2.png':''}}">--}}
        {{--</div>--}}
        {{--<div class="avatar-container  blink">--}}
        {{--<img class="avatar-img" src="{{asset('images/users/2019-05-02_5ccb212a822b8.jpg')}}">--}}
        {{--</div>--}}
        {{--<div class="item-info {{'item-info'.($i+1)}}">--}}
        {{--<div class="item-stt">{{$i==0 ?'#'.($i+1):($i+1)}}</div>--}}
        {{--<div class="item-tennv">Waldo - Mạc Thu Hà</div>--}}
        {{--<div class="">--}}
        {{--72,757,000--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--@endfor--}}

        {{--</div>--}}
        <div style="width: 100%; overflow: hidden; overflow-x: auto;margin-top: 20px">
            <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
                <tbody>
                <thead class="bg-primary text-white">
                <th class="text-center" rowspan="2" colspan="1">STT</th>
                <th class="text-center" rowspan="2" colspan="1">SALE</th>
                <th class="text-center" rowspan="1" colspan="3">KHÁCH HÀNG MỚI</th>
                <th class="text-center" rowspan="1" colspan="2">KHÁCH HÀNG CŨ</th>
                <th class="text-center" rowspan="1" colspan="3">TỔNG CHUNG</th>
                </thead>
                <tr>

                    <th class="text-center"></th>
                    <th class="text-center">Nhân viên</th>
                    <th class="text-center no-wrap">Khách mới</th>
                    <th class="text-center" title="Số sản phẩm">Số đơn chốt</th>
                    <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>

                    <th class="text-center no-wrap">Đơn chốt</th>
                    <th class="text-center">Doanh số<span class=""><br>sau CK</span></th>

                    <th class="text-center">Doanh số<span class=""><br>KH mới (%)</span></th>
                    <th class="text-center">Doanh số<span class=""><br>KH cũ (%)</span></th>
                    <th class="text-center">Tổng doanh số</th>
                </tr>
                <tr style="font-size:11px;">
                    <th class="text-center">(1)</th>
                    <th class="text-center">(2)</th>
                    <th class="text-center">(3)</th>
                    <th class="text-center">(4)</th>
                    <th class="text-center">(5)</th>
                    <th class="text-center">(6)</th>
                    <th class="text-center">(7)</th>
                    <th class="text-center">(8)</th>
                    <th class="text-center">(9)</th>
                    <th class="text-center">(10)</th>
                </tr>
                @if(count($users))
                    @foreach($users as $k => $item)
                        <tr class="">
                            <td class="text-center pdr10">{{$k+1}}</td>
                            <td class="text-center pdr10">{{$item->full_name}}
                            <td class="text-center pdr10">{{$item->customer_new}}</td>
                            <td class="text-center pdr10">{{$item->order_new}}</td>
                            <td class="text-center pdr10">{{number_format($item->revenue_new)}}</td>
                            <td class="text-center pdr10">{{$item->order_old}}</td>
                            <td class="text-center pdr10">{{number_format($item->revenue_old)}}</td>
                            <td class="text-center pdr10">{{$item->revenue_new ?round($item->revenue_new/(int)($item->revenue_new + $item->revenue_old)*100) ."%":'0%'}}</td>
                            <td class="text-center pdr10">{{$item->revenue_old ?round($item->revenue_old/(int)($item->revenue_new + $item->revenue_old)*100) ."%":'0%'}}</td>
                            <td class="text-center pdr10">{{@number_format((int)$item->revenue_new + (int)$item->revenue_old)}}</td>
                        </tr>
                        @endforeach
                        @endif

                        </tbody>
            </table>
        </div>

    </div>

@endsection
@section('_script')

@endsection

