<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Công Ty Cổ Phần Tập Đoàn Adam Group</title>
    <link rel="apple-touch-icon" href="{{asset('backend/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon"
          href="{{asset('default/logo.png')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
</head>
<style>
    .container{
        background:  linear-gradient(270deg, #CA6B5E 1%, #FCC8A5 37%, #FCC2A1 48%, #FCB498 60%, #F8AE93 69%, #ED9E86 79%, #DA8271 92%, #CA6B5E 100%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .block-container{
        background-image:url("{{asset('default/background-wallet.png')}}");
        height: 75%;
        /*background-size: 70vh 500px;*/
        background-repeat: no-repeat;
        background-size: contain;
        /*margin: 0px 6px;*/
        width: 96%;
    }
    @media screen and ( max-height: 800px )
    {
        .block-container{
            height: 88%;
        }
    }
    @media screen and ( min-height: 801px ) and ( max-height: 866px )
    {
        .block-container{
            height: 88%;
        }
    }
    .logo{
        text-align: center;
        padding-top: 30px;
    }
    .notification-title{
        text-align: center;
    }
    .bold{
        font-weight: bold;
        font-size: 24px;
    }
    .logo2{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .wallet{
        background: #F2F3F4;
    }
    body{
        font-style: normal;
    }
    .price{
        padding-top: 35px;
        padding-bottom: 10px;
    }
    .time{
        padding-bottom: 25px;
    }
    p span{
        font-size: 28px;
    }
</style>
<body>
<div class="container">
<div class="block-container">
    <div class="logo">
        <img width="100" height="100" src="{{asset('default/done-wallet.png')}}" alt="">
    </div>
    <h4 class="notification-title">{{$title}}</h4>
    <div class="small-title text-center">
        <p>Số tiền nạp</p>
        <p class="bold">{{number_format($order->gross_revenue)}}</p>
    </div>
    <div class="price">
        <span style="color: #868E96">Số tiền nhận được</span>
        <span class="bold">{{number_format($order->price)}}</span>
    </div>
    <div class="time">
        <span style="color: #868E96">Thời gian: </span>
        <span style="color: #868E96">
            {{@\Carbon\Carbon::parse($payment->created_at)->format('d-m-Y H:s')}}
        </span>
    </div>
    <div class="wallet">
        <div class="row">
            <div class="col-3 logo2">
                <img width="55" height="55" src="{{asset('default/done-wallet.png')}}" alt="">
            </div>
            <div class="col-9" style="text-align: left">
                <div class="col"><h3>Ví Royal</h3></div>
                <div class="col"><p>Số dư: {{number_format($currentWallet)}}</p></div>

            </div>
        </div>
    </div>

</div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
