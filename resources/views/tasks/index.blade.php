@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/task.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="container bg-white">
        <div class="row">
            <div class="col-md-3 bor-r">
                {{--<div>--}}
                    {{--<div class="dropdown padding5-10 position"><i class="fa fa-briefcase mr5 mt3"></i><span--}}
                                {{--class="bold display uppercase">&nbsp; Dự án</span><a class="dropdown-toggle"--}}
                                                                                     {{--data-toggle="dropdown"><s--}}
                                    {{--class="gf-icon-setting-g gf-icon-h02 reset fr"></s></a>--}}
                        {{--<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"--}}
                            {{--style="width: 100px; position: absolute; left: 150px; top: 20px; padding: 0px;">--}}
                            {{--<li class="bor-bot"><a href="/#/projects/new/0/3">Tạo dự án</a></li>--}}
                            {{--<li><a href="/#/projects/menu_setting">Sắp xếp dự án</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<div>--}}
                            {{--<div class="folder_name bor-bot-w bor-bot-matt padding5-10 color_3 white bold position"><s--}}
                                        {{--class="gf-neo-w mr5"></s>Chưa phân loại--}}
                            {{--</div>--}}
                            {{--<div>--}}
                                {{--<div class="padding5-10 position b-hover white-space pr20"><a class="project_link"><s--}}
                                                {{--class="gf-neo-b mr5"></s>Công việc</a><span--}}
                                            {{--class="project_notify noti-position noti-number noti-number-on"></span>--}}
                                {{--</div>--}}
                                {{--<div class="padding5-10 position b-hover white-space pr20"><a class="project_link"><s--}}
                                                {{--class="gf-neo-b mr5"></s>TELESALE - CSKH sau mua</a><span--}}
                                            {{--class="project_notify noti-position noti-number noti-number-on hide"></span>--}}
                                {{--</div>--}}
                                {{--<div class="padding5-10 position b-hover white-space pr20"><a class="project_link"><s--}}
                                                {{--class="gf-neo-b mr5"></s>TELESALE - Nhắc lịch HẸN GỌI LẠI</a><span--}}
                                            {{--class="project_notify noti-position noti-number noti-number-on hide"></span>--}}
                                {{--</div>--}}
                                {{--<div class="padding5-10 position b-hover white-space pr20"><a class="project_link"><s--}}
                                                {{--class="gf-neo-b mr5"></s>LỄ TÂN - Xác nhận KH đến</a><span--}}
                                            {{--class="project_notify noti-position noti-number noti-number-on">3</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="pl10 pr10">--}}
                        {{--<div class="position padding5-10 mt5 mb10 border-ds row ml0 gf-icon-hover"--}}
                             {{--style="margin-right: 0px;"><a href="/#/projects/new/0/3" class="pointer"><i--}}
                                        {{--class="fa fa-plus mr5 mt3"></i>Tạo dự án</a></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-9">
                <img class="taskimg mb10">
                <div class="notice-came pt20 pb10">
                    <div class="info-notice-came pl20 position pr20"><h4 class="font20 mb10 blue bold">Quản lý công
                            việc hàng ngày của bạn</h4>
                        <p class="font14">Bắt đầu giao việc và hoàn thành công việc của bản thân và các đồng
                            nghiệp.</p>
                        <div class="row mt10 pl20"><a class="display bor-ds2 padding mr10 blue" data-toggle="modal" data-target="#task"><i
                                        class="fa fa-plus mr5"></i>Thêm công việc</a></div>
                    </div>
                </div>
                <div>
                    <div class="title padding5-10 col-md-12 mt10">
                        <div class="col-md-8 fl mt2 no-padd"><a
                                    class="display filter_all mr20 text-filter"><span>Tất cả</span></a><a
                                    class="display filter_all mr20 text-filter" style="color: rgb(246, 142, 66);">Ưu
                                tiên</a><a class="display filter_all mr20 text-filter"
                                           style="color: rgb(23, 95, 150);">Công việc của tôi</a><a
                                    class="display filter_all mr20 text-filter"
                                    style="color: rgb(58, 135, 173);">Mới</a><a
                                    class="display filter_all mr20 text-filter"
                                    style="color: rgb(60, 60, 60);">Chậm</a><a
                                    class="display filter_all mr20 text-filter" style="color: rgb(60, 60, 60);">Hoàn
                                thành chậm</a></div>
                        <div class="col-md-4 fr no-padd">
                            <div class="fr mt2 hide" id="btn_action">
                                <div class="btn-group mr10"><p class="dropdown-toggle fl mr10"
                                                               data-toggle="dropdown" style="box-shadow: none;">Thao
                                        tác(<span class="show-selected-num">0</span>)<span class="caret"></span></p>
                                    <ul class="dropdown-menu tl" style="width: 150px;">
                                        <li id="finish_task"><a class="padding5">Hoàn thành công việc</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="row padding col-md-12">--}}
                        {{--<div class="col-md-6 elfinder-button-search"><input type="text"--}}
                                                                            {{--placeholder="Nhập điều kiện tìm kiếm ..."--}}
                                                                            {{--class="form-control"></div>--}}
                        {{--<div class="col-md-3 pl10 position">--}}
                            {{--<div class="w100i ant-select ant-select-enabled">--}}
                                {{--<div class="ant-select-selection--}}
            {{--ant-select-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true"--}}
                                     {{--aria-controls="408b3a16-d56c-4416-a75f-be0fa1a8d355" aria-expanded="false"--}}
                                     {{--tabindex="0">--}}
                                    {{--<div class="ant-select-selection__rendered">--}}
                                        {{--<div unselectable="on" class="ant-select-selection__placeholder"--}}
                                             {{--style="display: block; user-select: none;">Mời chọn--}}
                                        {{--</div>--}}
                                        {{--<div class="ant-select-search ant-select-search--inline"--}}
                                             {{--style="display: none;">--}}
                                            {{--<div class="ant-select-search__field__wrap"><input autocomplete="off"--}}
                                                                                               {{--class="ant-select-search__field"--}}
                                                                                               {{--value=""><span--}}
                                                        {{--class="ant-select-search__field__mirror">&nbsp;</span></div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<span class="ant-select-arrow" unselectable="on" style="user-select: none;"><i--}}
                                                {{--aria-label="icon: down"--}}
                                                {{--class="anticon anticon-down ant-select-arrow-icon"><svg--}}
                                                    {{--viewBox="64 64 896 896" class="" data-icon="down" width="1em"--}}
                                                    {{--height="1em" fill="currentColor" aria-hidden="true"><path--}}
                                                        {{--d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path></svg></i></span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-3 pl10 position"><select class="form-control pl20">--}}
                                {{--<option value="qf1">Công việc giao cho tôi</option>--}}
                                {{--<option value="qf2">Công việc tôi giao</option>--}}
                                {{--<option value="qf3">Công việc tôi liên quan</option>--}}
                            {{--</select></div>--}}
                    {{--</div>--}}
                    @include('tasks.ajax')
                </div>
            </div>
        </div>
    </div>
    @include('tasks._form')
@endsection
@section('_script')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
    <script src="{{asset('assets/js/bootstrap-clockpicker.min.js')}}"></script>
    <script>
        $('document').ready(function () {
            $('.clockpicker').clockpicker();
        });
        $('[data-toggle="datepicker"]').datepicker({
            format: 'dd-mm-yyyy',
            autoHide: true,
            zIndex: 2048,
        });
    </script>
@endsection
