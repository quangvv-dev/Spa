<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="google-site-verification" content="pW_9z8rjLjVBk5bXJK9HFG0SXZFXXn_fElFSY5v1_dw" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta property="og:image" content="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}"/>
    <link rel="icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{!empty(setting('logo_website')) ? setting('logo_website'):'/assets/images/brand/logo.png'}}" />

    <style>
        @font-face {
            font-family: sopher;
            src: url("{{asset('layout/fonts/Philosopher-Regular.ttf')}}");
        }

        .notification {
            display: flex;
            max-width: 20%;
            background: radial-gradient(120.26% 166.07% at -4.23% -32.74%, #1A2749 0%, #253763 36.39%, #121B34 75.39%, #0C1124 100%) padding-box, linear-gradient(130.35deg, #FAF9F7 -2.76%, #2AABE2 53.97%) border-box;
            color: red;
            padding: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            position: fixed;
            right: 24px;
            top: 10%;
            align-items: flex-start;
            gap: 12px;
        }
        body {
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .content {
            background-color: #131313;
            height: 100vh;
            /*width: 1440px;*/
            width: 100%;
        }

        .bg {
            background: url({{asset('layout/images/Group_login.png')}});
            width: 773px;
            height: 515px;
            background-repeat: no-repeat;
            position: absolute;
            bottom: 0;
            z-index: 0;
        }

        .login {
            width: 645px;
            height: 572px;
            /* background: red; */
            z-index: 1;
            border-radius: 44px;
            background: linear-gradient(black, black) padding-box, linear-gradient(128.23deg, #FAF9F7 9.05%, #579DE2 51.94%, #2185A5 94.82%) border-box;
            border: 1px solid transparent;
        }
        input {
            height: 48px;
            border-radius: 8px;
            background: #2E2E2E;
            color: #fff;
            width: calc(100% - 16px);
            border: none;
            outline: none;
            font-size: 18px;
            padding-left: 16px;
        }
        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: 8px;
            border: none;
            font-size: 18px;
            color: #fff;
            background: linear-gradient(130.35deg, #FAF9F7 -2.76%, #2AABE2 53.97%);
            cursor: pointer;
        }
        .has-error input {
            border: 1px solid #FF7577;
        }
        .has-error .error {
            color: #FF7577;
            margin: 6px 0 0 16px;
            display: inline-block;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="bg"></div>
    <div style="height: 100vh;display: flex;justify-content: center;align-items: center;">
        <div class="login">
            <form class="card" method="POST" action="{{ url('login') }}">
                @csrf
                <div class="" style="padding: 60px 88px;text-align: center;">
                    <div class="logo">
                        <img src="{{asset('layout/images/Logo_login.png')}}" alt="">
                    </div>
                    <div style="margin-top: 30px;font-family: sopher;font-size: 32px;color: #fff;">
                        Đăng nhập
                    </div>
                    <div class="{{ $errors->has('phone') ? ' has-error' : '' }}" style="margin-top: 30px; text-align: left;">
                        <span style="font-size: 16px;color: #999999;">Số điện thoại</span>
                        <div class="" style="margin-top: 8px;">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">
                            <span class="error">Số điện thoại không tồn tại</span>
                        </div>
                    </div>
                    <div class="{{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 24px; text-align: left;">
                        <span style="font-size: 16px;color: #999999;">Mật khẩu</span>
                        <div class="" style="text-align: left; position: relative;margin-top: 8px;">
                            <input type="password"  name="password" id="exampleInputPassword1" placeholder="Mật khẩu">
                            <img src="{{asset('layout/images/eye_password.png')}}" alt="" style="position: absolute;right: 12px;top: 13px;">
                            <span class="error">Password không đúng</span>
                        </div>
                    </div>
                    <div class="" style="margin-top: 36px;">
                        <button class="btn-login" type="submit">Đăng nhập</button>
                    </div>
                </div>
            </form>
        </div>
        @if(session('error'))
            <div class="notification">
                <div class="">
                    <div class="fs-16 mt-1"> {{ session('error')?? '' }}</div>
                </div>
                <img src="{{asset('layout/images/Close.png')}}" alt="" class=pointer" id="close">
            </div>
        @endif
    </div>

</div>
</body>
<script type="text/javascript">
    // Lấy phần tử có id "close"
    var closeButton = document.getElementById("close");

    // Thêm sự kiện "click" cho nút có id "close"
    if (closeButton) {
        closeButton.addEventListener("click", function() {
            // Khi nút "close" được click, ẩn phần tử có class "notification"
            var notification = document.querySelector(".notification");
            if (notification) {
                notification.style.display = "none";
            }
        });
    }
</script>
</html>
