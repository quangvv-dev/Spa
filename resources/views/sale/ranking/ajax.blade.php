 <div class="container marketing">
        <div class="rank">
            <div class="" style="position: absolute; top: 13%;">
                <img src="{{asset('layout/images/bg_champions.png')}}" alt="">
            </div>
            <div class="d-flex align-items-center" style="margin-top: 115px;">
                <div class="left">
                    <img src="{{asset('layout/images/bg_bg.png')}}" style="margin-left: 50%;">
                </div>
                <div class="content d-flex" style="gap: 17px;">
                    <div class="top1">
                        <div class="box">
                            <div class="header1 position-relative">
                                <img src="{{asset('layout/images/STT1.png')}}" alt="">
                                <img src="{{asset('layout/images/Polygon.png')}}" alt="" class="header1_bg">
                                <img src="{{$sale[0]['avatar']??asset('layout/images/Logo.png')}}" alt="Avatar" class="header1_ava">
                            </div>
                            <div class="body position-relative">
                                <div class="p-16">
                                    <img src="{{asset('layout/images/diamond.png"')}}" style="position: absolute;top: 4px;right: 16px;">
                                    <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{str_limit($sale[2]['full_name'],15)}}</div>
                                    <div class="fs-14 color-dark mt-8">The Pyo Hà Nội</div>
                                    <div class="d-flex justify-content-between align-items-center mt-16">

                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">{{number_format($sale[0]['gross_revenue'])}}</div>
                                            <div class="color-dark fs-14 mt-8">Doanh số</div>
                                        </div>
                                        <div class="">
                                            <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                        </div>
                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">1,389</div>
                                            <div class="color-dark fs-14 mt-8">Liên hệ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top2">
                        <div class="box">
                            <div class="header1 position-relative">
                                <img src="{{asset('layout/images/STT2.png')}}" alt="">
                                <img src="{{asset('layout/images/Polygon.png')}}" alt="" class="header1_bg">
                                <img src="{{$sale[1]['avatar']??asset('layout/images/Logo.png')}}" alt="Avatar" class="header1_ava">
                            </div>
                            <div class="body position-relative">
                                <div class="p-16">
                                    <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{$sale[1]['full_name']}}</div>
                                    <div class="fs-14 color-dark mt-8">The Pyo Hà Nội</div>
                                    <div class="d-flex justify-content-between align-items-center mt-16">

                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">{{number_format($sale[1]['gross_revenue'])}}</div>
                                            <div class="color-dark fs-14 mt-8">Doanh số</div>
                                        </div>
                                        <div class="">
                                            <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                        </div>
                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">1,389</div>
                                            <div class="color-dark fs-14 mt-8">Liên hệ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top3">
                        <div class="box">
                            <div class="header1 position-relative">
                                <img src="{{asset('layout/images/STT3.png')}}" alt="">
                                <img src="{{asset('layout/images/Line.png')}}" alt="" class="header1_bg">
                                <img src="https://www.w3schools.com/tags/img_girl.jpg" alt="Avatar" class="header1_ava">

                            </div>
                            <div class="body position-relative">
                                <div class="p-16">
                                    <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{str_limit($sale[2]['full_name'],15)}}</div>
                                    <div class="fs-14 color-dark mt-8">The Pyo Hà Nội</div>
                                    <div class="d-flex justify-content-between align-items-center mt-16">

                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">{{number_format($sale[2]['gross_revenue'])}}</div>
                                            <div class="color-dark fs-14 mt-8">Doanh số</div>
                                        </div>
                                        <div class="">
                                            <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                        </div>
                                        <div class="text-center">
                                            <div class="color-info" style="font-size: 22px;">1,389</div>
                                            <div class="color-dark fs-14 mt-8">Liên hệ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right" style="width: 192px; position: relative; background: url({{asset('layout/images/bg_bg.png')}})">
                    {{--<img src="{{asset('layout/images/bg_bg.png')}}" style="position: absolute;left: -50%;top: -100px;z-index: -1;">--}}
                </div>
            </div>
        </div>
    </div>


<div class="card-body table-responsive">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 form-group">
            <div class="square">
                <div class="content1">
                    <div class="bxh bxh-container" style="border:1px solid transparent;">
                        <div
                            style="transform: rotate(-12.5deg); height: 8px; width: 100%; background-color: #ecedef; position: absolute; top: 13.5%;"></div>
                        @if(count($sale))
                            @php $key = 0;$check=0; @endphp
                            @foreach($sale  as $item)
                                @php $key ++ ;@endphp
                                @if ($key >10)
                                    @break
                                @endif
                                <div
                                    class="item-rank {{\Illuminate\Support\Facades\Auth::user()->id==$item['id']?'my-rank':''}} {{$key==1?'item-rank1':'item-rank'.($key)}}">
                                    <div class="king-sale">
                                        <img src="{{asset('default/bxh2.png')}}">
                                    </div>
                                    <div
                                        class="avatar-container {{$key == 1?'blink1':'blink'.($key)}}">
                                        <img class="avatar-img"
                                             src="{{$item['avatar'] ? $item['avatar'] : asset('assets/images/brand/logo.png')}}">
                                    </div>
                                    <div class="item-info">
                                        <div
                                            class="item-stt">{{$key==1?'#1':(int)$key}}</div>
                                        <div class="item-tennv">{{@$item['full_name']}}</div>
                                        <div class="item-ds">
                                            {{number_format((int)$item['gross_revenue'])}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if((count($my_key) && $my_key[0]>9))
                                <div class="item-rank my-rank item-rank11">
                                    <div
                                        class="avatar-container {{'blink'.($my_key[0]+1)}}">
                                        <img class="avatar-img"
                                             src="{{$response[$my_key[0]]['avatar'] ? $response[$my_key[0]]['avatar'] : asset('assets/images/brand/logo.png')}}">
                                    </div>
                                    <div class="item-info">
                                        <div class="item-stt">{{$my_key[0]}}</div>
                                        <div class="item-tennv">{{@$response[$my_key[0]]['full_name']}}</div>
                                        <div class="item-ds">
                                            {{number_format((int)@$response[$my_key[0]]['gross_revenue'])}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('layout/js/master.js')}}"></script>
