<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='shortcut icon' type='image/x-icon' href='/laningpage/frontend/Icon/favicon.ico'/>
    <title>Royal Spa</title>
    <!-- Begin Builder -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .error {
            color: #fff;
        }
    </style>
{{--<script src="{{asset('laningpage/frontend/js/builder.js')}}"></script>--}}
<!-- End Builder -->
    <link rel="stylesheet" type="text/css" href="{{asset('laningpage/frontend/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('laningpage/frontend/css/drawer.min.css')}}">
    <style>
        @media (max-width: 768px) {

            .contents img {
                width: 100% !important;
            }

            .add {
                height: 30px;
            }
        }

        @media (min-width: 992px) {
            .news-events .list-news .news-item .image-news-container .image-news {
                width: 12em;
            }
        }

        button.btn.button-container.book-appointment-container:focus {
            outline: none;
        }

    </style>
</head>

<body>
<header class="header">
    <div class="container">
        <ul class="navigation-tool">
            <li class="navigation-item header-logo">
                <a href="#">
                    <h1><img class="navigation-logo" src="/laningpage/frontend/Icon/logo.png" alt="royal spa logo"></h1>
                </a>
            </li>
            <li class="navigation-item">
                <a class="navigation-link" href="#">
                    <img class="navigation-image" src="/laningpage/frontend/Icon/gioithieu.png"
                         alt="royal icon introduce"/>
                    <p>Giới thiệu</p>
                </a>
            </li>
            <li class="navigation-item dropdown">
                <button class="btn navigation-link" id="dLabel" type="button" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <img class="navigation-image" src="/laningpage/frontend/Icon/dichvu.png" alt="royal icon calendar"/>
                    Dịch vụ
                </button>
                {{--<ul class="dropdown-menu navigation-sub" aria-labelledby="dLabel">--}}
                {{--<li><a class="dropdown-item" href="#">Trị mụn, sẹo</a></li>--}}
                {{--<li><a class="dropdown-item" href="#">Trị viêm nang lông</a></li>--}}
                {{--<li><a class="dropdown-item" href="#">Trị hôi nách</a></li>--}}
                {{--</ul>--}}
            </li>
            <li class="navigation-item">
                <a class="navigation-link" href="#">
                    <img class="navigation-image" src="/laningpage/frontend/Icon/datlich.png"
                         alt="royal icon calendar"/>
                    <p>Đặt lịch</p>
                </a>
            </li>
            <li class="navigation-item">
                <a class="navigation-link" href="#">
                    <img class="navigation-image" src="/laningpage/frontend/Icon/tintuc.png" alt="royal icon info"/>
                    <p>Tin Tức</p>
                </a>
            </li>
            <li class="navigation-item">
                <a class="navigation-link" href="#">
                    <img class="navigation-image edu" src="/laningpage/frontend/Icon/daotao.png"
                         alt="royal icon educate"/>
                    <p>Đào tạo</p>
                </a>
            </li>
            <li class="navigation-item-more">
                <a class="navigation-more-link" href="tel:{{$post->phone}}">Liên Hệ</a>
                <a class="navigation-button-container" href="#dang-ky">
                    <button class="navigation-button btn-royal">
                        <p class="navigation-button-content">Đăng ký tư vấn</p>
                    </button>
                </a>
            </li>
        </ul>
    </div>
</header>

