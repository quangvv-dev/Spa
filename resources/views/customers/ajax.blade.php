<style>
    .page-header {
        display: none;
    }

    .display {
        display: inline-block;
        vertical-align: top;
    }

    .dropdown, .dropup {
        position: relative;
    }

    .gf-icon-filter {
        /*background-position: -758px -284px;*/
        width: 28px;
        height: 20px;
    }
    .birthday-count{
        top: -9px;
        position: absolute;
        left: 12px;
    }
    .tooltip-nav{
        padding-left: 10px;
    }
    .other_time_panel{
        left: auto;
        right: 0px;
        position: absolute;
        z-index: 123;
        width: 300px;
        background: #f6f6f6;
        border: 1px solid #8ccaed;
    }
    .qua-han td{
        color: red !important;
    }
    .qua-han td textarea,.qua-han td a{
        color: red !important;
    }
</style>
<div class="card-header filter-box filterbox-sticky" style="background: rgba(19, 19, 19, 1); border-bottom: none;">
    <div class="display btn-group open">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"
                style="height: 39px; border-radius: 3px; margin-right: 10px"><i
                class="fa fa-caret-down"></i></button>
        <ul class="dropdown-menu">
            <li class="pd5" id="search">
                <a class="invalid_account" data-invalid="1" data-icon-class="fa fa-trash"><span class="pr10"></span>
                    Đang sử dụng </a>
            </li>
            <li class="pd5"><a class="invalid_account" data-invalid="0" data-icon-class="fa fa-dot-circle-o"> <span
                        class="pr10"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></span> Đã xoá </a>
            </li>
        </ul>
    </div>
    <div class="d-flex gap-24 menu">
        <div class="squares-four pointer account_relation status active">
            <img src="{{asset('layout/images/SquaresFour_active.png')}}" alt="">
            <span class="text-white" style="white-space: nowrap">Tất cả</span>
            <span class="text-white fs-12">(&nbsp;{{$statuses->sum('customers_count')}})</span>
            <div class="active-border"></div>
        </div>
    </div>
    <div style="margin-left: 10px">
        <button class="btn btn-default" style="height: 40px;font-weight: 600;">
            <a href="{{ route('status.create') }}">
                <i class="fa fa-plus font16"></i>
            </a>
        </button>
    </div>

    <div class="scrollmenu col-md-8 d-flex gap-16 menu">
        @php
            $customers_count = 0;
        @endphp
        @foreach(@$statuses as $k => $item)

            <div class="smiley pointer account_relation status" data-name="{{$item->id}}">
{{--                <img src="{{asset('layout/images/Smiley.png')}}" alt="">--}}
                <span style="color: {{$item->color ?:''}};font-family: svn-regular !important">{{ $item->name }} ({{ @$item->customers_count }})</span>
            </div>
            @php
            $customers_count += $item->customers_count;
            @endphp
        @endforeach
    </div>
    <div class="col-md-3 d-flex justify-content-end">
        <div class="d-flex gap-16" style="margin-right: 30px;">
            <div class="d-flex align-items-center pagination1 gap-8" style="background: #36354A;">
                <div>
                    <span class="color-white">{{$customers->firstItem()}} - {{$customers->lastItem()}}</span>
                </div>
                <div>
                    {{ $customers->appends(['search' => request()->search ])->links('vendor.pagination.simple-bootstrap-4') }}
                </div>
            </div>
            <div class="d-flex align-items-center gap-16">
                <div class="display birthday_tab position pointer mt7 tooltip-nav p-0">
                    {{--<i class="fa fa-birthday-cake gf-icon-h02" aria-hidden="true"></i>--}}
                    <img src="{{asset('layout/images/Icons1.png')}}" alt="" class="pointer">
                    <span class="tooltiptext">Sinh nhật hôm nay</span>
                    <span class="noti-number noti-number-on birthday-count">{{$birthday}}</span>
                </div>
                <div class="display">
                    <div class="dropdown ope tooltip-nav p-0">
                        {{--<i class="fa fa-eye dropdown-toggle" role="button" data-toggle="dropdown" style="margin-top: 8px; margin-left: 5px;"></i>--}}
                        <img src="{{asset('layout/images/Eye_active.png')}}" alt="" class="dropdown-toggle pointer" role="button" data-toggle="dropdown">
                        <span class="tooltiptext">Hiển thị số trang</span>
                        <ul class="detail__pagination dropdown-menu pull-right tl mt5" role="menu" style="border-top:1px;left: -132px;">
                            <li><a class="b-white b-hover limiting {{@$_COOKIE['defaultPagination'] == 20?'active_limit bold':''}}" data-limit="20">Hiển thị 20 kết quả/trang</a></li>
                            <li><a class="b-white b-hover limiting {{@$_COOKIE['defaultPagination'] == 50?'active_limit bold':''}}" data-limit="50">Hiển thị 50 kết quả/trang</a></li>
                            <li><a class="b-white b-hover limiting {{@$_COOKIE['defaultPagination'] == 100?'active_limit bold':''}}" data-limit="100">Hiển thị 100 kết quả/trang</a></li>
                            <li><a class="b-white b-hover limiting {{@$_COOKIE['defaultPagination'] == 200?'active_limit bold':''}}" data-limit="200">Hiển thị 200 kết quả/trang</a></li>
                        </ul>
                    </div>
                </div>
                <div id="div_created_at_dropdown" class="display position pointer mt5 open tooltip-nav p-0">
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">--}}
                    {{--<i id="created_at_icon"--}}
                    {{--class="far fa-clock" style="font-size:22px"></i>--}}

                    <img src="{{asset('layout/images/Time_active.png')}}" alt="" class="dropdown-toggle pointer" role="button" data-toggle="dropdown">
                    <span class="tooltiptext">Thời gian tạo KH</span>
                    <div class="dropdown-customize add-drop add-d-right other_time_panel"
                         style="left: auto; right: 0px; display: none;"><s class="gf-icon-neotop"></s>
                        <div class="padding tl"><p>Ngày bắt đầu</p>
                            <input type="text" class="form-control filter_start_date" id="datepicker"
                                   data-toggle="datepicker" name="payment_date">
                        </div>
                        <div class="padding tl"><p>Ngày kết thúc</p>
                            <input type="text" class="form-control filter_end_date" id="datepicker"
                                   data-toggle="datepicker" name="payment_date">
                        </div>
                        <div class="padding5-10 tl mb5">
                            <button class="btn btn-info submit_other_time">Tìm kiếm</button>
                            <button class="btn btn-default cancel_other_time">Đóng</button>
                        </div>
                    </div>
                    <ul class="dropdown-customize dropdown-menu pull-right tr" style="left: -100px !important;">
                        <li class="created_at_item bor-bot tc"><a data-time="TODAY" class="btn_choose_time">Hôm
                                nay</a>
                        </li>
                        <li class="created_at_item bor-bot tc"><a data-time="YESTERDAY" class="btn_choose_time">Hôm
                                qua</a></li>
                        <li class="created_at_item bor-bot tc"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần
                                này</a></li>
                        <li class="created_at_item bor-bot tc"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần
                                trước</a></li>
                        <li class="created_at_item bor-bot tc"><a data-time="THIS_MONTH" class="btn_choose_time">Tháng
                                này</a></li>
                        <li class="created_at_item bor-bot tc"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng
                                trước</a></li>
                        <li class="created_at_item bor-bot tc">
                            <a class="other_time">Khác</a>
                        </li>
                    </ul>
                </div>
                <div class="display dropdown-custom1" title="Cài đặt hiển thị bảng">
                    @include('components.user_filter_grid')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive fixed-scrollbar" style="font-size: 12px">

    <div class="content__table">
        <table class="table card-table table-striped table-bordered table-vcenter text-nowrap" style="width: 100%">
        <thead class="text-white">
        <tr>
            <th ><input type="checkbox" class="selectall myCheck"/></th>
            @forelse($user_filter_list as $key => $item)
                @if($key == 4)
                    @if(\Illuminate\Support\Facades\Auth::user()->department_id == 3)
                        <th class="text-white text-center {{in_array($key,$user_filter_grid) ? '':'display-none'}}" style="min-width: 130px">Tin nhắn</th>
                    @endif
                @else
                    <th class="text-white text-center {{in_array($key,$user_filter_grid) ? '':'display-none'}}"
                        style="{{$key==8 ? 'min-width: 121px;' : ''}}z-index: 1;">
                        {{$item}}
                    </th>
                @endif
            @empty

            @endforelse
            <th class="text-white text-center">Chỉnh sửa</th>
        </tr>
        </thead>
        <tbody style="background: white;">
        @if (count($customers))
            @if(count($customers) <7)
                <tr>
                    <td colspan="22"></td>
                </tr>
                <tr>
                    <td colspan="22"></td>
                </tr>
            @endif
            @foreach($customers as $key => $customer)
                <tr class="{{$customer->expired_time_boolean == 1 ? 'qua-han' : ''}}">
                    <td class="text-center" style="background: {{isset($customer->status)?$customer->status->color :''}}">
                        <input type="checkbox" name="delete[]" class="myCheck" value="{{$customer->id}}"/>
                    </td>
                    <td class="text-center {{in_array(0,$user_filter_grid) ? '':'display-none'}}">{{ $key + 1 }}</td>
                    <td class="text-center {{in_array(1,$user_filter_grid) ? '':'display-none'}}">{{ date('d-m-Y H:i:s', strtotime($customer->created_at)) }}</td>
                    <td class="text-center name-customer {{in_array(2,$user_filter_grid) ? '':'display-none'}}" data-customer-id="{{ $customer->id }}">
                        <a class="view_modal" id="chat-fast" data-customer-id="{{ $customer->id }}" href="#">
                            @if($customer->FB_ID)
                            <i class="fab fa-facebook-messenger" style="font-size: 16px"></i>
                            @else
                                <i class="fas fa-info-circle"></i>
                            @endif
                        </a>
                        <a href="{{ route('customers.show', $customer->id) }}" class="color-primary">{{ $customer->full_name }}</a>
                        <span class="noti-number noti-number-on ml5">{{ $customer->groupComments->count() }}</span>
                        <a target="_blank" href="https://zalo.me/{{@$customer->phone}}">
                            <img width="25" height="25" src="{{asset('assets/images/zalo_icon.png')}}">
                        </a>
                    </td>
                    <td class="text-center {{in_array(3,$user_filter_grid) ? '':'display-none'}}" data-phone="{{$customer->phone}}" data-customer-id="{{ $customer->id }}">
                        <a href="javascript:void(0)" class="color-primary phone-customer">{{ str_limit($customer->phone,7,'xxx') }}
                        </a>
{{--                        <a href=""><i style="color: red !important" class="{!! $customer->is_duplicate == 1 ? "fa fa fa-copy" :'' !!}"></i></a>--}}
                        <span><i id="callButton" class="fas fa-phone" data-id="{{$customer->call_back}}" style="cursor: pointer; !important;"></i></span>
{{--                        @if(!empty($customer->call_back))--}}
{{--                            <span><i id="callButton" class="fas fa-phone call-back" data-id="{{$customer->call_back}}" style="cursor: pointer;color: red !important;"></i></span>--}}
{{--                        @endif--}}
                    </td>
                @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::MARKETING)
                        <td class="text-center {{in_array(4,$user_filter_grid) ? '':'display-none'}}" style="position: relative;max-width: 146px">
                            <textarea class="description-cus">{{ $customer->message }}</textarea>
                        </td>
                    @endif
                    <td class="text-center category-db {{in_array(5,$user_filter_grid) ? '':'display-none'}}"
                        data-id="{{$customer->id}}">{{str_limit($customer->group_text,30)}}</td>
                    <td class="text-center status-db {{in_array(6,$user_filter_grid) ? '':'display-none'}}" data-id="{{$customer->id}}">{{ @$customer->status->name }}</td>
                    <td class="text-center telesale-customer {{in_array(7,$user_filter_grid) ? '':'display-none'}}"
                        data-customer-id="{{$customer->id}}">{{ @$customer->telesale->full_name }}</td>
                    <td class="text-center {{in_array(8,$user_filter_grid) ? '':'display-none'}}" style="position: relative;max-width: 146px">
                        <textarea data-id="{{$customer->id}}" class="description-cus">{{ $customer->description }}</textarea>
                    </td>
{{--                    <td class="text-center {{in_array(9,$user_filter_grid) ? '':'display-none'}}">{{$customer->expired_text}}</td>--}}
{{--                    <td class="text-center {{in_array(10,$user_filter_grid) ? '':'display-none'}}">{{@$customer->time_move}}</td>--}}
                    <td class="text-center {{in_array(11,$user_filter_grid) ? '':'display-none'}}">{{@$customer->branch->name}}</td>

