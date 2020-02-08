@extends('layout.app')
@section('_style')
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{asset('/assets/plugins/wysiwyag/richtext.min.css')}}" rel="stylesheet"/>
    <link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('zoom-image/css/style.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('zoom-image/css/mobilelightbox.css') }}" media="all">
    <style>
        #snoAlertBox1 {
            position: absolute;
            z-index: 1400;
            top: 2%;
            right: 4%;
            margin: 0px auto;
            text-align: center;
            display: none;
        }

        #snoAlertBox2 {
            position: absolute;
            z-index: 1400;
            top: 2%;
            right: 4%;
            margin: 0px auto;
            text-align: center;
            display: none;
        }

        th.text-white.text-center {
            font-size: 12px;
        }

        td.text-center {
            font-size: 13px;
        }

        .margin-left-10 {
            margin-left: 10px;
        }

        .container {
            max-width: 90%;
        }

        a#edit-history-order {
            color: #007bff !important;
            font-weight: 600 !important;
        }

        /*.btn{*/
        /*    background: #7235bb;*/
        /*}*/
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="font-size: 0.8rem">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6 no-padd font16"><a class="avatar a45 fl mr10 pic"> <img
                                src="https://linhanhspa.getflycrm.com/assets/images/noavatar.png"> </a> <span
                            class="bold uppercase ">  &nbsp;{{ $customer->full_name }}  </span>
                    <div class="display" id="toolbox" style="width: 28px; height: 20px">
                        <a title="Sửa tài khoản" class="btn" href="{{ route('customers.edit', $customer->id) }}"><i
                                    class="fas fa-edit"></i></a>
                        <a id="btn_del_account" rel="tooltip"
                           data-placement="bottom"
                           data-original-title="Xóa" class="ml5">
                            <i
                                    class="gf-icon-hover icon-remove mr5"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 no-padd bor-l pl20 mg0 pt10 position hoverlastactive" rel="tooltip"
                     data-original-title="Click thay đổi người phụ trách" data-placement="bottom">
                    <div class="show_change_am" style="cursor:pointer">
                        <div class="avatar a35"><img class="account_manager_avatar"
                                                     src="https://linhanhspa.getflycrm.com/assets/images/noavatar.png">
                        </div>
                        <div class="info-avatar"><p class="account_manager_name"><a
                                        class="gfname">{{ @$customer->telesale->full_name }}</a>
                            </p>
                            <p class="gray1 font12">Người phụ trách</p></div>
                    </div>
                </div>
                <div class="col-md-1 no-padd bor-l mg0 position hoverlastactive" rel="tooltip"
                     data-original-title="Click thay đổi liên hệ lần cuối" data-placement="bottom">
                    {{--<div class="last_active tc" style="cursor:pointer"><h1 id="days_from_last_active"--}}
                    {{--style="font-size:30px" class="bold mg0">--}}
                    {{--1</h1>--}}
                    {{--<p>Liên hệ lần cuối</p></div>--}}
                    {{--<div class="add-drop add-d-left other_last_active"--}}
                    {{--style="right: 125px; top: 60px; width: 286px; padding: 10px; z-index: 12; border: 1px solid rgb(208, 208, 208); display: none;">--}}
                    {{--<s class="gf-icon-neotop"></s>--}}
                    {{--<div class="col-md-12 no-padd"><p>Liên hệ lần cuối</p>--}}
                    {{--<div class=""><input type="text" placeholder="Thời gian" class="datepick form-control"--}}
                    {{--id="date_last_active" value="22/08/2019 18:24:01"></div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-12 no-padd mt10"><p>Nội dung <span class="red">(*)</span></p> <textarea--}}
                    {{--class="content_last_active form-control" cols="4"--}}
                    {{--style="height:80px"></textarea></div>--}}
                    {{--<div class="col-md-12 no-padd mt10">--}}
                    {{--<button class="btn btn-info submit_last_active">Cập nhật</button>--}}
                    {{--<button class="btn btn-default submit_and_create_comment">Cập nhật và tạo trao đổi--}}
                    {{--</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class="col-md-1 no-padd tc bor-l mg0"><h1 style="font-size:30px" class="bold mg0">0</h1>
                    <p>Tương tác</p></div>
                <div class="col-md-2 no-padd tc bor-l mg0"><h1 style="font-size:30px"
                                                               class="bold mg0">{{number_format($customer->orders->sum('gross_revenue'))}}
                        VNĐ</h1>
                    <p>Giá trị</p></div>
            </div>
            <div style="height:5px" class="color-picker-bg-41"></div>
            <div class="col-md-12 no-padd">
                <div class="col-md-2 no-padd" style="float: left; display: block">
                    <div class="full2 pb20 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2"><h3 class="uppercase pb5 mb10 font12 bold mg0">Mối
                                quan hệ</h3>
                            <div class="">{{ @$customer->status->name }}
                            </div>
                        </div>
                    </div>
                    <div class="full2 pb20 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2">
                            <h3 class="uppercase pb5 mb10 font12 bold mg0">Nguồn: <i
                                        class="fa fa-random mr5 gray margin-left-10">&nbsp;{{ @$customer->source_customer->name }}</i>
                            </h3>
                            <h3 class="uppercase pb5 mb10 font12 bold mg0"> Người tạo:<i
                                        class="fa fa-user mr5 gray margin-left-10">&nbsp;{{ @$customer->marketing->full_name }}</i>
                            </h3>
                            <h3 class="uppercase pb5 mb10 font12 bold mg0"> Ngày tạo:<i
                                        class="fa fa-calendar mr5 gray margin-left-10">&nbsp;{{ $customer->created_at }}</i>
                            </h3>
                            <h3 class="uppercase pb5 mb10 font12 bold mg0"> Đã mua:<i
                                        class="fa fa-shopping-cart mr5 gray margin-left-10">&nbsp;{{ $customer->orders->count() }}</i>
                            </h3>
                        </div>
                    </div>
                    <div class="border padding infor-list-ct ml2 mt10"><h3
                                class="uppercase pb5 mb10 font12 bold mg0">Liên hệ</h3>
                        <div class="box-cont">
                            <div class="list-row-ifct mb10 pb10 clearfix contact_item" data-contact-id="4658">
                                <div class="col-md-12 no-padd mt2 gray fl mb10"><p class="clearfix white-space"><i
                                                class="icon-user mr5 mt2 fl"></i> <b
                                                class="blue">&nbsp;{{ $customer->full_name }}</b> <i
                                                data-original-title="Liên hệ chính" rel="tooltip"
                                                class="fa orange fa-star" aria-hidden="true"></i></p>
                                    <p></p>
                                    <p class="clearfix">&nbsp;{{ $customer->phone }}</p>
                                </div>
                                <div class="col-md-12 no-padd hide"><a><i data-task-type="2"
                                                                          class="tc new_popup_task icon-phone style-icon-phone mr10 fl"></i></a>
                                    <a><i data-task-type="3"
                                          class="tc new_popup_task icon-group style-icon-group mr10 fl"></i></a> <a><i
                                                data-task-type="4"
                                                class="tc new_popup_task icon-envelope-alt style-icon-envelope mr10 fl"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border padding mt10 ml2">
                        <div class="infor-top-ct"><h3 class="uppercase mb10 font12 bold mg0"
                                                      style="margin-bottom: 10px!important;">Thông tin khách
                                hàng</h3>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mã KH:</p>
                                <p class="bold word-wrap"> &nbsp;{{$customer->account_code}}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tên KH:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->full_name }} </p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Địa chỉ:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->address }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Điện thoại:</p>
                                <p class="bold word-wrap"><a class="" data-account-id="4629" data-phone="0904341335"
                                                             data-type="crm" data-issensitive="true">
                                        &nbsp;{{ $customer->phone }} </a></p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Người phụ trách:</p>
                                <p class="bold word-wrap"> &nbsp;{{ @$customer->telesale->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Nhóm KH:</p>
                                <p class="bold word-wrap"> &nbsp;{{ @$customer->category->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Nguồn KH:</p>
                                <p class="bold word-wrap"> &nbsp;{{ @$customer->source_customer->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Sinh nhật:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->birthday }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mối quan hệ:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->status->name }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Ngày tạo:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->created_at }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Giới tính:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->genderText }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Mô tả:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->description }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Số đơn hàng:</p>
                                <p class="bold word-wrap"> &nbsp;{{ $customer->orders->count() }}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tổng doanh thu:</p>
                                <p class="bold word-wrap">
                                    &nbsp;{{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Tổng số tương tác:</p>
                                <p class="bold word-wrap">&nbsp;0</p>
                            </div>
                            <div class="mb10 clearfix"><p class="pr5 fl">Giá trị:</p>
                                <p class="bold word-wrap">
                                    &nbsp;{{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 no-padd" style="float: left;">
                    <div class="col-md-12 no-padd spanfull2 padding" style="float: left;">
                        <div class="">
                            <div class="panel panel-primary">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1 ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="#tab5" class="active" data-toggle="tab">Trao đổi</a>
                                            </li>
                                            <li><a href="#tab7" data-toggle="tab">Lịch hẹn</a></li>
                                            <li><a href="#tab6" data-toggle="tab">Đơn hàng</a></li>
                                            <li><a href="#tab8" data-toggle="tab">Công việc</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content" style="font-size: 15px;">
                                        <div class="tab-pane active " id="tab5">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">{{$title}}</h3></br>
                                                        <div class="col" style="float: right">
                                                            {{--<a class="right btn btn-primary btn-flat"--}}
                                                            {{--href="{{ url('schedules/'.request()->segment(count(request()->segments())) ) }}"><i--}}
                                                            {{--class="fa fa-arrow-right"></i>Tới đặt lịch</a>--}}
                                                        </div>
                                                    </div>
                                                    {!! Form::open(array('url' => url('group_comments/'.request()->segment(count(request()->segments())) ), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                                                    <div class="col-md-12">
                                                        {!! Form::textArea('messages', null, array('class' => 'form-control', 'rows' => 3)) !!}
                                                    </div>
                                                    <br>
                                                    <div class="col-xs-12 col-md-12">
                                                        <div class="form-group required">
                                                            <div class="fileupload fileupload-new"
                                                                 data-provides="fileupload">
                                                                <div class="fileupload-preview fileupload-exists thumbnail"
                                                                     style="max-width: 150px">

                                                                </div>
                                                                <div>
                                                                    <button type="button"
                                                                            class="btn btn-default btn-file">
                                                                        <span class="fileupload-new"><i
                                                                                    class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                                                        <span class="fileupload-exists"><i
                                                                                    class="fa fa-undo"></i> Thay đổi</span>
                                                                        <input type="file" name="image_contact"
                                                                               accept="image/*"
                                                                               class="btn-default upload"/>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button style="float: right" type="submit"
                                                                class="btn btn-success">Gửi
                                                        </button>
                                                    </div>
                                                    {{ Form::close() }}

                                                    <div id="registration-form">
                                                        @include('group_comment.ajax')
                                                    </div>
                                                    <!-- table-responsive -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="tab6">
                                            <div class="card-header">
                                                <h3 class="card-title">Danh sách đơn hàng bán</h3></br>
                                                <div class="col relative">
                                                    <a class="right btn btn-primary btn-flat"
                                                       href="{{ route('orders.create', $customer->id) }}"><i
                                                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
                                            </div>
                                            @include('customers.order')
                                        </div>
                                        <div class="tab-pane" id="tab7">
                                            @include('schedules.index')
                                        </div>
                                        <div class="tab-pane " id="tab8">
                                            <a style="color: #ffffff;margin-bottom: 8px;"
                                               class="right btn btn-primary btn-flat" data-toggle="modal"
                                               data-target="#task"><i class="fa fa-plus-circle"></i>Thêm mới CV</a>
                                            @include('tasks.ajax')
                                            @include('tasks._form_customer')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('zoom-image/js/mobilelightbox.js') }}"></script>
    <script src="{{ asset('zoom-image/js/main.js') }}"></script>
    <script src="{{asset('/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script src="{{asset('assets/js/util.js')}}"></script> <!-- util functions included in the CodyHouse framework -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

        $(document).on('click', '#edit-history-order', function (e) {
            e.preventDefault();
            $('.data-history-update-order').empty();
            const id = $(this).data('order-id');
            $.ajax({
                url: "{{ Url('ajax/orders/') }}" + '/' + id,
                method: "get",
            }).done(function (data) {
                let html = '';
                data.history_update_orders.forEach(function (item, index) {
                    html += '<tr>' + '<td class="text-center">' + index + '</td>' +
                        '<td class="text-center">' + item.created_at + '</td>' +
                        '<td class="text-center">' + item.user.full_name + '</td>' +
                        '<td class="text-center">' + (item.description ? item.description : '') + '</td>' +
                        '<td class="text-center"><a class="sum_history_order" href="javascript:void(0)" data-id="' + item.id + '"data-order="' + item.order_id + '"> <i class="fas fa-trash-alt"></i></a></td>' + '</tr>';
                });
                $('.data-history-update-order').append(html);
                $('#largeModal').modal("show");
            });
            $('body').delegate('.sum_history_order', 'click', function () {
                const order_id = $(this).data('order');
                const id = $(this).data('id');
                // swal({
                //     title: 'Bạn có muốn xóa ?',
                //     text: "Lịch sử liệu trình sẽ bị xóa và cộng lại số buổi !",
                //     showCancelButton: true,
                //     cancelButtonClass: 'btn-secondary waves-effect',
                //     confirmButtonClass: 'btn-danger waves-effect waves-light',
                //     confirmButtonText: 'OK'
                // }, function (order_id,id) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ Url('ajax/orders_sum/') }}" + "/" + order_id,
                        data: {
                            history_id: id
                        },
                        success: function (res) {
                            if (res == 'Success'){
                                alert("Cộng buổi liệu trình thành công");
                                // window.location.reload()
                            }
                        else if (res == "Failed")
                                alert("Số liệu trình đã hết");
                            window.location.reload();
                        }
                    })
                // })
            });

        });

        $('.edit-order').click(function () {
            const id = $(this).data('order-id');
            $('.save-update-history-order').click(function () {
                swal({
                    title: 'Bạn có muốn trừ liệu trình ?',
                    showCancelButton: true,
                    cancelButtonClass: 'btn-secondary waves-effect',
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'OK'
                }, function () {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ Url('ajax/orders/') }}" + "/" + id,
                        data: $('#historyUpdateOrrder').serialize(),
                        success: function (res) {
                            if (res == 'Success')
                                alert("Trừ số liệu trình thành công");
                            else if (res == "Failed")
                                alert("Số liệu trình đã hết");
                            window.location.reload();
                        }
                    })
                })
            });
        });

        $(function (e) {
            $('.messages').richText();
        });

        $(document).on('click', '.btn-edit-comment', function (e) {
            const target = $(e.target).parent().parent().parent().parent();
            const group_comment_id = $(this).data('id');

            $.ajax({
                url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/edit",
                method: "get",
            }).done(function (data) {

                let html = `
            {!! Form::open(array('method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                    <div class="col-md-12">
                        <textarea name="messages" class="form-control message" rows="3" data-id="` + data.id + `">` + data.messages + `</textarea>
                    </div>
                    <div class="col-xs-12 col-md-12 file-upload">
                        <div class="form-group required">
                            <div class="fileupload fileupload-new"
                                 data-provides="fileupload">
                                 <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px">

                                </div>
                                <button type="button" class="btn btn-default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                                    <input type="file" name="image_contact" accept="image/*" class="btn-default upload" data-id="11"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button style="float: right; margin-top: 10px;" type="submit"
                                class="btn btn-success update-messages">Gửi
                        </button>
                    </div>
                    {{ Form::close() }}`;
                $(target).find('.comment').empty();
                $(target).find(".comment").append(html);
            });
        });

        $(document).on('click', '.update-messages', function (e) {
            e.preventDefault();
            const target = $(e.target).parent().parent().parent().parent();
            let formData = new FormData();
            const messages = $(target).find('.message').val();
            const image_contact = $(target).parent().parent().find('.upload')[0].files[0];
            formData.append('image_contact', image_contact);
            formData.append('messages', messages);

            const id = $(target).find('.message').data('id');

            $.ajax({
                url: "{{ Url('group-comments/') }}" + "/" + id + "/edit",
                method: "post",
                processData: false,
                contentType: false,
                data: formData
            }).done(function (data) {
                window.location.reload();
            });
        });

        $(document).on('click', '.btn-delete-comment', function (e) {
            const target = $(e.target).parent().parent().parent().parent();
            const group_comment_id = $(this).data('id');

            const result = confirm("Bạn muốn xoá tin nhắn này?");
            if (result) {
                $.ajax({
                    url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/delete",
                    method: "delete",
                }).done(function () {
                    $(target).parent().find(".row").remove();
                });
            }
        })

    </script>
    <script>
        $(document).ready(function () {
            $(document).on('dblclick', '.status', function (e) {
                let target = $(e.target).parent();
                $(target).find('.status').empty();
                let id = $(this).data('id');
                let html = '';

                $.ajax({
                    url: "{{ Url('ajax/status-schedules/') }}",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="status-result form-control" data-id="' + data.schedule_id + '" name="status">' +
                        '<option value="">' + "Chọn trạng thái" + '</option>';
                    data.data.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".status").append(html);
                });
            });

            $(document).on('change', '.status-result', function (e) {
                let target = $(e.target).parent();
                let status = $(target).find('.status-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ Url('ajax/schedules/') }}" + '/' + id,
                    method: "put",
                    data: {
                        status: status
                    }
                }).done(function () {
                    window.location.reload();
                });
            });

            $('.update').on('click', function () {
                var id = $(this).attr("data-id");
                var link = 'schedules/edit/' + id;
                $.ajax({
                    url: window.location.origin + '/' + link,
                    // url: "http://localhost/Spa/public/" + link,
                    method: "get",
                }).done(function (data) {
                    $('#update_id').val(data['id']);
                    $('#update_date').val(data['date']);
                    $('#update_time1').val(data['time_from']);
                    $('#update_time2').val(data['time_to']);
                    $('#update_status').val(data['status']);
                    $('#update_note').val(data['note']);
                    $('#update_action').val(data['person_action']).change();
                    ;
                });
            });
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
            });
            $("#fvalidate").validate({
                rules: {
                    note: {
                        required: true
                    },
                    // date: {
                    //     required: true
                    // },
                    time_from: {
                        required: true
                    },
                    time_to: {
                        required: true
                    },
                },
                messages: {
                    note: "Không được để trống !!!",
                    // date: "Không được để trống !!!",
                    time_from: "Không được để trống !!!",
                    time_to: "Không được để trống !!!",
                },
            });
        })
    </script>
@endsection
