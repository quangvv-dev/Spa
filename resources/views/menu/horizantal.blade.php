@php
    $roleGlobal = auth()->user()?:[];
    $checkRole = checkRoleAlready();
@endphp
<style>

</style>

<!-- Horizantal menu-->
<div class="ren-navbar header" id="headerMenuCollapse">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo pointer">
            <img src="{{url('layout/images/Logo.png')}}" alt="">
        </div>
        <div class="center">
            <ul class="navbar-nav bd-navbar-nav flex-row">

            @if($roleGlobal->permission('schedules.list'))
                <li class="nav-item">
                    <a class="{{ Request::is('schedules*')||Request::is('schedules*') ? 'active' : '' }}"
                       href="{!! url('schedules') !!}">
                        <div class="gradient-btn">
                            <img src="{{asset('layout/images/Calendar1.png')}}" alt="">
                            <span class="fs-18 show-text">Lịch hẹn</span>
                        </div>
                    </a>
                </li>
            @endif

            @if($roleGlobal->permission('customers.list'))
                <li class="nav-item">
                    <a class="{{ Request::is('customers*')||Request::is('customers*') ? 'active' : '' }}"
                       href="{!! route('customers.index') !!}">
                        <div class="gradient-btn">
                            <img src="{{asset('layout/images/Customer.png')}}" alt="">
                            <span class="fs-18 show-text">Khách hàng</span>
                        </div>
                    </a>
                </li>
            @endif
            <li class="nav-item with-sub">
                <a class="{{ Request::is('marketing/fanpage*')||Request::is('posts*')||Request::is('customer-post*')||Request::is('rules*') ? 'active' : '' }}"
                   href="#">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/Marketing.png')}}" alt="">
                        <span class="fs-18 show-text">Marketing</span>
                        <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                    </div>
                </a>
                <div class="sub-item">
                    <ul>
                        {{--                        @if($roleGlobal->permission('marketing.fanpage'))--}}
                        {{--                            <li><a href="{{route('marketing.fanpage.index')}}">Fanpage </a></li>--}}
                        {{--                        @endif--}}

                        {{--                        @if($roleGlobal->permission('marketing.fanpage_post'))--}}
                        {{--                            <li><a href="{{route('marketing.fanpage-post.index')}}">Fanpage Post</a></li>--}}
                        {{--                        @endif--}}
                        <li>
                            <div class="dropdown-item dropdown-menu__header">Marketing</div>
                            <div class="dropdown-menu__border">
                                <div></div>
                            </div>
                        </li>
                        @if($roleGlobal->permission('marketing.dashboard'))
                            <li class="sub-with-sub">
                                <a href="#">Xếp hạng</a>
                                <ul>
                                    <li><a href="{{route('marketing.dashboard')}}">Marketing Dashbroad</a></li>
                                    <li><a href="{{url('marketing/ranking')}}">Bảng xếp hạng</a></li>
                                </ul>
                            </li>
                        @endif
                        @if($roleGlobal->permission('source.list') || $roleGlobal->permission('marketing.seeding_number'))
                            <li class="sub-with-sub">
                                <a href="#">Dữ liệu</a>
                                <ul>
                                    @if($roleGlobal->permission('source.list'))
                                        {{--                                        <li><a href="{!! route('marketing.source-fb.index') !!}">Kết nối FaceBook</a>--}}
                                        {{--                                        </li>--}}
                                        <li><a href="{!! route('marketing.source-landipage.index') !!}">Kết nối
                                                Landipage</a></li>
                                    @endif

                                    {{--                                    @if($roleGlobal->permission('marketing.seeding_number'))--}}
                                    {{--                                        <li><a href="{{route('marketing.seeding-number.index')}}">Kho số seeding</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                    @endif--}}
                                    {{--                                    @if($roleGlobal->permission('posts.list'))--}}
                                    {{--                                        <li><a href="{{route('posts.index')}}">Optin form</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                    @endif--}}
                                </ul>
                            </li>
                        @endif
                        @if(empty($permissions) || !in_array('rules.index',$permissions)|| !in_array('promotions.index',$permissions))
                            <li class="sub-with-sub">
                                <a href="#">Nâng cao</a>
                                <ul>
                                    @if(empty($permissions) || !in_array('rules.index',$permissions))
                                        @if($roleGlobal->permission('rules.list'))
                                            <li><a href="{{url('rules')}}">Automation </a></li>
                                        @endif
                                    @endif
                                    @if(empty($permissions) || !in_array('promotions.index',$permissions))
                                        @if($roleGlobal->permission('promotions.list'))
                                            <li><a href="{{route('promotions.index')}}">Voucher khuyến mãi</a></li>
                                        @endif
                                    @endif
                                    @if($roleGlobal->permission('marketing.fanpage'))
                                        <li><a href="{{route('landipages.index')}}">Landipage</a></li>
                                        {{--                                        <li><a href="{{route('marketing.chat-messages')}}">Nhắn tin fanpage</a></li>--}}
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="{{ Request::is('category*')||Request::is('orders-payment')||Request::is('list-orders*')||Request::is('combos*')||Request::is('services*')||Request::is('products*')||Request::is('category-product*') ? 'active' : '' }}"
                   href="#">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/Sell.png')}}" alt="">
                        <span class="fs-18 show-text text-white">Bán hàng</span>
                        <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                    </div>
                </a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <div class="dropdown-item dropdown-menu__header">Bán hàng</div>
                            <div class="dropdown-menu__border">
                                <div></div>
                            </div>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Quản lý nhóm</a>
                            <ul>
                                @if($roleGlobal->permission('category.list'))
                                    <li><a href="{!! route('category.index') !!}">Nhóm dịch vụ</a></li>
                                @endif
                                @if($roleGlobal->permission('category-product.list'))
                                    <li><a href="{!! route('category-product.index') !!}">Nhóm sản phẩm</a></li>
                                @endif
                                @if($roleGlobal->permission('genitives.list'))
                                    <li><a href="{!! route('genitives.index') !!}">Nhóm tính cách</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Quản lý S.Phẩm & D.Vụ</a>
                            <ul>
                                @if($roleGlobal->permission('services.list'))
                                    <li><a href="{!! route('services.index') !!}">Danh sách dịch vụ</a></li>
                                    <li><a href="{!! route('tips.index') !!}">Danh sách thủ thuật (công)</a></li>
                                @endif
                                @if($roleGlobal->permission('products.list'))
                                    <li><a href="{!! route('products.index') !!}">Danh sách sản phẩm</a></li>
                                @endif
                            </ul>
                        </li>


                        @if($roleGlobal->permission('trademark.list'))
                            <li><a href="{!! route('trademark.index') !!}">Nhà cung cấp</a></li>
                        @endif

                        <li class="sub-with-sub">
                            <a href="#">Quản lý đơn hàng</a>
                            <ul>
                                @if($roleGlobal->permission('order.list'))
                                    <li><a href="{!! route('order.list') !!}">Danh sách đơn hàng</a></li>
                                @endif
                                @if($roleGlobal->permission('order.index_payment'))
                                    <li><a href="{!! route('order.index_payment') !!}">Đã thu trong kỳ</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Quản lý đơn nạp ví</a>
                            <ul>
                                @if($roleGlobal->permission('order.index_payment'))
                                    <li><a href="{!! route('payment-wallet.index') !!}">Đã thu trong kỳ</a></li>
                                @endif
                            </ul>
                        </li>
                        @if($roleGlobal->permission('order.orders-destroy'))
                            <li><a href="{!! route('order.orders-destroy') !!}">Đơn hàng bị xoá</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @if($roleGlobal->permission('tasks.employee'))
            <li class="nav-item">
                <a class="{{ Request::is('tasks') ? 'active' : '' }}"
                   href="{{url('tasks-employee')}}">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/CS1.png')}}" alt="">
                        <span class="fs-18 show-text text-white">CSKH</span>
                    </div>
                </a>
{{--                <div class="sub-item">--}}
{{--                    <ul>--}}
{{--                        @if($roleGlobal->permission('tasks.employee'))--}}
{{--                            <li><a href="{{url('tasks')}}">CSKH nhân viên</a></li>--}}
{{--                            <li><a href="{{url('tasks-employee')}}">CSKH phòng ban</a></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </div>--}}
            </li>
                @endif
            <li class="nav-item with-sub">
                <a class="{{ Request::is('statistics*')||Request::is('report*')||Request::is('history-sms') ? 'active' : '' }}"
                   href="#">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/Report.png')}}" alt="">
                        <span class="fs-18 show-text text-white">Thống kê</span>
                        <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                    </div>
                </a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <div class="dropdown-item dropdown-menu__header">Thống kê</div>
                            <div class="dropdown-menu__border">
                                <div></div>
                            </div>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Doanh số & Doanh thu</a>
                            <ul>
                                @if($roleGlobal->permission('statistics.index'))
                                    <li><a href="{{url('statistics')}}">Doanh thu</a></li>
                                @endif
                                @if($roleGlobal->permission('report.chart-revenue'))
                                    <li><a href="{{url('chart-revenue')}}">BĐ hệ thống</a></li>
                                @endif
                                @if($roleGlobal->permission('report.branchs'))
                                    <li><a href="{{route('report.branchs')}}">Nguồn thu từ đơn hệ thống</a></li>
                                @endif

                                <li><a href="{{url('chart-pay')}}">Duyệt chi</a></li>
                                @if($roleGlobal->permission('report.branch-source'))
                                    <li><a href="{{route('report.branch-source')}}">Báo cáo nguồn dữ liệu</a></li>
                                @endif
                                @if($roleGlobal->permission('report.groupSale'))
                                    <li><a href="{{url('report/group-sale')}}">Doanh số nhóm SP&DV</a></li>
                                @endif
                            </ul>
                        </li>

                        @if($roleGlobal->permission('report.mkt'))
                            <li class="sub-with-sub">
                                <a href="#">Marketing</a>
                                <ul>
                                    <li><a href="{{url('marketing/ranking')}}">Bảng xếp hạng</a></li>
                                    <li><a href="{{url('marketing/leader')}}">Báo cáo doanh thu</a></li>
                                </ul>
                            </li>
                        @endif

                        @if($roleGlobal->permission('report.sale') || $roleGlobal->permission('statistics.taskSchedules'))
                            <li class="sub-with-sub">
                                <a href="#">Telesales</a>
                                <ul>
                                    @if($roleGlobal->permission('report.sale'))
                                        <li><a href="{{url('report/sale-ranking')}}">Bảng xếp hạng</a></li>
                                        <li><a href="{{url('report/sales')}}">Báo cáo doanh thu</a></li>
                                    @endif
                                    @if($roleGlobal->permission('statistics.taskSchedules'))
                                        <li><a href="{{url('statistics-task')}}">BĐ C.việc & lịch hẹn</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        <li class="sub-with-sub">
                            <a href="#">Phòng ban khác</a>
                            <ul>
                                @if($roleGlobal->permission('report.cskh'))
                                    <li><a href="{{url('report/cskh')}}">Xếp hạng CSKH</a></li>
                                @endif
                                @if($roleGlobal->permission('carepage.index'))
                                    <li><a href="{{url('marketing/carepage-ranking')}}">Xếp hạng CarePage</a></li>
                                    <li><a href="{{url('marketing/carepage')}}">Báo cáo DT CarePage</a></li>
                                @endif
                                @if($roleGlobal->permission('report.waiters'))
                                    <li><a href="{{url('report/waiters')}}">Báo cáo DT lễ tân</a></li>
                                @endif
                                @if($roleGlobal->permission('report.commission'))
                                    <li><a href="{{url('report/commission')}}">Báo cáo KTV</a></li>
                                @endif
                                <li><a href="/report/hoa-hong-ctv">Hoa hồng CTV</a></li>
                                <li><a href="/report/hoa-hong">Hoa hồng nhân viên</a></li>
                            </ul>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">Khác</a>
                            <ul>
                                <li><a href="{{url('statistics-personal')}}">Biểu đồ nhân sự</a></li>
                                @if($roleGlobal->permission('sms.history'))
                                    <li><a href="{{url('history-sms')}}">Tin nhắn đã gửi</a></li>
                                @endif
                                @if($roleGlobal->permission('report.tasks'))
                                    <li><a href="{{url('report/tasks')}}">Hiệu quả công việc</a></li>
                                @endif
                            </ul>
                        </li>
                        @if($roleGlobal->permission('call-center'))
                            <li><a href="{{route('call-center.index')}}">Quản lý tổng đài</a></li>
                        @endif

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="{{ Request::is('depots/product') ? 'active' : '' }}" href="#">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/Storage.png')}}" alt="">
                        <span class="fs-18 show-text text-white">Kho vận</span>
                        <img class="down" src="{{'layout/images/Down.png'}}" alt="">
                    </div>
                </a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <div class="dropdown-item dropdown-menu__header">Kho vận</div>
                            <div class="dropdown-menu__border">
                                <div></div>
                            </div>
                        </li>
                        <li><a href="{{url('depots/product')}}">Sản phẩm kho</a></li>
                        <li><a href="{{url('depots/history')}}">Lich sử nhập, xuất kho</a></li>
                        <li><a href="{{url('depots/statistical')}}">Báo cáo tồn</a></li>
                    </ul>
                </div>
            </li>

            @if($roleGlobal->permission('thu-chi.list'))
                <li class="nav-item">
                    <a class="{{ Request::is('danh-muc-thu-chi*')||Request::is('thu-chi*') ? 'active' : '' }}"
                       href="#">
                        <div class="gradient-btn">
                            <img src="{{asset('layout/images/Money2.png')}}" alt="">
                            <span class="fs-18 show-text text-white">Duyệt chi</span>
                            <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                        </div>
                    </a>
                    <div class="sub-item">
                        <ul>
                            <li>
                                <div class="dropdown-item dropdown-menu__header">Duyệt chi</div>
                                <div class="dropdown-menu__border">
                                    <div></div>
                                </div>
                            </li>
                            @if($roleGlobal->permission('danh-muc-thu-chi.index'))
                                <li><a href="{{url('danh-muc-thu-chi')}}">Danh mục duyệt chi</a></li>
                                <li><a href="{{url('ly-do-thu-chi')}}">Lý do duyệt chi</a></li>
                            @endif
                                @if($roleGlobal->permission('thu-chi.list'))
                                    <li><a href="{{url('thu-chi')}}">Danh sách duyệt chi</a></li>
                                @endif
                        </ul>
                    </div>
                </li>
            @endif

            <li class="nav-item">
                <a class="{{ Request::is('settings*')||Request::is('settings*') ? 'active' : '' }}"
                   href="#">
                    <div class="gradient-btn">
                        <img src="{{asset('layout/images/Employee.png')}}" alt="">
                        <span class="fs-18 show-text text-white">Nhân sự</span>
                        <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                    </div>
                </a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <div class="dropdown-item dropdown-menu__header">Nhân sự</div>
                            <div class="dropdown-menu__border">
                                <div></div>
                            </div>
                        </li>
                        @if($roleGlobal->permission('time-status.index'))
                            <li><a href="{{url('settings/time-status')}}">Cài đặt thời gian</a></li>
                        @endif

                        <li class="sub-with-sub">
                            <a href="#">Chấm công</a>
                            <ul>
                                @if($roleGlobal->permission('cham_cong.list'))
                                    <li><a href="{{url('approval/statistic')}}">DS Chấm công</a></li>
                                @endif
                                @if($roleGlobal->permission('history_approval.list'))
                                    <li><a href="{{url('approval/history')}}">Chi tiết chấm công</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="sub-with-sub">
                            <a href="#">Bảng lương</a>
                            <ul>
                                @if($roleGlobal->permission('history_salary.list'))
                                    <li><a href="{{url('approval/history-import-salary')}}">Nhập bảng lương</a></li>
                                @endif
                                @if($roleGlobal->permission('salary.list'))
                                    <li><a href="{{url('approval/salary')}}">Bảng lương</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="sub-with-sub">
                            <a href="#">Đơn từ</a>
                            <ul>
                                @if($roleGlobal->permission('don_tu.list'))
                                    <li><a href="{{url('approval/order')}}">Đơn từ</a></li>
                                @endif
                                @if($roleGlobal->permission('reason.list'))
                                    <li><a href="{{url('approval/reason')}}">Lý do đơn từ</a></li>
                                @endif
                            </ul>
                        </li>
                        @if($roleGlobal->permission('teams.list'))
                            <li><a href="{{route('teams.index')}}">Quản lý đội nhóm</a></li>
                        @endif

                    </ul>
                </div>
            </li>

        </ul>
        </div>





        <div class="profile d-flex align-items-center gap-16">
            <input id="check_notify" type="hidden">
            <div class="btn-group notice pointer notification">
                <img src="{{asset('layout/images/Notii.png')}}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">
                        <div class="fs-24 font-sopher text-white">Thông báo</div>
                        <div class="">
                            <img src="{{asset('layout/images/Checks.png')}}" alt="">
                            <span class="color-info">Đánh dấu là đã đọc</span>
                        </div>
                    </a>
                    <div class="content-notify">

                    </div>
                    <a class="dropdown-item text-center text-muted-dark"
                       href="{{route('notifications.index')}}">Xem tất cả</a>
                </div>
                <audio id="myAudio">
                    <source src="{{asset('default/sound-notification.mp3')}}" type="audio/ogg">
                </audio>
                <button id="btn_audio" style="display: none"></button>
            </div>



            {{--<div class="btn-group notice pointer">--}}
                {{--<input id="check_notify" type="hidden">--}}

                {{--<div class="dropdown dropdown-notification d-none d-md-flex">--}}
                    {{--<a class="nav-link icon notification margin-right0" data-toggle="dropdown"><i--}}
                            {{--style="color: #3691ef;"--}}
                            {{--class="fas fa-bell"></i> <span--}}
                            {{--class="badge badge-danger badge-pill position0">10</span></a>--}}
                    {{--<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"--}}
                         {{--style="overflow: auto;max-height: 400px">--}}
                        {{--<a class="dropdown-item text-center text-dark" href="#">2 New Messages</a>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<div class="content-notify">--}}

                        {{--</div>--}}
                        {{--<div class="dropdown-divider"></div>--}}
                        {{--<a class="dropdown-item text-center text-muted-dark"--}}
                           {{--href="{{route('notifications.index')}}">Xem tất cả</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<audio id="myAudio">--}}
                    {{--<source src="{{asset('default/sound-notification.mp3')}}" type="audio/ogg">--}}
                {{--</audio>--}}
                {{--<button id="btn_audio" style="display: none"></button>--}}
            {{--</div>--}}

            <div class="dropdown dropdown-custom">
                {{--<a class="pr-0 leading-none d-flex" data-toggle="dropdown" href="#">--}}
                    {{--@if(\Auth::user()->avatar)--}}
                        {{--<span class="avatar avatar-md brround "--}}
                              {{--style="background-image: url({{ url(\Auth::user()->avatar) }})"></span>--}}
                    {{--@else--}}
                        {{--<span class="avatar avatar-md brround"--}}
                              {{--style="background-image: url(/assets/images/faces/female/25.jpg)"></span>--}}
                    {{--@endif--}}
                    {{--<span class="ml-2 d-none d-lg-block username">--}}
                    {{--<span class="" style="color: #7490BD">{!! str_limit(Auth::user()->full_name,20) !!}</span>--}}
                {{--</span>--}}
                {{--</a>--}}


                <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                   data-toggle="dropdown" aria-expanded="false">
                    <div class="avatar">
                        @if(\Auth::user()->avatar)
                            <img src="{{ url(\Auth::user()->avatar) }}" alt="">
                        @else
                            <img src="{{ url('assets/images/faces/female/25.jpg') }}" alt="">
                        @endif

                    </div>
                    <div class="username text-white">
                        <span class="fs-16">{!! str_limit(Auth::user()->full_name,20) !!}</span>
                    </div>
                    <img class="down" src="{{asset('layout/images/Down.png')}}" alt="">
                </a>


                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ url('users/'.Auth::user()->id . '/edit') }}"><i
                                class="dropdown-icon mdi mdi-face-profile"></i> Cài đặt tài khoản</a>
                    @if($roleGlobal->permission('users.list'))
                        <a class="dropdown-item" href="{!! route('users.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-outline"></i> Quản lý người dùng</a>
                    @endif

                    @if($roleGlobal->permission('department.list'))
                        <a class="dropdown-item" href="{!! route('department.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-multiple"></i> Quản lý phòng ban</a>
                    @endif

                    @if(empty($permissions) || !in_array('sms.index',$permissions))
                        @if($roleGlobal->permission('sms'))
                            <a class="dropdown-item" href="{!! route('sms.index') !!}">
                                <i class="dropdown-icon fas fa-envelope"></i> Quản lý tin nhắn
                            </a>
                        @endif
                    @endif
                    @if($roleGlobal->permission('status.list'))
                        <a class="dropdown-item" href="{!! route('status.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-card-details"></i> Quản lý CRM</a>
                    @endif
                    @if(empty($permissions) || !in_array('package.index',$permissions))
                        @if($roleGlobal->permission('settings'))
                            <a class="dropdown-item" href="{!! route('package.index') !!}"><i
                                        class="dropdown-icon mdi mdi-monitor"></i> Quản lý gói nạp ví</a>
                        @endif
                    @endif
                    @if(empty($permissions) || !in_array('settings.index',$permissions))
                        @if($roleGlobal->permission('settings'))
                            <a class="dropdown-item" href="{!! route('settings.index') !!}"><i
                                        class="dropdown-icon mdi mdi-settings"></i> Cài đặt chung</a>
                        @endif
                    @endif

                    @if($roleGlobal->permission('roles.list'))
                        <a class="dropdown-item" href="{!! route('roles.index') !!}">
                            <i class="dropdown-icon mdi mdi-percent"></i> Quản lý phân quyền</a>
                    @endif

                    @if($roleGlobal->permission('leaderSale'))
                        <div class="col" style="color: #7490BD;font-weight: 400">
                            <label class="switch">
                                <input name="checkbox" class="check"
                                       type="checkbox" {{setting('view_customer_sale')==\App\Constants\StatusCode::ON?'checked':''}}>
                                <span class="slider round"></span>
                            </label>
                            Sale xem tất cả KH
                        </div>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a href="{!! url('/logout') !!}" class="dropdown-item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="dropdown-icon mdi mdi-logout-variant"></i>
                        Đăng xuất
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
















    </div>
</div>
<script>
    $('.check').change(function () {
        if (this.checked) {
            var value = 1;
        } else {
            var value = 0;
        }
        $.ajax({
            url: "{{url('ajax/settings')}}",
            method: "get",
            data: {
                value: value,
            }
        }).done(function (data) {

        });
    })
</script>

<!-- Horizantal menu-->
