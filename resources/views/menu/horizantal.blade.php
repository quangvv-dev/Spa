<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('statistics')? 'active' : '' }}" href="{!! url('statistics') !!}"><i
                        class="fas fa-newspaper"></i><span>Chi nhánh</span></a>
            </li>
            <li class="nav-item" >
                <a class="nav-link {{ Request::is('statistics-branch*')? 'active' : '' }}" href="{!! url('statistics-branch') !!}"><i
                        class="fas fa-newspaper"></i><span>Toàn hệ thống</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