{{--                    <td class="text-center category-tip {{in_array(12,$user_filter_grid) ? '':'display-none'}}" data-id="{{$customer->id}}">--}}
{{--                        <span class="badge badge-primary span-tips">{{str_limit($customer->group_tips,30)}}</span>--}}
{{--                    </td>--}}
{{--                    <td class="text-center genitive-db {{in_array(13,$user_filter_grid) ? '':'display-none'}}" data-id="{{@$customer->id}}">{{@$customer->genitive->name}}</td>--}}
                    <td class="text-center {{in_array(14,$user_filter_grid) ? '':'display-none'}}">{{@$customer->carepage->full_name}}</td>
                    <td class="text-center {{in_array(25,$user_filter_grid) ? '':'display-none'}}">{{@$customer->cskh->full_name}}</td>
                    <td class="text-center small-tip {{in_array(26,$user_filter_grid) ? '':'display-none'}}">{{diffTime($customer->last_time)}}</td>
                    <td class="text-center {{in_array(15,$user_filter_grid) ? '':'display-none'}}" title="Đến mua màu xanh / đến không mua màu vàng/ Hủy màu đỏ/ Tất cả đơn màu đen">
                        {!! $customer->schedules_text !!}
                    </td>
                    <td class="text-center customer-birthday {{in_array(16,$user_filter_grid) ? '':'display-none'}}"
                        data-id="{{$customer->id}}">{{ date('d-m-Y', strtotime($customer->birthday)) }}</td>
                    <td class="text-center {{in_array(17,$user_filter_grid) ? '':'display-none'}}">{{ @$customer->marketing ? @$customer->marketing->full_name: '' }}</td>
                    <td class="text-center {{in_array(18,$user_filter_grid) ? '':'display-none'}}">{{ @$customer->source_customer->name}}</td>
                    <td class="text-center {{in_array(19,$user_filter_grid) ? '':'display-none'}}">{{ @$customer->facebook}}</td>
                    <td class="text-center {{in_array(20,$user_filter_grid) ? '':'display-none'}}">{{ $customer->gender_text  }}</td>
                    <td class="text-center {{in_array(21,$user_filter_grid) ? '':'display-none'}}">{{ count($customer->orders) }}</td>
                    <td class="text-center {{in_array(22,$user_filter_grid) ? '':'display-none'}}">{{ number_format($customer->orders->sum('all_total')) }}</td>
                    <td class="text-center {{in_array(23,$user_filter_grid) ? '':'display-none'}}">{{ number_format($customer->orders->sum('gross_revenue')) }}</td>
                    <td class="text-center {{in_array(24,$user_filter_grid) ? '':'display-none'}}">{{ number_format($customer->orders->sum('the_rest')) }}</td>
                    <td class="text-center"><a title="Sửa tài khoản" class="btn" href="{{ route('customers.edit', $customer->id) }}"><i class="fas fa-edit"></i></a></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td id="no-data" class="text-center" colspan="22">Không tồn tại dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
    </div>

    <div class="pull-left">
        <div class="page-info">
            {{ 'Tổng số ' . $customers->total() . ' khách hàng ' . (request()->search ? 'found' : '') }}
        </div>
        <div class="pull-right">
            {{ $customers->appends(['search' => request()->search ])->links() }}
        </div>
    </div>
