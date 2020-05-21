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
        <div class="bxh bxh-container" style="border:1px solid transparent;">
            <div
                style="transform: rotate(-12.5deg); height: 8px; width: 100%; background-color: #fff; position: absolute; top: 13.5%;"></div>

            @for($i=0;$i<10;$i++)
                <div class="item-rank" style="right: {{$i*9}}%;top: {{$i*2}}%" title="adam.sale68">
                    <div class="king-sale">
                        <img src="{{$i==0?'https://pushsale.vn/Portals/_default/Skins/APP/images/bxh/bxh2.png':''}}">
                    </div>
                    <div class="avatar-container  blink">
                        <img class="avatar-img" src="{{asset('images/users/2019-05-02_5ccb212a822b8.jpg')}}">
                    </div>
                    <div class="item-info {{'item-info'.($i+1)}}">
                        <div class="item-stt">{{$i==0 ?'#'.($i+1):($i+1)}}</div>
                        <div class="item-tennv">Waldo - Mạc Thu Hà</div>
                        <div class="">
                            72,757,000
                        </div>
                    </div>
                </div>
            @endfor

        </div>
        <div style="width: 100%; overflow: hidden; overflow-x: auto">
            <table class="table table-bordered table-info hidden-xs" style="margin-bottom: 0px;">
                <tbody>
                <tr>
                    <th class="text-center" rowspan="2" colspan="1" style="width: 50px;">STT</th>
                    <th class="text-center" rowspan="2" colspan="1" style="width: 10%">SALE</th>
                    <th class="text-center" rowspan="1" colspan="5">KHÁCH HÀNG MỚI</th>
                    <th class="text-center" rowspan="1" colspan="5">KHÁCH HÀNG CŨ</th>
                    <th class="text-center" rowspan="1" colspan="6" style="width: 36%;">TỔNG CHUNG</th>
                </tr>
                <tr>

                    <th class="text-center">Contact</th>
                    <th class="text-center">Chốt đơn</th>
                    <th class="text-center no-wrap">% chốt</th>
                    <th class="text-center" title="Số sản phẩm">Số SP</th>
                    <th class="text-center">
                        Doanh số
                        <span class="">
                                                    <br>sau CK
                                                </span>
                    </th>


                    <th class="text-center">Contact</th>
                    <th class="text-center">Chốt đơn</th>
                    <th class="text-center no-wrap">% chốt</th>
                    <th class="text-center" title="Số sản phẩm">Số SP</th>
                    <th class="text-center">Doanh số
                        <span class="">
                                                    <br>sau CK
                                                </span>
                    </th>


                    <th class="text-center" style="width: 7%;">Doanh số
                        <span class="">
                                                    <br>sau CK
                                                </span>
                    </th>
                    <th class="text-center" style="width: 4%;">CK</th>
                    <th class="text-center" style="width: 4%;">COD thu của khách</th>
                    <th class="text-center" style="width: 4%;">Hỗ trợ COD</th>
                    <th class="text-center" style="width: 4%;">Phí COD dịch vụ</th>
                    <th class="text-center" style="width: 7%;">Doanh thu</th>
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
                    <th class="text-center">(11)</th>
                    <th class="text-center">(12)</th>
                    <th class="text-center">
                        (13) = (7) + (12)
                    </th>
                    <th class="text-center">(14)</th>
                    <th class="text-center">(15)</th>
                    <th class="text-center">(16)</th>
                    <th class="text-center">(17)</th>
                    <th class="text-center">
                        (18) = (13) + (15) - (16) - (17)
                    </th>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">#1</td>
                    <td class="text-center pdr10">Waldo - Mạc Thu Hà <span class="small-tip">(adam.sale68)</span></td>
                    <td class="text-center pdr10">38</td>
                    <td class="text-center pdr10">21</td>
                    <td class="text-center pdr10">55.26%</td>
                    <td class="text-center pdr10">105</td>
                    <td class="text-center pdr10">
                        32,802,000
                    </td>
                    <td class="text-center pdr10">31</td>
                    <td class="text-center pdr10">27</td>
                    <td class="text-center pdr10">87.1%</td>
                    <td class="text-center pdr10">118</td>
                    <td class="text-center pdr10">
                        39,955,000
                    </td>

                    <td class="text-center pdr10">
                        72,757,000
                    </td>
                    <td class="text-center pdr10">16,563,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">72,757,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">2</td>
                    <td class="text-center pdr10">Calibee - Hoàng Duy Phước <span class="small-tip">(adam.sale11)</span>
                    </td>
                    <td class="text-center pdr10">35</td>
                    <td class="text-center pdr10">15</td>
                    <td class="text-center pdr10">42.86%</td>
                    <td class="text-center pdr10">81</td>
                    <td class="text-center pdr10">
                        23,155,000
                    </td>
                    <td class="text-center pdr10">30</td>
                    <td class="text-center pdr10">11</td>
                    <td class="text-center pdr10">36.67%</td>
                    <td class="text-center pdr10">51</td>
                    <td class="text-center pdr10">
                        15,175,000
                    </td>

                    <td class="text-center pdr10">
                        38,330,000
                    </td>
                    <td class="text-center pdr10">14,975,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">38,330,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">3</td>
                    <td class="text-center pdr10">Calibee - Nguyễn Trường Giang <span
                            class="small-tip">(adam.sale7)</span></td>
                    <td class="text-center pdr10">25</td>
                    <td class="text-center pdr10">12</td>
                    <td class="text-center pdr10">48%</td>
                    <td class="text-center pdr10">73</td>
                    <td class="text-center pdr10">
                        25,315,000
                    </td>
                    <td class="text-center pdr10">24</td>
                    <td class="text-center pdr10">8</td>
                    <td class="text-center pdr10">33.33%</td>
                    <td class="text-center pdr10">41</td>
                    <td class="text-center pdr10">
                        11,605,000
                    </td>

                    <td class="text-center pdr10">
                        36,920,000
                    </td>
                    <td class="text-center pdr10">6,610,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">36,920,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">4</td>
                    <td class="text-center pdr10">Fansipan - Nguyễn Thị Anh <span class="small-tip">(adam.sale44)</span>
                    </td>
                    <td class="text-center pdr10">42</td>
                    <td class="text-center pdr10">15</td>
                    <td class="text-center pdr10">35.71%</td>
                    <td class="text-center pdr10">65</td>
                    <td class="text-center pdr10">
                        19,670,000
                    </td>
                    <td class="text-center pdr10">19</td>
                    <td class="text-center pdr10">7</td>
                    <td class="text-center pdr10">36.84%</td>
                    <td class="text-center pdr10">30</td>
                    <td class="text-center pdr10">
                        9,045,000
                    </td>

                    <td class="text-center pdr10">
                        28,715,000
                    </td>
                    <td class="text-center pdr10">8,105,000</td>
                    <td class="text-center pdr10">58,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">28,773,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">5</td>
                    <td class="text-center pdr10">Alenda - Nguyễn Hồng Dương <span
                            class="small-tip">(adam.sale63)</span></td>
                    <td class="text-center pdr10">23</td>
                    <td class="text-center pdr10">8</td>
                    <td class="text-center pdr10">34.78%</td>
                    <td class="text-center pdr10">28</td>
                    <td class="text-center pdr10">
                        10,365,000
                    </td>
                    <td class="text-center pdr10">38</td>
                    <td class="text-center pdr10">15</td>
                    <td class="text-center pdr10">39.47%</td>
                    <td class="text-center pdr10">56</td>
                    <td class="text-center pdr10">
                        18,225,000
                    </td>

                    <td class="text-center pdr10">
                        28,590,000
                    </td>
                    <td class="text-center pdr10">5,270,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">28,590,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">6</td>
                    <td class="text-center pdr10">Fansipan - Nguyễn Thùy Linh <span
                            class="small-tip">(adam.sale34)</span></td>
                    <td class="text-center pdr10">19</td>
                    <td class="text-center pdr10">7</td>
                    <td class="text-center pdr10">36.84%</td>
                    <td class="text-center pdr10">38</td>
                    <td class="text-center pdr10">
                        10,830,000
                    </td>
                    <td class="text-center pdr10">15</td>
                    <td class="text-center pdr10">14</td>
                    <td class="text-center pdr10">93.33%</td>
                    <td class="text-center pdr10">56</td>
                    <td class="text-center pdr10">
                        16,935,000
                    </td>

                    <td class="text-center pdr10">
                        27,765,000
                    </td>
                    <td class="text-center pdr10">8,435,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">27,765,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">7</td>
                    <td class="text-center pdr10">Calibee - Đoàn Phú Quốc <span class="small-tip">(adam.sale9)</span>
                    </td>
                    <td class="text-center pdr10">50</td>
                    <td class="text-center pdr10">19</td>
                    <td class="text-center pdr10">38%</td>
                    <td class="text-center pdr10">56</td>
                    <td class="text-center pdr10">
                        15,485,000
                    </td>
                    <td class="text-center pdr10">36</td>
                    <td class="text-center pdr10">6</td>
                    <td class="text-center pdr10">16.67%</td>
                    <td class="text-center pdr10">27</td>
                    <td class="text-center pdr10">
                        7,810,000
                    </td>

                    <td class="text-center pdr10">
                        23,295,000
                    </td>
                    <td class="text-center pdr10">7,710,000</td>
                    <td class="text-center pdr10">315,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">23,610,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">8</td>
                    <td class="text-center pdr10">Waldo - Lê Thị Thùy <span class="small-tip">(adam.sale79)</span></td>
                    <td class="text-center pdr10">28</td>
                    <td class="text-center pdr10">14</td>
                    <td class="text-center pdr10">50%</td>
                    <td class="text-center pdr10">72</td>
                    <td class="text-center pdr10">
                        22,020,000
                    </td>
                    <td class="text-center pdr10">14</td>
                    <td class="text-center pdr10">2</td>
                    <td class="text-center pdr10">14.29%</td>
                    <td class="text-center pdr10">3</td>
                    <td class="text-center pdr10">
                        1,055,000
                    </td>

                    <td class="text-center pdr10">
                        23,075,000
                    </td>
                    <td class="text-center pdr10">6,690,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">23,075,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">9</td>
                    <td class="text-center pdr10">Fansipan - Tạ Thị Mai <span class="small-tip">(adam.sale33)</span>
                    </td>
                    <td class="text-center pdr10">15</td>
                    <td class="text-center pdr10">11</td>
                    <td class="text-center pdr10">73.33%</td>
                    <td class="text-center pdr10">50</td>
                    <td class="text-center pdr10">
                        15,050,000
                    </td>
                    <td class="text-center pdr10">24</td>
                    <td class="text-center pdr10">9</td>
                    <td class="text-center pdr10">37.5%</td>
                    <td class="text-center pdr10">22</td>
                    <td class="text-center pdr10">
                        7,740,000
                    </td>

                    <td class="text-center pdr10">
                        22,790,000
                    </td>
                    <td class="text-center pdr10">5,580,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">22,790,000</td>
                </tr>

                <tr class="">
                    <td class="text-center pdr10">10</td>
                    <td class="text-center pdr10">Waldo - Phạm Ngọc Thượng <span class="small-tip">(adam.sale74)</span>
                    </td>
                    <td class="text-center pdr10">12</td>
                    <td class="text-center pdr10">8</td>
                    <td class="text-center pdr10">66.67%</td>
                    <td class="text-center pdr10">39</td>
                    <td class="text-center pdr10">
                        11,975,000
                    </td>
                    <td class="text-center pdr10">20</td>
                    <td class="text-center pdr10">8</td>
                    <td class="text-center pdr10">40%</td>
                    <td class="text-center pdr10">34</td>
                    <td class="text-center pdr10">
                        10,475,000
                    </td>

                    <td class="text-center pdr10">
                        22,450,000
                    </td>
                    <td class="text-center pdr10">7,535,000</td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>
                    <td class="text-center pdr10"></td>

                    <td class="text-center pdr10">22,450,000</td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>

@endsection
@section('_script')

@endsection

