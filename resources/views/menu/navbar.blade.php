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
<header class="app-header header shadow-none relative">
    <div id="particles-js"></div>
    <div class="container">

        <!-- Header Background Animation-->
        <div id="canvas" class="gradient"></div>

        <!-- Navbar Right Menu-->
        <div class="container-fluid">
            <div class="d-flex">
                <a class="header-brand" href="{{ route('users.index') }}">
                    <img alt="ren logo" class="header-brand-img" src="/assets/images/brand/logo.png">
                </a>
                <div class="d-flex order-lg-2 ml-auto">
                    <div class="">
                        <form class="input-icon  mr-2">
                            <input class="form-control header-search" placeholder="Search&hellip;" tabindex="1"
                                   type="search">
                            <div class="input-icon-addon">
                                <i class="fe fe-search"></i>
                            </div>
                        </form>
                    </div>
                    <div class="dropdown d-none d-md-flex">
                        <a class="nav-link icon" data-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            <span class="nav-unread bg-green"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center"
                                      style="background-image: url(/assets/images/faces/male/4.jpg)"></span>
                                <div>
                                    <strong>Madeleine Scott</strong> Sent you add request
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center"
                                      style="background-image: url(/assets/images/faces/female/14.jpg)"></span>
                                <div>
                                    <strong>rebica</strong> Suggestions for you
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center"
                                      style="background-image: url(/assets/images/faces/male/1.jpg)"></span>
                                <div>
                                    <strong>Devid robott</strong> sent you add request
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center text-muted-dark" href="#">View all contact list</a>
                        </div>
                    </div>
                    <input id="check_notify" type="hidden">
                    <div class="dropdown d-none d-md-flex">
                        <a class="nav-link icon notification" data-toggle="dropdown"><i class="fas fa-bell"></i> <span
                                class="badge badge-danger badge-pill">10</span></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                             style="overflow: auto;max-height: 400px">
                            <a class="dropdown-item text-center text-dark" href="#">2 New Messages</a>
                            <div class="dropdown-divider"></div>
                            <div class="content-notify">

                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center text-muted-dark"
                               href="{{route('notifications.index')}}">Xem tất cả</a>
                        </div>
                    </div>

                    <audio id="myAudio">
                        <source
                            src="https://notificationsounds.com/soundfiles/a86c450b76fb8c371afead6410d55534/file-sounds-1108-slow-spring-board.mp3"
                            type="audio/ogg">
                    </audio>
                    <button id="btn_audio" style="display: none"></button>

                    <div class="dropdown">
                        <a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
                            @if(Auth::user()->avatar)
                                <span class="avatar avatar-md brround "
                                      style="background-image: url({{ url(Auth::user()->avatar) }})"></span>
                            @else
                                <span class="avatar avatar-md brround"
                                      style="background-image: url(/assets/images/faces/female/25.jpg)"></span>
                            @endif
                            <span class="ml-2 d-none d-lg-block">
												<span class="text-white">{!! Auth::user()->full_name !!}</span>
											</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ url('users/'.Auth::user()->id . '/edit') }}"><i
                                    class="dropdown-icon mdi mdi-face-profile"></i> Cài đặt tài khoản</a>
                            @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN)
                                <a class="dropdown-item" href="{!! route('users.index') !!}"><i
                                        class="dropdown-icon mdi mdi-account-outline"></i> Quản lý người dùng</a>
                                <a class="dropdown-item" href="{!! route('department.index') !!}"><i
                                        class="dropdown-icon mdi mdi-account-multiple"></i> Quản lý phòng ban</a>
                                @if(empty($permissions) || !in_array('sms.index',$permissions))
                                    <a class="dropdown-item" href="{!! route('sms.index') !!}">
                                        <i class="dropdown-icon fas fa-envelope"></i> Quản lý tin nhắn
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{!! route('status.index') !!}"><i
                                        class="dropdown-icon mdi mdi-account-card-details"></i> Quản lý CRM</a>
                                @if(empty($permissions) || !in_array('package.index',$permissions))
                                    <a class="dropdown-item" href="{!! route('package.index') !!}"><i
                                            class="dropdown-icon mdi mdi-monitor"></i> Quản lý gói nạp ví</a>
                                @endif
                                @if(empty($permissions) || !in_array('settings.index',$permissions))
                                    <a class="dropdown-item" href="{!! route('settings.index') !!}"><i
                                            class="dropdown-icon mdi mdi-settings"></i> Cài đặt chung</a>
                                @endif

                            @endif
                            @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN|| \Illuminate\Support\Facades\Auth::user()->phone=='0977508510'|| \Illuminate\Support\Facades\Auth::user()->phone=='0776904396')
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
                <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                   data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon"></span>
                </a>
            </div>
        </div>
    </div>
</header>
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
