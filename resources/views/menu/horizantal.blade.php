<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('statistics*')||Request::is('report/sales*') ? 'active' : '' }}" href="#"><i class="fas fa-newspaper"></i><span>Chi nhánh</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('statistics.index') !!}">Doanh thu</a>
                        </li>
                        <li>
                            <a href="{{url('report/sales')}}">Telesales</a>
                        </li>
                        <li>
                        <a href="{!! route('statistics.campaign_branch') !!}">Chiến dịch</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('statistics-branch*')||Request::is('statistics-sales*')||Request::is('task-schedules*') ? 'active' : '' }}" href="#"><i class="fas fa-newspaper"></i><span>Toàn hệ thống</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('statistics.branch') !!}">Doanh thu</a>
                        </li>
                        <li>
                            <a href="{!! route('statistics.sales') !!}">Telesales</a>
                        </li>
                        <li>
                            <a href="{!! route('statistics.task_schedule') !!}">Công việc & lịch hẹn</a>
                        </li>
                        <li>
                            <a href="{!! route('statistics.campaign') !!}">Chiến dịch</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--<li class="nav-item with-sub">--}}
                {{--<a class="nav-link {{ Request::is('statistics-branch*')||Request::is('statistics-sales*') ? 'active' : '' }}" href="#"><i class="fas fa-newspaper"></i><span>QL TELESALES</span></a>--}}
                {{--<div class="sub-item">--}}
                    {{--<ul>--}}
                        {{--<li>--}}
                            {{--<a href="{!! route('statistics.task_schedule') !!}">Công việc & lịch hẹn</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="{!! route('statistics.sales') !!}">Telesales</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="{!! route('statistics.campaign') !!}">Chiến dịch</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</li>--}}
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
