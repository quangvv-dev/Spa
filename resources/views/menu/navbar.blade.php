<style>
    a.dropdown-item.d-flex.pb-3.tag-click {
        border-bottom: 1px solid #e9ecef;
    }

    .text-notification {
        width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 20px;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
</style>
@php
    $roleGlobal = auth()->user()?:[];
@endphp
{{--<header class="app-header header shadow-none relative">--}}
    {{--<div id="particles-js"></div>--}}
    {{--<div class="container">--}}

        {{--<!-- Header Background Animation-->--}}
        {{--<div id="canvas" class="gradient"></div>--}}

        {{--<!-- Navbar Right Menu-->--}}
        {{--<div class="container-fluid">--}}
            {{--<div class="d-flex">--}}
                {{--<a class="header-brand" href="{{ route('users.index') }}">--}}
                    {{--<img alt="ren logo" class="header-brand-img"--}}
                         {{--src="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}">--}}
                {{--</a>--}}
                {{--<div class="d-flex order-lg-2 ml-auto">--}}
                    {{--<div class="">--}}
                        {{--<form class="input-icon  mr-2">--}}
                            {{--<input class="form-control header-search" placeholder="Search&hellip;" tabindex="1"--}}
                                   {{--type="search">--}}
                            {{--<div class="input-icon-addon">--}}
                                {{--<i class="fe fe-search"></i>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    {{--<input id="check_notify" type="hidden">--}}
                    {{--<div class="dropdown d-none d-md-flex">--}}
                        {{--<a class="nav-link icon notification" data-toggle="dropdown"><i class="fas fa-bell"></i> <span--}}
                                    {{--class="badge badge-danger badge-pill">10</span></a>--}}
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

                    {{--<div class="dropdown">--}}
                        {{--<a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">--}}
                            {{--@if(Auth::user()->avatar)--}}
                                {{--<span class="avatar avatar-md brround "--}}
                                      {{--style="background-image: url({{ url(Auth::user()->avatar) }})"></span>--}}
                            {{--@else--}}
                                {{--<span class="avatar avatar-md brround"--}}
                                      {{--style="background-image: url(/assets/images/faces/female/25.jpg)"></span>--}}
                            {{--@endif--}}
                            {{--<span class="ml-2 d-none d-lg-block">--}}
												{{--<span class="text-white">{!! Auth::user()->full_name !!}</span>--}}
											{{--</span>--}}
                        {{--</a>--}}
                        {{--<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">--}}
                            {{--<a class="dropdown-item" href="{{ url('users/'.Auth::user()->id . '/edit') }}"><i--}}
                                        {{--class="dropdown-icon mdi mdi-face-profile"></i> Cài đặt tài khoản</a>--}}
                            {{--@if($roleGlobal->permission('users.list'))--}}
                                {{--<a class="dropdown-item" href="{!! route('users.index') !!}"><i--}}
                                            {{--class="dropdown-icon mdi mdi-account-outline"></i> Quản lý người dùng</a>--}}
                            {{--@endif--}}

                            {{--@if($roleGlobal->permission('department.list'))--}}
                                {{--<a class="dropdown-item" href="{!! route('department.index') !!}"><i--}}
                                            {{--class="dropdown-icon mdi mdi-account-multiple"></i> Quản lý phòng ban</a>--}}
                            {{--@endif--}}

                            {{--@if(empty($permissions) || !in_array('sms.index',$permissions))--}}
                                {{--@if($roleGlobal->permission('sms'))--}}
                                    {{--<a class="dropdown-item" href="{!! route('sms.index') !!}">--}}
                                        {{--<i class="dropdown-icon fas fa-envelope"></i> Quản lý tin nhắn--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--@endif--}}
                            {{--@if($roleGlobal->permission('status.list'))--}}
                                {{--<a class="dropdown-item" href="{!! route('status.index') !!}"><i--}}
                                            {{--class="dropdown-icon mdi mdi-account-card-details"></i> Quản lý CRM</a>--}}
                            {{--@endif--}}
                            {{--@if(empty($permissions) || !in_array('package.index',$permissions))--}}
                                {{--@if($roleGlobal->permission('package.list'))--}}
                                    {{--<a class="dropdown-item" href="{!! route('package.index') !!}"><i--}}
                                                {{--class="dropdown-icon mdi mdi-monitor"></i> Quản lý gói nạp ví</a>--}}
                                {{--@endif--}}
                            {{--@endif--}}
                            {{--@if(empty($permissions) || !in_array('settings.index',$permissions))--}}
                                {{--@if($roleGlobal->permission('settings'))--}}
                                {{--<a class="dropdown-item" href="{!! route('settings.index') !!}"><i--}}
                                            {{--class="dropdown-icon mdi mdi-settings"></i> Cài đặt chung</a>--}}
                                {{--@endif--}}
                            {{--@endif--}}

                            {{--@if($roleGlobal->permission('roles.list'))--}}
                                {{--<a class="dropdown-item" href="{!! route('roles.index') !!}"><i--}}
                                        {{--class="dropdown-icon mdi mdi-settings"></i> Quản lý phân quyền</a>--}}
                            {{--@endif--}}

                            {{--@if($roleGlobal->permission('leaderSale'))--}}
                                {{--<div class="col" style="color: #7490BD;font-weight: 400">--}}
                                    {{--<label class="switch">--}}
                                        {{--<input name="checkbox" class="check"--}}
                                               {{--type="checkbox" {{setting('view_customer_sale')==\App\Constants\StatusCode::ON?'checked':''}}>--}}
                                        {{--<span class="slider round"></span>--}}
                                    {{--</label>--}}
                                    {{--Sale xem tất cả KH--}}
                                {{--</div>--}}
                            {{--@endif--}}
                            {{--<div class="dropdown-divider"></div>--}}
                            {{--<a href="{!! url('/logout') !!}" class="dropdown-item"--}}
                               {{--onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
                                {{--<i class="dropdown-icon mdi mdi-logout-variant"></i>--}}
                                {{--Đăng xuất--}}
                            {{--</a>--}}

                            {{--<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">--}}
                                {{--{{ csrf_field() }}--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"--}}
                   {{--data-target="#headerMenuCollapse">--}}
                    {{--<span class="header-toggler-icon"></span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</header>--}}
{{--<script>--}}
    {{--$('.check').change(function () {--}}
        {{--if (this.checked) {--}}
            {{--var value = 1;--}}
        {{--} else {--}}
            {{--var value = 0;--}}
        {{--}--}}
        {{--$.ajax({--}}
            {{--url: "{{url('ajax/settings')}}",--}}
            {{--method: "get",--}}
            {{--data: {--}}
                {{--value: value,--}}
            {{--}--}}
        {{--}).done(function (data) {--}}

        {{--});--}}
    {{--})--}}
{{--</script>--}}
