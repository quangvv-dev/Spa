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
    <link href="{{ asset('css/progres-bar.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('/assets/plugins/simple-lightbox/simple-lightbox.min.css')}}"/>

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

        * {
            font-size: 14px;
        }

        .avatar {
            border-radius: 50%;
        }

        .tabs-menu1 ul li :hover {
            color: #3b8fec;
            border-bottom: 3px solid #3b8fec;
        }

        .card i {
            color: #3b8fec;
        }
        ul#textcomplete-dropdown-1{
            z-index: 9999 !important;
        }
        .content-custom{
            max-width: 98%;
        }
        /*.page-header{*/
            /*margin: 0.5rem 0 1.5rem;*/
        /*}*/
    </style>
    @php
        $roleGlobal = auth()->user()?:[];
    @endphp
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="font-size: 0.8rem">
        <div class="card">
            <div class="card-header">
                <div class="col-md-3 no-padd font16"><a class="fl mr10 pic"> <img class="avatar"
                                                                                  src="{{$customer->avatar?:'/default/noavatar.png'}}">
                    </a> <span
                        class="bold uppercase ">  &nbsp;{{ $customer->full_name }}  </span>
                    <div class="display" id="toolbox" style="width: 28px; height: 20px">
                        <a title="Sửa tài khoản" href="{{ route('customers.edit', $customer->id) }}"><i
                                class="fas fa-pencil-alt"></i></a>
                        <a id="btn_del_account" rel="tooltip"
                           data-placement="bottom"
                           data-original-title="Xóa" class="ml5">
                            <i
                                class="gf-icon-hover icon-remove mr5"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 position" rel="tooltip">
                    <div class="no-padd tc mg0">
                        <h1 style="font-size:24px;color: #f36a26;" class="bold mg0">{{number_format($customer->wallet)}}
                            VNĐ</h1>
                        <p>Số dư ví</p></div>
                </div>
                <div class="col-md-1 position" rel="tooltip"></div>

                <div class="col-md-2 no-padd bor-l pl20 mg0 pt10 position hoverlastactive" rel="tooltip"
                     data-original-title="Click thay đổi người phụ trách" data-placement="bottom">
                    <div class="show_change_am" style="cursor:pointer">
                        <div class="avatar">
                            <img class="avatar"
                                 src="{{!empty($customer->telesale->avatar)?$customer->telesale->avatar:'/default/noavatar.png'}}">
                        </div>
                        <div class="info-avatar"><p class="account_manager_name"><a
                                    class="gfname">{{ @$customer->telesale->full_name }}</a>
                            </p>
                            <p class="gray1 font12">Người phụ trách</p></div>
                    </div>
                </div>
                <div class="col-md-1 no-padd tc bor-l mg0"></div>
                <div class="col-md-2 no-padd tc bor-l mg0"><h1 style="font-size:24px;color: #f36a26"
                                                               class="bold mg0">{{number_format($customer->orders->sum('gross_revenue'))}}
                        VNĐ</h1>
                    <p>Giá trị</p></div>
            </div>
            <div style="height:5px" class="color-picker-bg-41"></div>
            <div class="col-md-12 no-padd">
                <div class="col-md-2 no-padd" style="float: left; display: block">
                    <div class="full2 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2"><h3 class="uppercase pb5 mb10 font12 bold mg0">Mối
                                quan hệ</h3>
                            <div class="">{{ @$customer->status->name }}
                            </div>
                        </div>
                    </div>
                    <div class="full2 mt10" id="info_bar">
                        <div class="border padding infor-list-ct ml2">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-random mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Nguồn</span>
                                        </i>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ @$customer->source_customer->name }}</div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-user mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Người tạo</span>
                                        </i>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ @$customer->marketing->full_name }}</div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="uppercase pb5 mb10 font12 bold mg0">
                                        <i class="fa fa-calendar mr5 gray margin-left-10 tooltip-nav">&nbsp;
                                            <span class="tooltiptext">Ngày Tạo</span>
                                        </i>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <div
                                        class="text-a">{{ \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y') }}</div>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="uppercase pb5 mb10 font12 bold mg0"><i
                                            class="fa fa-shopping-cart mr5 gray margin-left-10 tooltip-nav">
                                            <span class="tooltiptext">Đơn</span>
                                        </i>
                                    </h3>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-a">{{ $customer->orders->count() }}</div>
                                </div>
                            </div>
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
                                            class="fa fa-star text-warning" aria-hidden="true"></i></p>
                                    <p></p>
                                    <p class="clearfix">&nbsp;{{ $customer->phone}}</p>
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
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Mã KH:</p>
                                <p class="word-wrap"> &nbsp;{{$customer->account_code}}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Tên KH:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->full_name }} </p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Chi nhánh:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->branch->name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Điện thoại:</p>
                                <p class="word-wrap"><a class="" data-account-id="4629"
                                                        data-type="crm" data-issensitive="true">
                                        &nbsp;{{ str_limit($customer->phone,7,'xxx') }} </a></p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Người phụ trách:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->telesale->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">CSKH:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->cskh->full_name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Nhóm giới tính:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->genitive->name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Nguồn KH:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->source_customer->name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Sinh nhật:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->birthday }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Mối quan hệ:</p>
                                <p class="word-wrap"> &nbsp;{{ @$customer->status->name }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Ngày tạo:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->created_at }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Giới tính:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->genderText }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Mô tả:</p>
                                <p class="word-wrap"> &nbsp;{{ $customer->description }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Số đơn hàng:</p>
                                <p class="word-wrap "> &nbsp;{{ $customer->orders->count() }}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Tổng doanh thu:</p>
                                <p class="word-wrap">
                                    &nbsp;{{number_format($customer->orders->sum('gross_revenue'))}}</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Tổng số tương tác:</p>
                                <p class="word-wrap">&nbsp;0</p>
                            </div>
                            <div class="mb10 clearfix "><p class="bold pr5 fl">Giá trị:</p>
                                <p class="word-wrap">
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
                                            <li><a href="#tab7" id="click_tab_7" data-id="{{$customer->id}}"
                                                   data-toggle="tab">Lịch hẹn</a></li>
                                            <li><a href="#tab6" id="click_tab_6" data-id="{{$customer->id}}"
                                                   data-toggle="tab">Đơn hàng</a></li>
                                            <li><a href="#tab8" id="click_tab_8" data-id="{{$customer->id}}"
                                                   data-toggle="tab">Lịch CSKH</a></li>
                                            @if(empty($permissions) || !in_array('package.customer',$permissions))
                                                <li><a href="#tab10" id="click_tab_10" data-id="{{$customer->id}}"
                                                       data-toggle="tab">Ví tiền</a></li>
                                            @endif
                                            <li><a href="#tab9" id="click_tab_9" data-phone="{{$customer->phone}}"
                                                   data-toggle="tab">Tin nhắn</a></li>
                                            <li><a href="#tabGift" id="click_tab_gift" data-id="{{$customer->id}}"
                                                   data-toggle="tab">Quà Tặng</a></li>
                                            <li><a href="#tab11" id="click_tab_11" data-phone="{{$customer->phone}}"
                                                   data-toggle="tab">Khuyến mại</a></li>
                                            <li><a href="#tab12" id="click_tab_12" data-phone="{{$customer->phone}}"
                                                   data-toggle="tab">Tổng đài</a></li>
                                            <li><a href="#tab13" id="click_tab_13" data-id="{{$customer->id}}"
                                                   data-toggle="tab">ALBUMS</a></li>
                                            <li>
                                                <input type="hidden" class="chat-page_id" value="{{@$customer->page_id}}">
                                                <input type="hidden" class="chat-sender_id" value="{{@$customer->FB_ID}}">
                                                <input type="hidden" class="chat-token" value="{{@$customer->fanpage->access_token}}">
                                                {{--<a href="#tab14" id="click_tab_14" data-id="{{$customer->id}}"--}}
                                                   {{--data-toggle="tab">Hội thoại FB</a>--}}
                                            </li>
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
                                                        </div>
                                                    </div>
                                                    {!! Form::open(array('url' => url('group_comments/'.request()->segment(count(request()->segments())) ), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
                                                    <div class="col-md-12 form-group required">
                                                        {!! Form::textArea('messages', null, array('class' => 'form-control', 'rows' => 3)) !!}
                                                    </div>
                                                    <br>
                                                    <div class="col-xs-12 col-md-12">
                                                        <div class="form-group required">
                                                            <div class="fileupload fileupload-new"
                                                                 data-provides="fileupload">
                                                                <div
                                                                    class="fileupload-preview fileupload-exists thumbnail"
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
                                            <div class="card-header row">
                                                <div class="col-md-8" style="display: flex">
                                                    <div class="button">
                                                        <a href="javascript:void(0)" data-value=""
                                                           class="type-order btn btn-warning">Tất cả</a>
                                                        <a href="javascript:void(0)" data-value="1"
                                                           class="type-order btn btn-success">Dịch vụ</a>
                                                        <a href="javascript:void(0)" data-value="2"
                                                           class="type-order btn btn-danger">Sản phẩm</a>
                                                        <a href="javascript:void(0)" data-value="3"
                                                           class="type-order btn btn-info">S.phẩm & D.vụ</a>
                                                    </div>
                                                    <input type="hidden" id="order_value">
                                                    <div class="select" style="margin-left: 4px">
                                                        {!! Form::select('the_rest', $the_rest, null, array('class' => 'form-control','id'=>'the_rest','placeholder'=>'Tất cả đơn')) !!}
                                                    </div>

                                                </div>
                                                <div class="col relative">
                                                    @if($roleGlobal->permission('order.add'))
                                                        <a class="right btn btn-primary text-white"
                                                           data-toggle="modal"
                                                           data-target="#roleTypeModal">Tạo mới</a>
                                                    @endif
                                                </div>
                                                @include('order.role_type_modal')

                                            </div>
                                            <div id="order_customer">
                                                {{--@include('customers.order')--}}
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab7">
                                            @include('schedules.index')
                                        </div>
                                        <div class="tab-pane" id="tab8">
                                            <div class="card-header row">
                                                <div class="col">
                                                    {{--@if($roleGlobal->permission('tasks.index'))--}}
                                                        <a class="right btn btn-primary text-white"
                                                           data-toggle="modal"
                                                           data-target="#modalTask" id="createTask">Tạo mới</a>
                                                    {{--@endif--}}
                                                </div>
                                            </div>
                                            <div class="col index-task"></div>
                                            @include('tasks.modal')
                                        </div>
                                        {{--    Modal thêm --}}
                                        @include('schedules.modal')
                                        {{--    END Modal thêm --}}
                                        <div class="tab-pane " id="tab10">
                                            @if(count($wallet))
                                                @include('wallet.history')
                                            @endif
                                        </div>
                                        <div class="tab-pane" id="tab9">
                                            <div id="content_tab9">
                                                @if(count($history))
                                                    @include('sms.history')
                                                @endif
                                            </div>
                                        @include('customers.modal-sendSMS')
                                        </div>
                                        <div class="tab-pane " id="tab11">
                                            @if(count($customer_post))
                                                @include('post.history')
                                            @endif
                                        </div>
                                        <div class="tab-pane " id="tab12">
                                            @include('call_center.customer')
                                        </div>
                                        <div class="tab-pane" id="tab13">
                                            @include('albums.index')
                                        </div>
                                        <div class="tab-pane" id="tabGift">
                                            @include('gifts.ajax')
                                        </div>
                                        {{--<div class="tab-pane" id="tab14">--}}
                                            {{--@include('message_fb.index')--}}
                                        {{--</div>--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/js/player.js"></script>
@endsection
@section('_script')
    <script src="{{ asset('zoom-image/js/mobilelightbox.js') }}"></script>
    <script src="{{ asset('zoom-image/js/main.js') }}"></script>
    <script src="{{asset('/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script src="{{asset('assets/js/util.js')}}"></script> <!-- util functions included in the CodyHouse framework -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script src="{{asset('js/jquery.textcomplete.min.js')}}"></script>
    <script src="{{asset('assets/plugins/simple-lightbox/simple-lightbox.min.js?v2.8.0')}}"></script>

    <script type="text/javascript">

        $('.autocomplete-textarea').textcomplete([{
            match: /(^|\s)@(\w*(?:\s*\w*))$/,

            search: function (query, callback) {
                let data = [{
                    name: "Tên khách hàng",
                    value: "%full_name%"
                },{
                    name: "Chi nhánh",
                    value: "%branch%"
                }, {
                    name: "SĐT chi nhánh",
                    value: "%phoneBranch%"
                },{
                    name: "Địa chỉ chi nhánh",
                    value: "%addressBranch%"
                }];
                callback(data);
            },

            template: function (hit) {
                // phan hien thi o dropdown
                let html = `
            <a class="tag-item" href="">
            <span class="label">${hit.name} <img width="40" src='{{asset('/assets/images/brand/logo.png')}}'/></span>
            </a>`;
                return html;
            },

            replace: function (hit) {
                // phan hien thi khi
                return hit.value.trim();
            }
        }]);

        // $(document).ready(function () {
        $(document).on('click', '#save_schedules', function (e) {
            let name = $('#update_status :selected').text();
            let ids = $('#update_id').val();
            $.post($('.formUpdateSchedule').attr('action'), $('.formUpdateSchedule').serialize(), function (data) {
                $('#updateModal').modal('hide');
            });
            $(".status[data-id='" + ids + "']").html(name);
        })
        $(document).on('click', '#click_tab_7', function () {
            const id = $(this).data('id');
            $('#tab7').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {schedules: 1, member_id: id}
            }).done(function (data) {
                $('#tab7').html(data);
            });
            // $('[data-toggle="datepicker"]').datepicker({
            //     format: 'dd-mm-yyyy',
            //     autoHide: true,
            //     zIndex: 2048,
            // });
        })
        $(document).on('click', '.name-task', function () {
            $('#modalUpdateTask').modal('show');
            let id = $(this).data('id');
            $.ajax({
                url: "/ajax/tasks/"+id,
                method: "get",
                // data: {member_id: id}
            }).done(function (data) {
                $('#name_update').val(data.name);
                $('.date_update').val(data.date_from.toLocaleString());
                $('.time_from').val(data.time_from);
                $('.time_to').val(data.time_to);
                $('#description_update').val(data.description);
                $('.formUpdateTask').attr('action', "/tasks/"+data.id).change();

                // $('#order_customer').html(data);
            });
        });
        $(document).on('click', '#click_tab_6', function () {
            const id = $(this).data('id');
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {member_id: id}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        })

        $(document).on('click', '#click_tab_gift', function () {
            const id = $(this).data('id');
            $('#tabGift').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url('gifts') }}",
                method: "get",
                data: {customer_id: id}
            }).done(function (data) {
                $('#tabGift').html(data);
            });
        })
        $(document).on('click', '#click_tab_8', function () {
            const id = $(this).data('id');
            $('.index-task').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {tasks: id}
            }).done(function (data) {
                $('.index-task').html(data);
            });
        })

        $(document).on('click', '.type-order', function () {
            const id = $(this).data('value') > 0 ? $(this).data('value') : "";
            $('#order_value').val(id).change();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {role_type: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        })
        $(document).on('change', '#the_rest', function () {
            let id = $(this).val();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {the_rest: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
        })
        $(document).on('click', '.page-link', function () {
            let id = $(this).html();
            let the_rest = $('#the_rest').val();
            let role_type = $('#order_value').val();
            let urls = location.href.split('/');
            let customer = urls[urls.length - 1];
            $('#order_customer').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {the_rest: the_rest, role_type: role_type, page_order: id, member_id: customer}
            }).done(function (data) {
                $('#order_customer').html(data);
            });
            return false
        })

        $(document).on('click', '#click_tab_9', function () {
            const phone = $(this).data('phone');
            $('#content_tab9').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {history_sms: phone}
            }).done(function (data) {
                $('#content_tab9').html(data);
            });
        })
        $(document).on('click', '#click_tab_10', function () {
            const id = $(this).data('id');
            $('#tab10').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {history_wallet: id}
            }).done(function (data) {
                $('#tab10').html(data);
            });
        })
        $(document).on('click', '#click_tab_11', function () {
            const phone = $(this).data('phone');
            $('#tab11').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {post: phone}
            }).done(function (data) {
                $('#tab11').html(data);
            });
        })
        $(document).on('click', '#click_tab_12', function () {
            const phone = $(this).data('phone');
            $('#tab12').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {call_center: phone}
            }).done(function (data) {
                $('#tab12').html(data);
            });
        })
        $(document).on('click', '#click_tab_13', function () {
            const id = $(this).data('id');
            $('#tab13').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');

            $.ajax({
                url: "{{url()->current() }}",
                method: "get",
                data: {albums: id}
            }).done(function (data) {
                $('#tab13').html(data);
            });
        })
        $(document).on('dblclick', '.order-type', function () {
            const id = $(this).data('id');
            let target = $(this);
            target.empty();

            $.ajax({
                url: "{{ Url('ajax/orders/') }}" + '/' + id,
                method: "get",
                data: {id: id}
            }).done(function (data) {
                let html = "";

                html +=
                    `<select class="list-type form-control select2" data-id=" ` + data.order.id + `" name="type">`;
                html +=
                    `<option value="2" ` + (2 === data.order.type ? "selected" : "") + `> Trong liệu trình </option>
                            <option value="3" ` + (3 === data.order.type ? "selected" : "") + `> Đã bảo hành </option>
                            <option value="4" ` + (4 === data.order.type ? "selected" : "") + ` > Đang bảo lưu </option>
                        </select>`;

                target.append(html);

                $('.select2').select2({ //apply select2 to my element
                    allowClear: true
                });
            });
        });

        $(document).on('change', '.list-type', function (e) {
            let target = $(this);
            const id = target.data('id');
            const type = target.val();

            $.ajax({
                url: "{{ Url('ajax/update-type-orders/') }}" + '/' + id,
                method: "put",
                data: {
                    type: type,
                }
            }).done(function (data) {
                target.parent().parent().find('.order-type').html(data);
            });
        });

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
        var historys = '';
        var order_details = '';

        $(document).on('click', '#edit-history-order', function (e) {
            e.preventDefault();
            $('.data-history-update-order').empty();
            let id = $(this).data('order-id');
            let html = `<option value="0" >Tất cả</option>`;
            $.ajax({
                type: 'get',
                url: "{{ Url('ajax/services-with-order/') }}" + "/" + id,
                success: function (res) {
                    res.forEach(element => {
                        html += `<option value="` + element.id + `">` + element.name + `</option>`;
                    });
                    $('#list_service').html(html);
                }
            })
            $.ajax({
                url: "{{ Url('ajax/orders/') }}" + '/' + id,
                method: "get",
            }).done(function (data) {
                let html = '';
                historys = data.history_update_orders;
                order_details = data.order_details;
                // console.log(data.history_update_orders.reverse());

                data.history_update_orders.reverse().forEach(function (item, index) {
                    let name = item.service != null ? item.service.name : '';
                    var name_type = '';
                    if (item.type == 0) {
                        name_type = 'Trừ liệu trình';
                    }
                    if (item.type == 1) {
                        name_type = 'Đã bảo hành';
                    }
                    if (item.type == 2) {
                        name_type = 'Đang bảo lưu';
                    }
                    let fullname = item.user && item.user.full_name ?item.user.full_name:'';
                    let name_support = item.support && item.support.full_name ?item.support.full_name:'';
                    let name_support2 = item.support2 && item.support2.full_name ?' | '+item.support2.full_name:'';
                    html += '<tr >' + '<td class="text-center">' + index + '</td>' +
                        '<td class="text-center">' + item.created_at + '</td>' +
                        '<td class="text-center">' + fullname + '</td>' +
                        '<td class="text-center">' + name_support +name_support2 +'</td>' +
                        '<td class="text-center">' + name + '</td>' +
                        '<td class="text-center">' + (item.description ? item.description : '') + '</td>' +
                        '<td class="text-center">' + (name_type ? name_type : '') + '</td>' +
                        '<td class="text-center"><a class="sum_history_order" href="javascript:void(0)" data-id="' + item.id + '"data-type="' + item.type + '"data-order="' + item.order_id + '"> <i class="fas fa-trash-alt"></i></a></td>' + '</tr>';
                });
                $('.data-history-update-order').append(html);
                $('#largeModal').modal("show");
            });

            $(document).change('#list_service', function () {
                let id = $('#list_service').val();
                let html = '';
                console.log(id, 'idđ');
                historys.forEach(function (item, index) {
                    let name = item.service != null ? item.service.name : '';
                    let service_id = item.service != null ? item.service.id : 0;
                    var name_type = '';
                    if (item.type == 0) {
                        name_type = 'Trừ liệu trình';
                    }
                    if (item.type == 1) {
                        name_type = 'Đã bảo hành';
                    }
                    if (item.type == 2) {
                        name_type = 'Đang bảo lưu';
                    }
                    if (service_id == id || id == 0) {
                        html += '<tr >' + '<td class="text-center">' + index + '</td>' +
                            '<td class="text-center">' + item.created_at + '</td>' +
                            '<td class="text-center">' + item.user.full_name + '</td>' +
                            '<td class="text-center">' + name + '</td>' +
                            '<td class="text-center">' + (item.description ? item.description : '') + '</td>' +
                            '<td class="text-center">' + (name_type ? name_type : '') + '</td>' +
                            '<td class="text-center"><a class="sum_history_order" href="javascript:void(0)" data-id="' + item.id + '"data-type="' + item.type + '"data-order="' + item.order_id + '"> <i class="fas fa-trash-alt"></i></a></td>' + '</tr>';
                    }
                });
                let detail = order_details.filter(f => f.booking_id == id);
                $('#count_service').html(detail.length > 0 ? 'Số buổi còn lại: ' + detail[0].days : '');
                $('.data-history-update-order').html(html);

            });

            $('body').delegate('.sum_history_order', 'click', function () {
                const order_id = $(this).data('order');
                const id = $(this).data('id');
                const type = $(this).data('type');
                $.ajax({
                    type: 'PUT',
                    url: "{{ Url('ajax/orders_sum/') }}" + "/" + order_id,
                    data: {
                        history_id: id,
                        type: type,
                    },
                    success: function (res) {
                        if (res == 'Success') {
                            alert("Xử lý liệu trình thành công");
                        } else if (res == "Failed")
                            alert("Số liệu trình đã hết");
                        window.location.reload();
                    }
                })
                // })
            });

        });

        $(document).on('click', '.edit-order', function () {
            let id = $(this).data('order-id');
            let html = "";
            //
            $.ajax({
                type: 'get',
                url: "{{ Url('ajax/services-with-order/') }}" + "/" + id,
                success: function (res) {
                    res.forEach(element => {
                        html += `<option value="` + element.id + `">` + element.name + `</option>`;
                    });
                    $('#service_modal').html(html);
                    $('#updateHistoryOrderModal').modal('show');
                }
            })
            //
            $('.save-update-history-order').click(function () {
                swal({
                    title: 'Bạn có muốn xử  liệu trình ?',
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
                                alert("Cập nhật liệu trình thành công");
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
        });

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

            $('body').delegate('.update', 'click', function (e) {
                let id = $(this).attr("data-id");
                let link = 'schedules/edit/' + id;
                $.ajax({
                    url: window.location.origin + '/' + link,
                    method: "get",
                }).done(function (data) {
                    $('#update_id').val(data['id']);
                    $('#update_date').val(data['date']);
                    $('#update_time1').val(data['time_from']);
                    $('#update_time2').val(data['time_to']);
                    $('#update_status').val(data['status']);
                    $('#update_note').val(data['note']);
                    $('.branch').val(data['branch_id']).change();
                    $('#update_action').val(data['person_action']).change();

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
                    time_from: {
                        required: true
                    },
                    time_to: {
                        required: true
                    },
                },
                messages: {
                    note: "Không được để trống !!!",
                    time_from: "Không được để trống !!!",
                    time_to: "Không được để trống !!!",
                },
            });
        });
        // });
        // $(document).on('click','#click_tab_14',function () {
        //     let page_id = $('.chat-page_id').val();
        //     let sender_id = $('.chat-sender_id').val();
        //     let token = $('.chat-token').val();
        //     getMessage(page_id,sender_id,token);
        // })
    </script>
    {{--@include('message_fb.js_chat_app')--}}
@endsection