</div>

@include('customers.modal_view')
<!-- table-responsive -->
<script type="text/javascript">
    $(function ($) {
        var scrollbar = $('<div id="fixed-scrollbar"><div></div></div>').appendTo($(document.body));
        scrollbar.hide().css({
            overflowX: 'auto',
            position: 'fixed',
            width: '100%',
            bottom: 0
        });
        var fakecontent = scrollbar.find('div');

        function top(e) {
            return e.offset().top;
        }

        function bottom(e) {
            return e.offset().top + e.height();
        }

        var active = $([]);

        function find_active() {
            scrollbar.show();
            var active = $([]);
            $('.fixed-scrollbar').each(function () {
                if (top($(this)) < top(scrollbar) && bottom($(this)) > bottom(scrollbar)) {
                    fakecontent.width($(this).get(0).scrollWidth);
                    fakecontent.height(1);
                    active = $(this);
                }
            });
            fit(active);
            return active;
        }

        function fit(active) {
            if (!active.length) return scrollbar.hide();
            scrollbar.css({left: active.offset().left, width: active.width()});
            fakecontent.width($(this).get(0).scrollWidth);
            fakecontent.height(1);
            delete lastScroll;
        }

        function onscroll() {
            var oldactive = active;
            active = find_active();
            if (oldactive.not(active).length) {
                oldactive.unbind('scroll', update);
            }
            if (active.not(oldactive).length) {
                active.scroll(update);
            }
            update();
        }

        var lastScroll;

        function scroll() {
            if (!active.length) return;
            if (scrollbar.scrollLeft() === lastScroll) return;
            lastScroll = scrollbar.scrollLeft();
            active.scrollLeft(lastScroll);
        }

        function update() {
            if (!active.length) return;
            if (active.scrollLeft() === lastScroll) return;
            lastScroll = active.scrollLeft();
            scrollbar.scrollLeft(lastScroll);
        }

        scrollbar.scroll(scroll);

        onscroll();
        $(window).scroll(onscroll);
        $(window).resize(onscroll);
    });
    $('html, body').animate({scrollTop: '0px'}, 300);

</script>
