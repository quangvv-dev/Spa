@extends('layout.app')
@php
    $roleGlobal = auth()->user()?:[];
    $checkRole = checkRoleAlready();
@endphp
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/toggle-switch-custom.css') }}" rel="stylesheet"/>
    <style>
        .card i {
            color: #3b8fec !important;
        }

        .description-cus {
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            overflow-y: hidden;
            transition: ease 0.2s all;
            line-height: 20px;
            font-size: 11px;
            border: none;
        }

        .description-cus:focus, .description-cus:hover {
            height: 70px;
            width: 400px !important;
            z-index: 9999;
            box-shadow: 0 0 10px #ddd;
        }

        th.text-white.text-center{
        /*z-index: 1;*/
        }
        body.fixed-header1 .page {
            padding-top: 4.5rem;
        }
        body.fixed-header1 .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        .fixed-header1 {
            position: fixed;
            left: 0;
            right: 0;
            box-shadow: 0 0 0 1px rgba(61, 119, 180, .12), 0 8px 16px 0 rgba(91, 139, 199, .24);
            margin: 0 auto;
            z-index: 10;
        }
        .ren-navbar.fixed-header1.visible-title {
            top: 0;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <form id="gridFormA">
            <div class="card" >
                <div class="card-header search-box searchbox-sticky">
                    <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Tìm kiếm" tabindex="1"
                           type="text" id="search">
                    <div class="col-md-2 col-xs-12">
                        <select name="telesales_id" id="telesales_id" class="form-control telesales select2">
                            <option value="">Người phụ trách</option>
                            @foreach($telesales as $k => $l)
    {{--                            <optgroup label="{{ $k }}">--}}
                                    @foreach($l as $kl => $vl)
                                        <option
                                            {{@$customer->telesales_id == $vl?'selected':''}} value="{{ $vl }}">{{ $kl }}</option>
                                    @endforeach
    {{--                            </optgroup>--}}
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <select name="group" class="form-control group select2">
                            <option value="">Nhóm dịch vụ</option>
                            @foreach($categories as $item)
                                <option value="{{$item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <select name="call_back" class="form-control call_back select2">
                            <option value="">Tất cả công việc</option>
                            <option value="{{\App\Constants\StatusCode::GOI_LAI}}">GỌI LẠI</option>
                        </select>
                    </div>
                    <div class="col-xs-12" style="max-width: 170px">
                        @if(empty($checkRole))
                            <select name="branch_id" class="form-control branch_id">
                                <option value="">Tất cả chi nhánh</option>
                                @foreach($branchs as $k=> $item)
                                    <option {{$k==1?'selected':''}} value="{{$k}}">{{ $item}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col relative">
                        <a {{$roleGlobal->permission('customer.import')?:"style=display:none"}}
                            class="btn tooltip-nav" href="#" data-toggle="modal" data-target="#myModal">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="tooltiptext">Nhập khách hàng (excel)</span>
                        </a>
                        <a {{$roleGlobal->permission('customer.export')?:"style=display:none"}}
                           class="btn tooltip-nav" href="#" data-toggle="modal" data-target="#myModalExport">
                            <i class="fas fa-cloud-download-alt"></i>
                            <span class="tooltiptext">Tải khách hàng (excel)</span>
                        </a>
                        {{--<a class="btn tooltip-nav dropdown-custom1">--}}
                            {{--@include('components.user_filter_grid')--}}
                        {{--</a>--}}
                        @if($roleGlobal->permission('customers.add'))
                            <a class="right btn btn-primary btn-flat"
                               href="{{ route('customers.create') }}">Tạo mới</a>
                        @endif
                    </div>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a style="display: none" href="#" class="angleDoubleUp">
                                    <i class="fa fa-angle-double-up"></i></a></li>
                            <li><a href="#" class="angleDoubleDown"><i class="fa fa-angle-double-down"></i></a></li>
                        </ul>
                    </div>
                </div>
                @include('customers.dropdownFilter')
                <div id="registration-form">
                    @include('customers.ajax')
                </div>
                @include('customers.modal')
                @include('customers.modal-export')
                @include('customers.modal-update-relation')
                @include('customers.modal-update-account-manager')
                @include('customers.modal-branch')
                @include('kanban_board.modal')
                <input type="hidden" id="status">
                <input type="hidden" id="invalid_account">
                <input type="hidden" id="group">
                <input type="hidden" id="group_product">
                <input type="hidden" id="source">
                <input type="hidden" id="telesales">
                <input type="hidden" id="search_value">
                <input type="hidden" id="btn_choose_time">
                <input type="hidden" id="birthday_tab">
            </div>
        </form>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">

        $("#search").focus();
        $(function () {
            $(document).on('click', '.view_modal', function (e) {
                e.preventDefault();

                $('.customer-chat').empty();
                let id = $(this).data('customer-id');
                let check_show_button = false;
                $.ajax({
                    url: "{{ Url('/group_comments/') }}" + '/' + id,
                    method: "get",
                }).done(function (data) {
                    if(data.customer.page_id && data.customer.FB_ID && data.customer.fanpage){
                        check_show_button = true;
                        $('#view_chat .chat-page_id').val(data.customer.page_id);
                        $('#view_chat .chat-sender_id').val(data.customer.FB_ID);
                        $('#view_chat .chat-token').val(data.customer.fanpage.access_token);
                    } else {
                        check_show_button = false;
                        $('#view_chat .chat-page_id').val('');
                        $('#view_chat .chat-sender_id').val('');
                        $('#view_chat .chat-token').val('');
                    }
                    let category = '';

                    data.customer.categories.forEach(function (item) {
                        console.log(item);
                        category += item.name + `, `;
                    });

                    let html = '';
                    html += `<div class="row" style="padding-bottom: 10px;">
                    <div class="chat-flash col-md-12">
                        <div class="white-space" style="display: flex; align-items: center;justify-content: space-around;">
                            <img width="50" height="50" class="fl mr10 a40 border"
                                 src="{{asset('default/no-image.png')}}" style="border-radius:100%">

                            <div class="mt10 pb10" style="height:86px ; color:black">
                            <div class="col-md-10 info-avatar padding5 last_contacthover box_last">
                            <p><i class="fa fa-user mr5" style="color: black;"></i> ` + data.customer.full_name + `
                                <i class="fa orange fa-star" aria-hidden="true" style="color: orange;"></i>
                            </p>
                            <p class="mt10"><i class="fa fa-phone mr10" style="color: black;" aria-hidden="true"></i><a class="__clickToCall blue" data-contact-id="5678"
                                                          rel="tooltip" data-original-title="Click để gọi"
                                                          data-placement="right" data-flag="1"
                                                          data-type="crm"> ` + data.customer.phone + `</a></p>
                            <p> <i class="fa fa-users"style="color: black;" aria-hidden="true"></i>` + category + `</p>
                            <p class="mt10 white-space"><i class="icon-envelope mr5"></i></p></div>
                        </div>
                        <a class="bold blue uppercase user-name" href="javascript:void(0);" style="margin-left: 5px">
                            <span>@` + (data.customer.telesale ? data.customer.telesale.full_name : "") + `</span></br>
                            <span>Cskh: ` + (data.customer.cskh ? data.customer.cskh.full_name : "") + `</span>
                            </a>
                        </div>

                         <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }} "style="margin-top: 20px;">
                            {!! Form::label('status_id', 'Trạng thái', array('class' => 'control-label')) !!}` +
                        `<select name="status_id" class="form-control status-result select2" data-id="` + data.customer.id + `" style="font-size: 14px;">`;
                    data.status.forEach(function (item) {
                        html += `<option value="` + item.id + `"  ` + (item.id === data.customer.status_id ? "selected" : "") + `>` + item.name + `</option>`;
                    });
                    html += `</select>`;
                    html += `
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Nguồn khách hàng:</div> <div class="col-md-7 word-break">` + (data.customer.source_customer ? data.customer.source_customer.name : "") + `</div> </div>
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Liên hệ lần cuối:</div> <div class="col-md-7 word-break">` + (data.last_contact ? data.last_contact : "") + `</div> </div>
                <div class="row mt10" style="color:black;"> <div class="col-md-5">Giá trị:</div> <div class="col-md-7 word-break" style="color:orange;">` + data.order_revenue + ` VND</div> </div>
                </div>
                        <div class="form-group required {{ $errors->has('enable') ? 'has-error' : '' }}">
                            {!! Form::textArea('messages', null, array('class' => 'form-control message', 'rows'=> 3, 'required' => 'required')) !!}
                        <span class="help-block">{{ $errors->first('enable', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success chat-save" id="chat-save" data-customer-id="">Lưu</button>

                        <button class="btn btn-warning message-chat float-right">Hội thoại FB</button>
                        <button class="btn btn-info sale-note float-right mr-1">Trao đổi</button>
                    </div>
                </div>
                @include('message_fb.index')
                <div class="chat-ajax" >

                        </div>`;

                let html1 = '';
                    data.group_comments.forEach(function (item) {
                        html1 += `<div class="col comment-fast" style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;">
                                <div class="no-padd col-md-12">
                                    <div class="col-md-11"><p><a href="#" class="bold blue">` + (item.full_name ?? "") + `</a>
                                        <span><i class="fa fa-clock"> ` + item.created_at + `</i></span></p>
                                    </div>` +
                            (data.id_login == item.user_id ? `<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                        @if(!in_array('comment.edit',setting('permissions')??[]))
                                        <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                        <i class="fas fa-edit btn-edit-comment" data-id="` + item.id + `"></i>
                                        </a>
                                        @endif

                                        <a data-original-title="Xóa" rel="tooltip">
                                            <i class="fas fa-trash-alt btn-delete-comment" data-id="` + item.id + `"></i>
                                        </a>
                                    </div>` : "") +
                            `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px; white-space: pre-line;">` + item.messages + `
                                    </div>
                                </div>
                            </div>`;
                    });

                    $(".status-result").val(data.customer.status_id).change();
                    $('.customer-chat').append(html);
                    $('.chat-ajax').html(html1);
                    $('#view_chat').modal("show");
                    $('.chat-save').attr('data-customer-chat-id', data.customer.id);
                    $('#view_chat .chatApplication').hide();
                    if(!check_show_button){
                        $('#view_chat .message-chat').hide();
                        $('#view_chat .sale-note').hide();
                    } else {
                        $('#view_chat .message-chat').show();
                        $('#view_chat .sale-note').show();
                    }
                });
            });

            $(document).on('click', '.chat-save', function () {
                let customer_id = $(this).data('customer-chat-id');
                let messages = $('.message').val();
                $('.message').val('');

                $.ajax({
                    url: "{{ Url('/ajax/group-comments/') }}",
                    method: "post",
                    data: {
                        messages: messages,
                        customer_id: customer_id
                    }
                }).done(function (data) {
                    let html = '';
                    html += `<div style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;" >
                    <div class="no-padd col-md-12 comment-fast">
                    <div class="col-md-11"><p><a href="#" class="bold blue">` + data.group_comment.user.full_name + `</a>
                        <span><i class="fa fa-clock"> ` + data.group_comment.created_at + `</i></span></p>
                    </div>` +
                        (data.id_login == data.group_comment.user_id ? `<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                        <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                            <i class="fas fa-edit btn-edit-comment" data-id="` + data.group_comment.id + `"></i>
                                        </a>
                                        <a data-original-title="Xóa" rel="tooltip">
                                            <i class="fas fa-trash-alt btn-delete-comment" data-id="` + data.group_comment.id + `"></i>
                                        </a>
                                    </div>` : "") +
                        `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px; white-space: pre-line;">` + data.group_comment.messages + `</div>
                    </div>
                    </div>`;

                    $('.chat-ajax').prepend(html);
                });

            });

            $(document).on('click', '.btn-edit-comment', function (e) {
                let target = $(e.target).parent().parent().parent();
                let group_comment_id = $(this).data('id');

                $.ajax({
                    url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/edit",
                    method: "get",
                }).done(function (data) {

                    let html = `<div class="col-md-12" >
                    <textarea name="messages" class="form-control message" rows="2" data-id="` + data.id + `">` + data.messages + `</textarea>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 30px;">
                        <button style="float: right; margin-top: 5px;" type="submit"
                                class="btn btn-success update-messages">Cập nhật
                        </button>
                    </div>`;
                    $(target).find('.comment').empty();
                    $(target).find(".comment").append(html);
                });
            });

            $(document).on('click', '.update-messages', function (e) {
                let target = $(e.target).parent().parent().parent().parent();
                let messages = $(target).find('.message').val();
                let id = $(target).find('.message').data('id');

                $.ajax({
                    url: "{{ Url('group-comments/') }}" + "/" + id + "/edit",
                    method: "post",
                    data: {
                        messages: messages
                    }
                }).done(function (data) {
                    $(target).find('.message').empty();
                    $(target).find(".comment").html(data.messages);
                });
            });

            $(document).on('click', '.btn-delete-comment', function (e) {
                let target = $(e.target).parent().parent().parent();
                let group_comment_id = $(this).data('id');

                let result = confirm("Bạn muốn xoá tin nhắn này?");
                if (result) {
                    $.ajax({
                        url: "{{ Url('group-comments/') }}" + "/" + group_comment_id + "/delete",
                        method: "delete",
                    }).done(function () {
                        $(target).parent().find(".comment-fast").remove();
                    });
                }
            });

            function searchAjax(data) {
                $('#registration-form').html('<div class="text-center"><i style="font-size: 100px;" class="fa fa-spinner fa-spin"></i></div>');
                $.ajax({
                    url: "{{ Url('customers/') }}",
                    method: "get",
                    data: data
                }).done(function (data) {
                    $('.load').hide();
                    $('#registration-form').html(data);
                });
            }

            $(document).on('click', '.status', function () {
                let carepage_id = $('.carepage').val();
                let status = $(this).data('name');
                let location = $('.location').val();
                let data_time = $('#btn_choose_time').val();
                let search = $('#search_value').val();
                let group = $('#group').val();
                let marketing = $('#group_product').val();
                let source = $('#source').val();
                let telesales = $('#telesales').val();
                let branch_id = $('.branch_id').val();
                let cskh = $('.cskh').val();

                $('#status').val(status);
                $('#birthday_tab').val('');
                let data = {
                    carepage_id: carepage_id,
                    status: status,
                    data_time: data_time,
                    group: group,
                    telesales: telesales,
                    search: search,
                    source: source,
                    marketing: marketing,
                    branch_id: branch_id,
                    location_id: location,
                    cskh_id: cskh,
                };

                searchAjax(data);
            });

            $(document).on('click', '.limiting', function () {
                let limit = $(this).data('limit');
                $.ajax({
                    url: "{{ Url('/set-default-pagination') }}",
                    method: "post",
                    data: {limit: limit}
                }).done(function (data) {
                    alertify.success('Cập nhật bản ghi thành công !');
                });
            });

            $(document).on('click', '.birthday_tab', function () {
                $('#birthday_tab').val(1);
                let data = {birthday: 1};

                searchAjax(data);
            });
            $(document).on('click', '.other_time', function () {
                $(".other_time_panel").css({'display': ''});
            });
            $(document).ready(function () {
                $('[data-toggle="datepicker"]').datepicker({
                    format: 'dd-mm-yyyy',
                    autoHide: true,
                    zIndex: 2048,
                });
            });
            $(document).on('click', '.btn_choose_time, .submit_other_time', function (e) {
                let target = $(e.target).parent();
                let data_time = $(target).find('.btn_choose_time').data('time');
                $('#birthday_tab').val('');
                $('#btn_choose_time').val(data_time);
                let search = $('#search_value').val();
                let carepage_id = $('.carepage').val();
                let group = $('#group').val();
                let telesales = $('#telesales').val();
                let status = $('#status').val();
                let marketing = $('#group_product').val();
                let source = $('#source').val();
                let branch_id = $('.branch_id').val();
                let gender = $('.gender').val();
                let location = $('.location').val();
                const start_date = $('.filter_start_date').val();
                const end_date = $('.filter_end_date').val();
                let cskh = $('.cskh').val();

                $('.filter_start_date').val('');
                $('.filter_end_date').val('');
                let data = {
                    data_time: data_time,
                    carepage_id: carepage_id,
                    group: group,
                    telesales: telesales,
                    search: search,
                    status: status,
                    source: source,
                    marketing: marketing,
                    branch_id: branch_id,
                    gender: gender,
                    location_id: location,
                    start_date: start_date,
                    end_date: end_date,
                    cskh_id: cskh,
                };
                searchAjax(data);
                e.preventDefault();
            });

            // delay keyup
            function delay(callback, ms) {
                // alert(ms);
                var timer = 0;
                return function () {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        callback.apply(context, args);
                    }, ms || 0);
                };
            }

            $(document).on('change', '.group, .telesales, .group-product, .source, .branch_id, .gender, .location,.carepage, .call_back,.cskh', delay(function () {
                let marketing = $('.group-product').val();
                let call_back = $('.call_back').val();
                let carepage_id = $('.carepage').val();
                let gender = $('.gender').val();
                let location = $('.location').val();
                let branch_id = $('.branch_id').val();
                let source = $('.source').val();
                let group = $('.group').val();
                let cskh = $('.cskh').val();
                let telesales = $('.telesales').val();
                let search = $('#search_value').val();
                $('#branch_id').val(branch_id);
                $('#source').val(source);
                $('#group').val(group);
                $('#group_product').val(marketing);
                $('#telesales').val(telesales);
                $('#birthday_tab').val('');
                let data_time = $('#btn_choose_time').val();
                let status = $('#status').val();
                let data = {
                    marketing: marketing,
                    call_back: call_back,
                    carepage_id: carepage_id,
                    gender: gender,
                    location_id: location,
                    group: group,
                    telesales: telesales,
                    data_time: data_time,
                    search: search,
                    status: status,
                    source: source,
                    branch_id: branch_id,
                    cskh_id: cskh
                };
                searchAjax(data);

            }, 500));
// Định nghĩa hàm xử lý sự kiện khi nhấn phím
            function handleKeyDown(event) {
                if (event.keyCode === 13) {
                    event.preventDefault(); // Chặn việc gửi form
                }
            }

// Lắng nghe sự kiện keydown cho các phần tử input trong form
            $("#gridFormA").on("keydown", handleKeyDown);
            $(document).on('keyup', '#search', delay(function (e) {
                let search = $('#search').val();
                let carepage_id = $('.carepage').val();
                $('#search_value').val(search);
                $('#birthday_tab').val('');
                let data_time = $('#btn_choose_time').val();
                let group = $('#group').val();
                let telesales = $('#telesales').val();
                let status = $('#status').val();
                let marketing = $('#group_product').val();
                let source = $('#source').val();
                let branch_id = $('.branch_id').val();
                let gender = $('.gender').val();
                let location = $('.location').val();
                let cskh = $('.cskh').val();

                let data = {
                    carepage_id: carepage_id,
                    search: search,
                    gender: gender,
                    data_time: data_time,
                    group: group,
                    telesales: telesales,
                    status: status,
                    marketing: marketing,
                    source: source,
                    branch_id: branch_id,
                    location_id: location,
                    cskh_id: cskh,
                };
                searchAjax(data);
                e.preventDefault();
            }, 500));

            $(document).on('click', '.invalid_account', function (e) {
                let target = $(e.target).parent();
                let invalid_account = $(target).find('.invalid_account').data('invalid');
                if (invalid_account === 0) {
                    $("#send_email, #send_sms, #mark_as_potential, #show_popup_task, #show_group_type_account, #show_manager_account, #remove_selected_account, #change_relations").css({'display': 'none'});
                    $("#restore_account, #permanently_delete_account").css({'display': 'block'});
                } else {
                    $("#send_email, #send_sms, #mark_as_potential, #show_popup_task, #show_group_type_account, #show_manager_account, #remove_selected_account, #change_relations").css({'display': 'block'});
                    $("#restore_account, #permanently_delete_account").css({'display': 'none'});
                }
                $('#birthday_tab').val('');
                $('#invalid_account').val(invalid_account);
                let data = {invalid_account: invalid_account};

                searchAjax(data);
            });

            $(document).on('dblclick', '.category-db', function (e) {
                let target = $(e.target).parent();
                $(target).find('.category-db').empty();
                let id = $(this).data('id');
                let html = '';

                $.ajax({
                    url: "ajax/categories/",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="category-result form-control select2-multiple" multiple="multiple" data-id="' + data.customer_id + '" name="group_id[]">';
                    data.categories.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '" class="category-op"  ' + ((jQuery.inArray(item.id, data.category_id) !== -1 ? "selected" : "")) + '>' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".category-db").append(html);

                    $('.select2-multiple').select2({ //apply select2 to my element
                        placeholder: "Chọn nhóm KH",
                        allowClear: true
                    });

                });
            });

                $(document).on('dblclick', '.category-tip', function (e) {
                    let target = $(e.target).parent();
                    $(target).find('.category-tip').empty();
                let id = $(this).data('id');
                let html = '';

                $.ajax({
                    url: "ajax/categories-tips/",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="tip-result form-control select2-multiple" multiple="multiple" data-id="' + data.customer_id + '" name="group_id[]">';
                    data.categories.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '" class="tip-op"  ' + ((jQuery.inArray(item.id.toString(), data.category_id) !== -1 ? "selected" : "")) + '>' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".category-tip").append(html);

                    $('.select2-multiple').select2({ //apply select2 to my element
                        placeholder: "Chọn nhóm KH",
                        allowClear: true
                    });

                });
            });

            $(document).on('dblclick', '.customer-birthday', function (e) {
                let target = $(e.target).parent();
                let customerBirthday = $(this);
                let id = $(this).data('id');
                customerBirthday.empty();

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    let birthdayResult = document.createElement('input');
                    birthdayResult.setAttribute('data-id', data.id);
                    birthdayResult.setAttribute('id', data.id);
                    birthdayResult.setAttribute('value', data.birthday);
                    birthdayResult.setAttribute('name', "birthday");
                    birthdayResult.setAttribute('class', "form-control birthday-result");
                    birthdayResult.setAttribute('style', "font-size: 0.875rem;");
                    birthdayResult.onchange = customerBirthday_handleChange;
                    birthdayResult.onblur = customerBirthday_handleChange;
                    customerBirthday.append(birthdayResult);

                    let jqueryBirthdayResult = $(birthdayResult);
                    jqueryBirthdayResult.datepicker({
                        format: "DD-MM-YYYY"
                    });

                    birthdayResult.focus();
                });
            });

            function customerBirthday_handleChange(event) {
                let parent = event.target.parentNode;
                let birthday = event.target.value;
                let id = event.target.id;

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        birthday: birthday
                    }
                }).done(function (data) {
                    parent.innerHTML = data.birthday;
                });

            }

            $(document).on('focusout, change', '.customer-birthday', function (e) {
                let target = $(e.target).parent();
                let birthday = $(target).find('.birthday-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        birthday: birthday
                    }
                }).done(function (data) {
                    $(target).parent().find(".customer-birthday").empty();
                    $(target).parent().find('.customer-birthday').html(data.birthday);
                });
            });

            $(document).on('dblclick', '.status-db', function (e) {
                let target = $(e.target).parent();
                $(target).find('.status-db').empty();
                let id = $(this).data('id');
                let html = '';
                $.ajax({
                    url: "ajax/statuses/",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="status-result form-control select2" data-id="' + data.customer.id + '" name="status_id" style="font-size: 14px;">';
                    data.data.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '" ' + (item.id === data.customer.status_id ? "selected" : "") + '>' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".status-db").append(html);
                });
            });

            $(document).on('dblclick', '.genitive-db', function (e) {
                let target = $(e.target).parent();
                $(target).find('.genitive-db').empty();
                let id = $(this).data('id');
                let html = '';

                $.ajax({
                    url: "ajax/genitives/",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="genitive-result form-control" data-id="' + data.customer.id + '" name="status_id" style="font-size: 14px;">';
                    data.data.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '" ' + (item.id === data.customer.genitive_id ? "selected" : "") + '>' + item.name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".genitive-db").append(html);
                });
            });

            $(document).on('change', '.status-result', function (e) {
                let target = $(e.target).parent();
                let status_id = $(target).find('.status-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        status_id: status_id
                    }
                }).done(function (data) {
                    $(target).parent().find(".status-db").empty();
                    $(target).parent().find('.status-db').html(data.status.name);
                });
            });

            $(document).on('change', '.genitive-result', function (e) {
                let target = $(e.target).parent();
                let genitives = $(target).find('.genitive-result').val();
                let id1 = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id1,
                    method: "put",
                    data: {
                        genitive_id: genitives
                    }
                }).done(function (data) {
                    $(target).parent().find(".genitive-db").empty();
                    $(target).parent().find('.genitive-db').html(data.genitive.name);
                    $(target).parent().find('.genitive-db').attr('title', data.genitive.description);
                });
            });


            $(document).on('change', '.description-cus', function (e) {
                let target = $(e.target).parent();
                let description = $(target).find('.description-cus').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        description: description,
                    }
                }).done(function (data) {
                });
            });

                $(document.body).on("change",".category-result",function(e){
                    if (!($('.category-result').parent().find('span.select2-container--focus').length) ||
                    $('.category-result').parent().find('.select2-container--below .selection  .select2-selection--multiple').length) {
                    let category_ids = $(e.target).parent().find('.category-result').val();
                    let id = $(e.target).parent().find('.category-result').data('id');

                    $.ajax({
                        url: "ajax/customers/" + id,
                        method: "put",
                        data: {
                            category_ids: category_ids
                        }
                    }).done(function (data) {
                        let blkstr = $.map(data.categories, function (val) {
                            let str = val.name;
                            return str;
                        }).join(", ");

                        $('.category-result').parent().parent().find('.category-db').html(blkstr);
                    });
                }
            });

                $(document.body).on("change",".tip-result",function(e){
                if (!($('.tip-result').parent().find('span.select2-container--focus').length) ||
                    $('.tip-result').parent().find('.select2-container--below .selection  .select2-selection--multiple').length) {
                    let category_ids = $(e.target).parent().find('.tip-result').val();
                    let id = $(e.target).parent().find('.tip-result').data('id');

                    $.ajax({
                        url: "ajax/customers/" + id,
                        method: "put",
                        data: {
                            category_tips: category_ids
                        }
                    }).done(function (data) {
                        let blkstr = `<span class="badge badge-primary"> `+data.tips+`</span>`;
                        $('.tip-result').parent().parent().find('.category-tip').html(blkstr);
                    });
                }
            });

            $(document).on('click', '.selectall', function () {
                if ($(this).hasClass('active')) {
                    $('.myCheck').each(function () {
                        this.checked = false;
                    });
                    $(this).html('Chọn tất cả');
                    $(this).removeClass('active');

                } else {
                    $(this).addClass('active');
                    $('.myCheck').each(function () {
                        this.checked = true;
                    });
                    $(this).html('Bỏ chọn tất cả');
                }
            });

            $(document).on('click', '#remove_selected_account', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                $.each(id, function () {
                    ids.push($(this).val());
                });

                swal({
                    title: 'Bạn có muốn xóa ?',
                    text: "Nếu bạn xóa tất cả các thông tin sẽ không thể khôi phục!",
                    type: "error",
                    showCancelButton: true,
                    cancelButtonClass: 'btn-secondary waves-effect',
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'OK'
                }, function () {
                    $.ajax({
                        type: 'POST',
                        url: 'customers/delete-multiple',
                        data: {
                            ids: ids,
                        },
                        success: function () {
                            window.location.reload();
                        }
                    })
                })
            });

            $(document).on('click', '.myCheck', function () {
                if ($(this).is(':checked'))
                    $("#btn_tool_group").css({'display': 'block'});
                else
                    $("#btn_tool_group").css({'display': 'none'});
            });

            $('body').on('click', 'a.page-link', function (e) {
                e.preventDefault();
                let pages = $(this).attr('href').split('page=')[1] ? $(this).attr('href').split('page=')[1] : 1;
                let group = $('.group').val();
                let carepage_id = $('.carepage').val();
                let telesales = $('.telesales').val();
                let search = $('#search_value').val();
                let marketing = $('#group_product').val();
                let source = $('#source').val();
                let gender = $('.gender').val();
                let branch_id = $('.branch_id').val();
                let status = $('#status').val();
                let invalid_account = $('#invalid_account').val();
                let btn_choose_time = $('#btn_choose_time').val();
                let birthday = $('#birthday_tab').val();
                let location = $('.location').val();
                let cskh = $('.cskh').val();

                $.ajax({
                    url: '{{ url()->current() }}',
                    method: "get",
                    data: {
                        location_id: location,
                        carepage_id: carepage_id,
                        gender: gender,
                        marketing: marketing,
                        source: source,
                        page: pages,
                        group: group,
                        telesales: telesales,
                        invalid_account: invalid_account,
                        search: search,
                        status: status,
                        data_time: btn_choose_time,
                        birthday: birthday,
                        branch_id: branch_id,
                        cskh_id: cskh
                    },
                }).done(function (data) {
                    $('#registration-form').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            });

            $(document).on('dblclick', '.name-customer', function (e) {
                let target = $(e.target).parent();
                $(target).find('.name-customer').empty();
                let id = $(this).data('customer-id');
                let html = '';

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "get",
                    data: {id: id}
                }).done(function (data) {

                    html += `<textarea data-id=` + data.id + ` class="handsontableInput" style="width: auto; height: 58px; font-size: 14px; overflow-y: hidden;"> ` + data.full_name + `</textarea>`;
                    $(target).find(".name-customer").append(html);
                });
            });
            $(document).on('dblclick', '.phone-customer', function (e) {
                let target = $(e.target).parent();
                $(target).find('.phone-customer').empty();
                let id = $(this).data('customer-id');
                let html = '';

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "get",
                    data: {id: id}
                }).done(function (data) {

                    html += `<textarea data-id=` + data.id + ` class="phone-result" style="width: auto; height: 58px; font-size: 14px; overflow-y: hidden;"> ` + data.phone + `</textarea>`;
                    $(target).find(".phone-customer").append(html);
                });
            });

            $(document).on('focusout', '.handsontableInput', function (e) {
                let target = $(e.target).parent();
                let full_name = $(target).find('.handsontableInput').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        full_name: full_name,
                    }
                }).done(function (data) {
                    let html = `<a class="view_modal" id="chat-fast" data-customer-id="` + data.id + `" href="#">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="customers/` + data.id + `">` + data.full_name + `</a>
                            <span class="noti-number noti-number-on ml5"></span>`;
                    $(target).parent().find(".name-customer").html(html);
                });
            });

            $(document).on('focusout', '.phone-result', function (e) {
                let target = $(e.target).parent();
                let phone = $(target).find('.phone-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        phone: phone,
                    }
                }).done(function (data) {
                    $(target).parent().find(".phone-customer").html(data.phone);
                });
            });

            $(document).on('click', '#restore_account', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                $.each(id, function () {
                    ids.push($(this).val());
                });

                swal({
                    title: 'Bạn có muốn khôi phục tài khoản ?',
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonClass: 'btn-secondary waves-effect',
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'OK'
                }, function () {
                    $.ajax({
                        type: 'POST',
                        url: 'customers/restore',
                        data: {
                            ids: ids,
                        },
                        success: function () {
                            window.location.reload();
                        }
                    })
                })
            });

            $(document).on('click', '#permanently_delete_account', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                $.each(id, function () {
                    ids.push($(this).val());
                });

                swal({
                    title: 'Bạn có muốn xóa ?',
                    text: "Nếu bạn xóa tất cả các thông tin sẽ không thể khôi phục!",
                    type: "error",
                    showCancelButton: true,
                    cancelButtonClass: 'btn-secondary waves-effect',
                    confirmButtonClass: 'btn-danger waves-effect waves-light',
                    confirmButtonText: 'OK'
                }, function () {
                    $.ajax({
                        type: 'POST',
                        url: 'customers/force-delete',
                        data: {
                            ids: ids,
                        },
                        success: function () {
                            window.location.reload();
                        }
                    })
                })
            });

            $(document).on('click', '#change_relations', function () {
                $('#updateRelation').modal("show");
            });

            $(document).on('click', '.update-multiple-status', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                let status_id = $('.status-customer').val();
                $.each(id, function () {
                    ids.push($(this).val());
                });

                $.ajax({
                    url: "customers/update-multiple-status",
                    method: "post",
                    data: {
                        ids: ids,
                        status_id: status_id,
                    }
                }).done(function () {
                    window.location.reload();
                });
            });

            @if(\Illuminate\Support\Facades\Auth::user()->role != \App\Constants\UserConstant::TELESALES)
            $(document).on('dblclick', '.telesale-customer', function (e) {
                let target = $(e.target).parent();
                $(target).find('.telesale-customer').empty();
                let id = $(this).data('customer-id');
                let html = '';

                $.ajax({
                    url: "ajax/customers",
                    method: "get",
                    data: {id: id}
                }).done(function (data) {
                    html +=
                        '<select class="telesales-result form-control select2" data-id="' + data.customer.id + '" name="telesale_id" style="font-size: 14px;">';
                    data.data.forEach(function (item) {
                        html +=
                            '<option value="' + item.id + '" ' + (item.id === data.customer.telesales_id ? "selected" : "") + '>' + item.full_name + '</option>';
                    });

                    html += '</select>';
                    $(target).find(".telesale-customer").append(html);
                });
            });
            @endif

            $(document).on('change', '.telesales-result', function (e) {
                let target = $(e.target).parent();
                let telesales_id = $(target).find('.telesales-result').val();
                let id = $(this).data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        telesales_id: telesales_id,
                    }
                }).done(function (data) {
                    $(target).parent().find(".telesale-customer").html(data.telesale.full_name);
                });
            });

            $(document).on('click', '#show_manager_account', function () {
                $('#show-manager-account').modal("show");
            })

            $(document).on('click', '.update-multiple-account-manager', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                let account_manager = $('#manager-account').val();
                $.each(id, function () {
                    ids.push($(this).val());
                });

                $.ajax({
                    url: "customers/update-multiple-status",
                    method: "post",
                    data: {
                        ids: ids,
                        telesales_id: account_manager,
                    }
                }).done(function () {
                    window.location.reload();
                });
            });

            $(document).on('click', '.update-multiple-branch', function () {
                let id = $('td .myCheck:checked');
                let ids = [];
                let branch_id = $('#changeBranch').val();
                $.each(id, function () {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: "customers/update-multiple-branch",
                    method: "post",
                    data: {
                        ids: ids,
                        branch_id: branch_id,
                    }
                }).done(function () {
                    window.location.reload();
                });
            });
        }());
    </script>
    <script>
        $(function ($) {
            var scrollbar = $('<div id="fixed-scrollbar"><div></div></div>').appendTo($(document.body));
            scrollbar.hide().css({
                overflowX: 'auto',
                position: 'fixed',
                width: '100%',
                bottom: 0
            });
            var fakecontent = scrollbar.find('div');

            function top(e) {
                return e.offset().top;
            }

            function bottom(e) {
                return e.offset().top + e.height();
            }

            var active = $([]);

            function find_active() {
                scrollbar.show();
                var active = $([]);
                $('.fixed-scrollbar').each(function () {
                    if (top($(this)) < top(scrollbar) && bottom($(this)) > bottom(scrollbar)) {
                        fakecontent.width($(this).get(0).scrollWidth);
                        fakecontent.height(1);
                        active = $(this);
                    }
                });
                fit(active);
                return active;
            }

            function fit(active) {
                if (!active.length) return scrollbar.hide();
                scrollbar.css({left: active.offset().left, width: active.width()});
                fakecontent.width($(this).get(0).scrollWidth);
                fakecontent.height(1);
                delete lastScroll;
            }

            function onscroll() {
                var oldactive = active;
                active = find_active();
                if (oldactive.not(active).length) {
                    oldactive.unbind('scroll', update);
                }
                if (active.not(oldactive).length) {
                    active.scroll(update);
                }
                update();
            }

            var lastScroll;

            function scroll() {
                if (!active.length) return;
                if (scrollbar.scrollLeft() === lastScroll) return;
                lastScroll = scrollbar.scrollLeft();
                active.scrollLeft(lastScroll);
            }

            function update() {
                if (!active.length) return;
                if (active.scrollLeft() === lastScroll) return;
                lastScroll = active.scrollLeft();
                scrollbar.scrollLeft(lastScroll);
            }

            scrollbar.scroll(scroll);

            onscroll();
            $(window).scroll(onscroll);
            $(window).resize(onscroll);
        });

        $(document).on('click','#view_chat .message-chat',function () {

            let page_id = $('.chat-page_id').val();
            let sender_id = $('.chat-sender_id').val();
            let token = $('.chat-token').val();

            if(page_id && sender_id && token){
                $('#view_chat .chat-ajax').hide();
                $('#view_chat .chatApplication').show();
                getMessage(page_id,sender_id,token);
            } else {
                alertify.warning('Không có đoạn hội thoại !');
            }
        })
        $(document).on('click','#view_chat .sale-note',function () {
            $('#view_chat .chat-ajax').show();
            $('#view_chat .chatApplication').hide();
        })
        var thisCallBack ='';
        $(document).on('click', '.call-back', function () {
             thisCallBack = $(this);
            $.ajax({
                url: '/ajax/tasks/' + $(this).data('id'),
                method: 'GET',
                success: function (data) {
                    let abc = data.description.replaceAll("--", '\n');
                    let link = '/customers/'+data.customer.id;
                    $('#name').val(data.name).change();
                    $("a[href]").attr("href",link);
                    $('.modal-body .name-customer').html(data.customer.full_name).change();
                    $('.modal-body .phone-customer').val(data.customer.phone).change();
                    $('.modal-body #user_id').val(data.user.full_name).change();
                    $('.modal-body #date_from').val(data.date_from).change();
                    $('.modal-body #time_from').val(data.time_from).change();
                    $('.modal-body #time_to').val(data.time_to).change();
                    $('.modal-body #description').html(abc).change();
                    $('.checkTask').data('id',data.id);
                    $('.modal-task').modal('show');
                    $('.checkTask').prop("checked",false);
                }
            })
        })
        $(document).on('change', '.checkTask', function () {
            let id =  $(this).data('id');
            $.ajax({
                url: '/ajax/tasks/' + id,
                method: 'PUT',
                data: {task_status_id: 3},
                success: function (data) {
                    $('.modal-task').modal('hide');
                    thisCallBack.remove();
                }
            });
        })

    </script>
    @include('message_fb.js_chat_app')

@endsection