<!-- header mobile, tablet -->
{{--<div class="drawer drawer--left header-xs">--}}
    {{--<div class="header-bg-xs">--}}
        {{--<h1 class="header-logo-xs">--}}
            {{--<a href="/">--}}
                {{--<img class="logo-xs" src="/laningpage/frontend/Icon/logo.png" alt="Royal Spa Logo">--}}
            {{--</a>--}}
        {{--</h1>--}}
        {{--<img class="header-search" src="/laningpage/frontend/Icon/icon-search.png" alt="royal icon search">--}}
    {{--</div>--}}
    {{--<header role="banner">--}}
        {{--<button type="button" class="drawer-toggle drawer-hamburger">--}}
            {{--<span class="sr-only">toggle navigation</span>--}}
            {{--<span><img src="/laningpage/frontend/Icon/icon-burger.png" alt="royal icon burger"></span>--}}
        {{--</button>--}}
        {{--<nav class="drawer-nav" role="navigation">--}}
            {{--<ul class="drawer-menu">--}}
                {{--<li class="navigation-item">--}}
                    {{--<a class="navigation-link" href="/">--}}
                        {{--<img class="navigation-image" src="/laningpage/frontend/Icon/gioithieu.png"--}}
                             {{--alt="royal icon introduce"/>--}}
                        {{--<p>Giới thiệu</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="navigation-item">--}}
                    {{--<button class="btn navigation-link" type="button" data-toggle="collapse" data-target="#services"--}}
                            {{--aria-expanded="false" aria-controls="services">--}}
                        {{--<img class="navigation-image" src="/laningpage/frontend/Icon/dichvu.png"--}}
                             {{--alt="royal icon person"/>--}}
                        {{--<p>Dịch vụ</p>--}}
                    {{--</button>--}}
                    {{--<div class="collapse navigation-collapse" id="services">--}}
                        {{--<ul class="well">--}}
                            {{--<li><a class="dropdown-item" href="/tri-mun-seo">Trị mụn, sẹo</a></li>--}}
                            {{--<li><a class="dropdown-item" href="/tri-viem-nang-long">Trị viêm nang lông</a></li>--}}
                            {{--<li><a class="dropdown-item" href="/tri-hoi-nach">Trị hôi nách</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li class="navigation-item">--}}
                    {{--<a class="navigation-link" href="#dang-ky">--}}
                        {{--<img class="navigation-image" src="/laningpage/frontend/Icon/datlich.png"--}}
                             {{--alt="royal icon calendar"/>--}}
                        {{--<p>Đặt lịch</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="navigation-item">--}}
                    {{--<a class="navigation-link" href="/tin-tuc">--}}
                        {{--<img class="navigation-image" src="/laningpage/frontend/Icon/tintuc.png" alt="royal icon info"/>--}}
                        {{--<p>Tin Tức</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="navigation-item">--}}
                    {{--<a class="navigation-link" href="http://tonysy.vn" target="_blank">--}}
                        {{--<img src="/laningpage/frontend/Icon/daotao.png" alt="royal icon educate"/>--}}
                        {{--<p>Đào tạo</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</nav>--}}
    {{--</header>--}}

{{--</div>--}}
<div class="container">
    <div class="row">
        <section class="contents col-md-12 col-sm-12">
            <h1 class="content-title">{{@$post->title}}</h1>
            {!! @$post->content !!}
        </section>
    </div>
