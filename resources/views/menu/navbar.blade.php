<header class="app-header header shadow-none relative">
    <div id="particles-js" ></div>
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
                            <input class="form-control header-search" placeholder="Search&hellip;" tabindex="1" type="search">
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
                                <span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/male/4.jpg)"></span>
                                <div>
                                    <strong>Madeleine Scott</strong> Sent you add request
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/female/14.jpg)"></span>
                                <div>
                                    <strong>rebica</strong> Suggestions for you
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/male/1.jpg)"></span>
                                <div>
                                    <strong>Devid robott</strong> sent you add request
                                    <div class="small text-muted">
                                        view profile
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div><a class="dropdown-item text-center text-muted-dark" href="#">View all contact list</a>
                        </div>
                    </div>
                    <div class="dropdown d-none d-md-flex">
                        <a class="nav-link icon" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="nav-unread bg-danger"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <div class="notifyimg">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <div>
                                    <strong>Someone likes our posts.</strong>
                                    <div class="small text-muted">
                                        3 hours ago
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <div class="notifyimg">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div>
                                    <strong>3 New Comments</strong>
                                    <div class="small text-muted">
                                        5 hour ago
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <div class="notifyimg">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <strong>Server Rebooted.</strong>
                                    <div class="small text-muted">
                                        45 mintues ago
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center text-muted-dark" href="#">View all Notification</a>
                        </div>
                    </div>
                    <div class="dropdown d-none d-md-flex">
                        <a class="nav-link icon" data-toggle="dropdown"><i class="fas fa-envelope"></i> <span class="badge badge-info badge-pill">2</span></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item text-center text-dark" href="#">2 New Messages</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex pb-3" href="#">
                                <span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/male/41.jpg)"></span>
                                <div>
                                    <strong>Madeleine</strong> Hey! there I' am available....
                                    <div class="small text-muted">
                                        3 hours ago
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/female/1.jpg)"></span>
                                <div>
                                    <strong>Anthony</strong> New product Launching...
                                    <div class="small text-muted">
                                        5 hour ago
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex pb-3" href="#"><span class="avatar brround mr-3 align-self-center" style="background-image: url(/assets/images/faces/female/18.jpg)"></span>
                                <div>
                                    <strong>Olivia</strong> New Schedule Realease......
                                    <div class="small text-muted">
                                        45 mintues ago
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center text-muted-dark" href="#">See all Messages</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="nav-link pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
                            @if(Auth::user()->avatar)
                            <span class="avatar avatar-md brround " style="background-image: url({{ url(Auth::user()->avatar) }})"></span>
                            @else
                                <span class="avatar avatar-md brround" style="background-image: url(/assets/images/faces/female/25.jpg)"></span>
                            @endif
                            <span class="ml-2 d-none d-lg-block">
												<span class="text-white">{!! Auth::user()->full_name !!}</span>
											</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ url('profiles/' .  Auth::user()->id . '/edit') }}"><i class="dropdown-icon mdi mdi-settings"></i> Cài đặt tài khoản</a>
                            @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN)
                            <a class="dropdown-item" href="{!! route('users.index') !!}"><i class="dropdown-icon mdi mdi-account-outline"></i> Quản lý người dùng</a>
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
                <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon"></span>
                </a>
            </div>
        </div>
    </div>
</header>
