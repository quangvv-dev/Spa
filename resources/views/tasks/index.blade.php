@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/task.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="container bg-white" style="margin-top: 30px">
        <div class="row">
            <div class="col-md-3 bor-r">
                <div>
                    <div class="dropdown padding5-10 position"><i class="fa fa-briefcase mr5 mt3"></i><span
                                class="bold display uppercase">&nbsp; Dự án</span><a class="dropdown-toggle"
                                                                                     data-toggle="dropdown"><s
                                    class="gf-icon-setting-g gf-icon-h02 reset fr"></s></a>
                        {{--<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"--}}
                            {{--style="width: 100px; position: absolute; left: 150px; top: 20px; padding: 0px;">--}}
                            {{--<li class="bor-bot"><a href="/#/projects/new/0/3">Tạo dự án</a></li>--}}
                            {{--<li><a href="/#/projects/menu_setting">Sắp xếp dự án</a></li>--}}
                        {{--</ul>--}}
                    </div>
                    <div>
                        <div>
                            <div class="folder_name bor-bot-w bor-bot-matt padding5-10 color_3 white bold position"><s
                                        class="gf-neo-w mr5"></s>Chưa phân loại
                            </div>
                            <div>
                                <div class="padding5-10 position b-hover white-space pr20"><a class="project_link"><s
                                                class="gf-neo-b mr5"></s>Công việc</a><span
                                            class="project_notify noti-position noti-number noti-number-on"></span>
                                </div>
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
                            </div>
                        </div>
                    </div>
                    {{--<div class="pl10 pr10">--}}
                        {{--<div class="position padding5-10 mt5 mb10 border-ds row ml0 gf-icon-hover"--}}
                             {{--style="margin-right: 0px;"><a href="/#/projects/new/0/3" class="pointer"><i--}}
                                        {{--class="fa fa-plus mr5 mt3"></i>Tạo dự án</a></div>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="col-md-9">
                <img class="taskimg mb10">
                <div class="notice-came pb10">
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
                        <div class="col-md-12 fl mt2 no-padd"><a
                                    class="display filter_all mr20 text-filter" data-task-id=""><span>Tất cả({{count($tasks)}})</span></a>
                            @foreach ($taskStatus as $item)
                                    <a class="display filter_all mr20 text-filter" data-task-id="{{$item->id}}"> {{ $item->name}} ({{$item->tasks->count()}})</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row padding col-md-12">
                        <div class="col-md-5 elfinder-button-search"><input type="text"
                                                                            placeholder="Tìm kiếm tên công việc"
                                                                            class="form-control search-task"></div>
                        {{--<div class="col-md-3 pl10 position">--}}
                            {{--<div class="w100i ant-select ant-select-enabled">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-4 pl10 position"><select class="form-control pl20 choose-type">
                                <option value="qf1">Công việc giao cho tôi</option>
                                <option value="qf2">Công việc tôi giao</option>
                                <option value="qf3">Công việc tôi liên quan</option>
                            </select></div>
                    </div>
                    <div id="registration-form">
                        @include('tasks.ajax')
                    </div>
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

        $(document).on('click', '.filter_all', function () {
            const task_id = $(this).data('task-id');
            search({
                task_id: task_id
            })
        });

        $(document).on('keyup change', '.search-task, .choose-type', function () {
            const name = $('.search-task').val();
            const type = $('.choose-type').val();
            console.log(type);
            search({
                name: name,
                type: type,
            })
        })

        function search(data) {
            $.ajax({
                url: "{{ Url('tasks/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }
    </script>
@endsection