</div>
<section class="register">
    <div class="container">
        <div class="row register-container">
            {{--<article class="col-12 col-md-4 regiser-content-container">--}}
                {{--<div class="regiser-content">--}}
                    {{--<a href="/"><img class="register-logo"--}}
                                     {{--src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="--}}
                                     {{--data-scroll="/laningpage/frontend/Icon/logo.png" alt="royal logo"/></a>--}}
                    {{--<p class="img-responsive center-block register-deserved" data-key="347">Viện Thẩm Mỹ Royal xứng--}}
                        {{--đáng là lựa chọn hoàn hảo nhất giúp nét đẹp Việt được thăng hoa.</p>--}}
                    {{--<p class="register-content-desc" data-key="348">Hãy sử dụng đặc quyền làm đẹp của mình ngay hôm--}}
                        {{--nay, chúng tôi sẽ giúp bạn được tỏa sáng !</p>--}}
                {{--</div>--}}
            {{--</article>--}}
            {{--<div class="col-12 col-md-3 register-img">--}}
                {{--<img class="register-girl" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="--}}
                     {{--data-scroll="/laningpage/frontend/images/register-girl.png" alt="royal girl face"/>--}}
            {{--</div>--}}
            <div class="col-12 col-md-5 register-form-container" id="dang-ky">
                <div class="add"></div>
                <form id="my_Form" class="register-form" method="post" action="">
                    <h2 class="register-title" data-key="customer-432">ĐĂNG KÝ NHẬN QUÀ</h2>
                    <input class="register-input" type="text" name="full_name" placeholder="Họ tên khách hàng"
                           required/>
                    <input class="register-input" type="text" name="phone" placeholder="Số điện thoại" required/>
                    <input class="register-input" type="text" name="note" placeholder="Dịch vụ cần tư vấn thêm"/>
                    <input class="register-input" type="hidden" name="slug" value="{{request()->segment(2)}}"/>
                    <input id="js-register-button" class="register-button-submit btn-royal" type="submit"
                           value="NHẬN QUÀ NGAY"/>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- modal -->
{{--<div class="modal fade" id="customer-book" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
{{--<div class="modal-dialog modal-layout">--}}
{{--<!--Modal content-->--}}
{{--<div class="modal-content modal-container">--}}
{{--<h3 class="home-modal-title" data-key="model-1">Viện Thẩm Mỹ Royal xứng đáng là lựa chọn hoàn hảo nhất giúp--}}
{{--nét đẹp Việt được thăng--}}
{{--hoa.</h3>--}}
{{--<input id="province-popup" type="hidden" class="modal-input" name="province" placeholder="Khu vực"/>--}}
{{--<input type="text" class="modal-input" name="name" placeholder="Họ tên Khách hàng"/>--}}
{{--<input type="text" class="modal-input" name="phone" placeholder="Số điện thoại"/>--}}
{{--<input type="text" class="modal-input" name="content" placeholder="Dịch vụ cần tư vấn"/>--}}
{{--<button id="js-customer-book-button" type="button" class="register-button-submit btn-royal"--}}
{{--data-dismiss="modal">ĐẶT LỊCH GIỮ CHỖ--}}
{{--</button>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
<!-- contact buttons -->
{{--<div class="contact-button">--}}
    {{--<button class="btn button-container messenger-container" onclick="openMessenger();">--}}
        {{--<a id="open-messenger" target="_blank" href="https://www.messenger.com/t/vtmroyal" class="hidden"></a>--}}
        {{--<img class="contact-icon" src="/laningpage/frontend/Icon/messenger-icon.png" alt="royal messenger"/>--}}
        {{--<div>--}}
            {{--<p class="chat-now">Chat ngay</p>--}}
            {{--<p class="contact-button-text messenger-text">Messenger</p>--}}
        {{--</div>--}}
    {{--</button>--}}
    {{--<a href="tel:{{$post->phone}}" class="btn button-container call-now-container">--}}
        {{--<img class="contact-icon call-now" src="/laningpage/frontend/Icon/phone-call.png" alt="royal call"/>--}}
        {{--<p class="contact-button-text call-now-text">Gọi ngay</p>--}}
    {{--</a>--}}
    {{--<button class="btn button-container book-appointment-container">--}}
        {{--<img class="contact-icon book-appointment-icon" src="/laningpage/frontend/Icon/calendar-fill.png"--}}
             {{--alt="royal call"/>--}}
        {{--<a href="#dang-ky" class="contact-button-text book-appointment-text">Đăng ký tư vấn</a>--}}
    {{--</button>--}}
{{--</div>--}}
<!-- modal register -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-layout modal-register">
        <!--Modal content-->
        <div class="modal-content modal-container">
            <h3 class="home-modal-title" data-key="model-2">Nhập số điện thoại để được Viện thẩm mỹ Royal gọi lại
                ngay</h3>
            <input type="text" class="modal-input" name="phone" placeholder="Số điện thoại quý khách"/>
            <select class="form-control select-local" name="province">
                <option>Hà Nội</option>
                <option>Thành Phố Bắc Giang</option>
                <option>Thành Phố Bắc Ninh</option>
                <option>Hải Phòng</option>
                <option>Thành Phố Hồ Chí Minh</option>
                <option>Vĩnh Phúc</option>
                <option>Thành Phố Thái Nguyên</option>
            </select>
            <button id="js-register-popup-button" type="button" class="register-button-submit btn-royal"
                    data-dismiss="modal">Đăng ký tư vấn
            </button>
        </div>
    </div>
</div>

<script>
    function openMessenger() {
        document.getElementById('open-messenger').click();
    }
</script>

<footer>
    <div class="container">
        {{--<div class="row footer-body">--}}
            {{--<div class="col-md-3 col-xs-12 info-fp">--}}
                {{--<img data-key="logo-sda" class="logo" src="/laningpage/frontend/images/logo.png" alt="logo">--}}
                {{--<img data-key="hr-sds" class="img-hr" src="/laningpage/frontend/images/image-hr.png" alt="image-hr">--}}
                {{--<p class="content-follow" data-key="theo-doi-1">Theo dõi chúng tôi trên fanpage</p>--}}
                {{--<div class="fb-container">--}}
                    {{--<div class="fb-page" data-href="https://www.facebook.com/vtmroyal/" data-tabs="" data-width=""--}}
                         {{--data-height="" data-small-header="false" data-adapt-container-width="true"--}}
                         {{--data-hide-cover="false"--}}
                         {{--data-show-facepile="true">--}}
                        {{--<blockquote data-key="tham-my-aa" cite="https://www.facebook.com/vtmroyal/"--}}
                                    {{--class="fb-xfbml-parse-ignore">--}}
                            {{--<a href="https://www.facebook.com/vtmroyal/">Thẩm Mỹ Quốc Tế Royal</a>--}}
                        {{--</blockquote>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-12 system-business">--}}
                {{--<h3 class="business-title" data-key="2">Hệ thống cơ sở</h3>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="3">Cơ sở 1</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-3" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="4">Số 38 - Ngõ 12 Láng Hạ - Đống Đa - Hà Nội</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-5"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="5">Hotline: 0982 966 663</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="6">Cơ sở 2</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-6" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="7">Số 251 Hai Bà Trưng - Cát Dài - Hải Phòng</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-7"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="8">Hotline: 0982 592 663</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="9">Cơ sở 3</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-8" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="10">Số 458 Hoàng Minh Thảo - Lê Chân - Hải Phòng</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-9"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="11">Hotline : 0981 693 266</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-12 system-business">--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name none-after-title" data-key="12">Cơ sở 4</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-10" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="13">CS4: 183 Hoàng Văn Thụ - TP Bắc Giang</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-11"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="14">Hotline: 0971 523 633</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="15">Cơ sở 5</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-12" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="16">Số 286/3 Tô Hiến Thành - Q10 - TP Hồ Chí Minh</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-13"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="17">Hotline: 0982 196 288</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="18">Cơ sở 6</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-14" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="19">Số 22 Hùng Vương - Vĩnh Yên - Vĩnh Phúc</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-15"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="20">Hotline : 0981 693 266</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-12 system-business">--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name none-after-title" data-key="21">Cơ sở 7</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-16" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="22">Số 172 Nguyễn Gia Thiều - TP Bắc Ninh</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-17"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="23">Hotline: 0982 488 663</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="24">Cơ sở 8</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-18" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="25">Số 580 Nguyễn Trãi - TP Bắc Ninh</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-19"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="26">Hotline: 0981 665 299</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="business-item">--}}
                    {{--<h4 class="business-name" data-key="27">Cơ sở 9</h4>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-address" data-key="image-20" src="/laningpage/frontend/images/icon-map.png"--}}
                             {{--alt="Address">--}}
                        {{--<p class="content" data-key="28">Số 67 Minh Cầu - TP Thái Nguyên</p>--}}
                    {{--</div>--}}
                    {{--<div class="business-info">--}}
                        {{--<img class="icon-hotline" data-key="image-21"--}}
                             {{--src="/laningpage/frontend/images/icon-call-gold.png" alt="Phone">--}}
                        {{--<p class="content" data-key="29">Hotline: 0968 922 611</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
    <p class="copyright">Viện Thẩm Mỹ Quốc Tế Royal - Copyright 2020</p>
</footer>
{{--@auth--}}
{{--<script src="/admin-page/js/builder.js"></script>--}}
{{--@endauth--}}
<script src="{{asset('laningpage/frontend/js/jquery-3.4.1.min.js')}}"></script>
<!-- jquery -->
<script src="{{asset('laningpage/frontend/js/bootstrap-3.4.1.min.js')}}"></script>
<!-- iScroll -->
<script src="{{asset('laningpage/frontend/js/iscroll.min.js')}}"></script>
<!-- drawer.js -->
<script src="{{asset('laningpage/frontend/js/drawer.min.js')}}"></script>

<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/js/additional-methods.min.js')}}"></script>
<script async defer
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v7.0&appId=1721885251448704&autoLogAppEvents=1"></script>

<script>
    $(document).ready(function () {
        $('.drawer').drawer();
        $('.drawer-hamburger').click(e => {
            var drawerOpen = $('.drawer-open');
            const imgBtn = $('.drawer-hamburger').children().find('img');
            if (drawerOpen.length) {
                imgBtn.replaceWith('<img src="/laningpage/frontend/Icon/icon-close.svg" alt="royal icon burger">')
            } else {
                imgBtn.replaceWith('<img src="/laningpage/frontend/Icon/icon-burger.png" alt="royal icon burger">')
            }
        });
        $('.drawer-overlay').click(e => {
            const imgBtn = $('.drawer-hamburger').children().find('img')
            imgBtn.replaceWith('<img src="/laningpage/frontend/Icon/icon-burger.png" alt="royal icon burger">')
        })

        jQuery.validator.addMethod("phone", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/);
        }, "Số điện thoại không hợp lệ");

        $('form#my_Form').validate({
            rules: {
                phone: {
                    required: true,
                    phone: 'phone'
                },
                full_name: 'required',
            },
            messages: {
                full_name: "Vui lòng nhập tên quý khách !!!",
                phone: {
                    required: 'Vui lòng nhập số điện thoại !!!',
                    phone: 'Số điện thoại không hợp lệ !!!'
                },
            }
        });
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#my_Form").submit(function (event) {
        event.preventDefault();
        var $form = $(this);
        sendMail($form, $("#js-register-button"))
    });

    $('#js-customer-book-button').on('click', function () {
        sendMail($('#customer-book'), $(this));
    });

    $('#js-register-popup-button').on('click', function () {
        sendMail($('#register'), $(this));
    });

    function sendMail($form, $button) {
        var name = $form.find("input[name='full_name']").val();
        var phone = $form.find("input[name='phone']").val();
        if (!phone) {
            return;
        }
        var slug = $form.find("[name='slug']").val();
        var note = $form.find("[name='note']").val();
        $form.find("input[name='full_name']").attr('disabled', true);
        $form.find("input[name='phone']").attr('disabled', true);
        $form.find("[name='slug']").attr('disabled', true);
        $form.find("[name='note']").attr('disabled', true);
        $button.attr('disabled', true);
        var posting = $.post('/customer-post', {full_name: name, phone: phone, slug: slug, note: note});
        posting.done(function (data) {
            if ($button.prop('tagName').toLowerCase() === 'input') {
                $button.val(data);
            } else {
                $button.text(data);
            }
        });
    }
</script>
</body>
</html>
