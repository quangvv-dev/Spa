@extends('backend.layouts.master')
@section('content')
    <style>
        .fa.fa-facebook{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            line-height: 30px;
            background: #fff;
        }
        .text {
            color: #000;
            text-shadow: none!important;
            font-size: 16px;
            font-weight: bold;
            height: 100%;
            line-height: 30px;
            display: inline-block;
        }
        .btn.btn-facebook{
            background-color: #1877F2 !important;
        }
    </style>
    <div class="row">
        <div class="col-xs-12 offset-md-4 col-md-4">
            <div class="m-header-wrap">
                <div class="m-header">
                    <div class="col-12 form-group text-center">
                        <span class="text form-group">Đồng bộ Facebook</span>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="row hidden">
                        <div class="col-12">
                            <div class="pu-caption">
                                Đồng bộ Facebook
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-block btn-facebook" href="/login/facebook">
                                <i class="fa fa-facebook fa-2x"></i><b style="font-size:18px;vertical-align: bottom;color: #fff"> Continue with Facebook</b>
                            </a>
                        </div>
                        <div class="col-xs-12">
                            <p id="lbl" style="display: none">BẠN ĐÃ ĐĂNG NHẬP THÀNH CÔNG!</p>
                            <br>
                            <input type="button" value="THOÁT" id="btbLogout" class="hidden" onclick="FBLogout()">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    @include('backend.layouts.script')
@endsection
