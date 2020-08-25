<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link {{ Request::is('statistics')? 'active' : '' }}" href="{!! url('statistics') !!}"><i--}}
                        {{--class="fas fa-newspaper"></i><span>Chi nhánh</span></a>--}}
            {{--</li>--}}
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('statistics') ? 'active' : '' }}" href="#"><i class="fas fa-newspaper"></i><span>Chi nhánh</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('statistics.index') !!}">Doanh thu</a>
                        </li>
                        <li>
                            <a href="{{url('report/sales')}}">Telesales</a>
                        </li>
                        {{--<li>--}}
                        {{--<a href="{!! route('statistics.sales') !!}">Sale</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('statistics-branch*')||Request::is('statistics-sales*') ? 'active' : '' }}" href="#"><i class="fas fa-newspaper"></i><span>Toàn hệ thống</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('statistics.branch') !!}">Doanh thu</a>
                        </li>
                        <li>
                            <a href="{!! route('statistics.sales') !!}">Telesales</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
