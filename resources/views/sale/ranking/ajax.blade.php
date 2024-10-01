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
                        @if(@$sale[0])
                            <div class="box">
                                <div class="header1 position-relative">
                                    <img src="{{asset('layout/images/STT1.png')}}" alt="">
                                    <img src="{{asset('layout/images/Polygon.png')}}" alt="" class="header1_bg">
                                    <img src="{{$sale[0]['avatar']??asset('layout/images/Logo.png')}}" alt="Avatar" class="header1_ava">
                                </div>
                                <div class="body position-relative">
                                    <div class="p-16">
                                        <img src="{{asset('layout/images/diamond.png')}}" style="position: absolute;top: 4px;right: 16px;">
                                        <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{str_limit($sale[0]['full_name'],15)}}</div>
                                        <div class="fs-14 color-dark mt-8">{{@$sale[0]['branch_name']??'Tất cả chi nhánh'}}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-16">

                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format($sale[0]['gross_revenue'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Doanh số</div>
                                            </div>
                                            <div class="">
                                                <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                            </div>
                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format((int)$sale[0]['orders'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Đơn hàng</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="top2">
                        @if(@$sale[1])
                            <div class="box">
                                <div class="header1 position-relative">
                                    <img src="{{asset('layout/images/STT2.png')}}" alt="">
                                    <img src="{{asset('layout/images/Polygon.png')}}" alt="" class="header1_bg">
                                    <img src="{{$sale[1]['avatar']??asset('layout/images/Logo.png')}}" alt="Avatar" class="header1_ava">
                                </div>
                                <div class="body position-relative">
                                    <div class="p-16">
                                        <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{$sale[1]['full_name']}}</div>
                                        <div class="fs-14 color-dark mt-8">{{@$sale[1]['branch_name']??'Tất cả chi nhánh'}}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-16">

                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format($sale[1]['gross_revenue'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Doanh số</div>
                                            </div>
                                            <div class="">
                                                <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                            </div>
                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format((int)$sale[1]['orders'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Đơn hàng</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="top3">
                        @if(@$sale[2])
                            <div class="box">
                                <div class="header1 position-relative">
                                    <img src="{{asset('layout/images/STT3.png')}}" alt="">
                                    <img src="{{asset('layout/images/Line.png')}}" alt="" class="header1_bg">
                                    <img src="https://www.w3schools.com/tags/img_girl.jpg" alt="Avatar" class="header1_ava">
                                </div>
                                <div class="body position-relative">
                                    <div class="p-16">
                                        <div class="fs-24" style="margin-top: 34px; line-height: 25.2px;">{{str_limit($sale[2]['full_name'],15)}}</div>
                                        <div class="fs-14 color-dark mt-8">{{@$sale[2]['branch_name']??'Tất cả chi nhánh'}}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-16">

                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format($sale[2]['gross_revenue'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Doanh số</div>
                                            </div>
                                            <div class="">
                                                <img src="{{asset('layout/images/Line.png')}}" alt="" style="height: 26px;">
                                            </div>
                                            <div class="text-center">
                                                <div class="color-info" style="font-size: 22px;">{{number_format((int)$sale[2]['orders'])}}</div>
                                                <div class="color-dark fs-14 mt-8">Đơn hàng</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="right" style="width: 192px; position: relative; background: url({{asset('layout/images/bg_bg.png')}})">
                    {{--<img src="{{asset('layout/images/bg_bg.png')}}" style="position: absolute;left: -50%;top: -100px;z-index: -1;">--}}
                </div>
            </div>
        </div>
     <div class="ranking" style="margin-bottom: 68px;">
         <div class="d-flex text-center" style="margin-top: 46px;">
             <span class="fs-16 color-dark" style="width: 25%;">Họ tên</span>
             <span class="fs-16 color-dark" style="width: 25%;">Chức vụ</span>
             <span class="fs-16 color-dark" style="width: 25%;">Đơn hàng</span>
             <span class="fs-16 color-dark" style="width: 25%;">Doanh số</span>
         </div>
         @forelse($sale  as $key => $item)
             @if($key > 2)
                 <div class="item top4 mt-8 d-flex align-items-center">
                     <div class="d-flex align-items-center w-100 justify-content-between {{\Illuminate\Support\Facades\Auth::user()->id==$item['id']?'color-rank':''}}">
                         <div class="d-flex gap-12 align-items-center justify-content-center" style="width: 26%;">
                             <div class="font-sopher fs-36 fw-700"
                                  style="margin-right: 10px;"><i>{{$key + 1}}</i></div>
                             <div class="position-relative">
                                 <img src="{{asset('layout/images/images/Polygon.png')}}" alt="" class="header1_bg">
                             </div>
                             <div class="">
                                 <div class="fs-18">{{@$item['full_name']}}</div>
                                 <div class="fs-12 color-dark">{{@$item['branch_name']??'Tất cả chi nhánh'}}</div>
                             </div>
                         </div>
                         <div class="fs-18 text-center" style="width: 25%;">Telesale</div>
                         <div class="fs-18 text-center" style="width: 25%;">{{number_format((int)$item['orders'])}}</div>
                         <div class="fs-18 text-center" style="width: 25%;">{{number_format((int)$item['gross_revenue'])}}</div>
                     </div>
                 </div>
             @endif
         @empty
         @endforelse
     </div>
 </div>

<script type="text/javascript" src="{{asset('layout/js/master.js')}}"></script>
