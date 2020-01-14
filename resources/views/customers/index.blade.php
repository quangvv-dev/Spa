@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <style>
        .dropdown-toggle::after {
            display: none;
        }

        .table-vcenter td, .table-vcenter th {
            border-left: 1px solid #e7effc;
        }
    </style>
    <!-- anheasy -->
    <style>
        .table-ajax table {
            min-width: auto !important;
            width: auto !important;
        }

        .search-box,
        .filter-box {
            z-index: 999;
            background: #FFF;
        }

        .searchbox-sticky {
            position: sticky;
            top: 63px;
            left: 0;
        }

        .filterbox-sticky {
            position: sticky;
            top: calc(63px + 57px);
            left: 0;
        }
    </style>
    <script src="https://unpkg.com/floatthead@2.1.4/dist/jquery.floatThead.min.js"></script>
    <!-- end anheasy -->
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header search-box">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('group', $group, null, array('class' => 'form-control group','placeholder'=>'Chọn nhóm DV')) !!}
                </div>
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('telesales', $telesales, null, array('class' => 'form-control telesales','placeholder'=>'Chọn nhân viên')) !!}
                </div>
                <div class="col relative">
                    <a title="Upload Data" style="position: absolute;right: 26%" class="btn" href="#"
                       data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-upload"></i></a>
                    <a title="Download Data" style="position: absolute;right: 21%" class="btn"
                       href="{{url('customer-export')}}">
                        <i class="fas fa-download"></i></a>
                    <a class="right btn btn-primary btn-flat" href="{{ route('customers.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a>
                </div>
            </div>
            <div id="registration-form">
                @include('customers.ajax')
            </div>
            @include('customers.modal')
            @include('customers.modal-update-relation')
            <input type="hidden" id="status">
            <input type="hidden" id="invalid_account">
            <input type="hidden" id="group">
            <input type="hidden" id="telesales">
            <input type="hidden" id="search_value">
            <input type="hidden" id="btn_choose_time">
            <input type="hidden" id="birthday_tab">
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', '.view_modal', function () {
            $('.customer-chat').empty();
            const id = $(this).data('customer-id');

            $.ajax({
                url: "{{ Url('/group_comments/') }}" + '/' + id,
                method: "get",
            }).done(function (data) {
                let html = '';
                html += `<div class="row" style="padding-bottom: 10px;">
                    <div class="chat-flash col-md-12">
                        <div class="white-space" style="display: flex; align-items: center;">
                            <img width="50" height="50" class="fl mr10 a40 border"
                                 src="{{asset('default/no-image.png')}}" style="border-radius:100%">
                            <a class="bold blue uppercase user-name" href="javascript:void(0);" style="margin-left: 5px">
                            <span>` + (data.customer.fb_name ? data.customer.fb_name : data.customer.full_name) + `</span><br>
                            <span>@` + (data.customer.telesale ? data.customer.telesale.full_name : "") + `</span>
                            </a>
                        </div>
                       <div class="mt10 pb10" style="height:86px">
                            <div class="col-md-10 info-avatar border padding5 last_contacthover box_last">
                            <p><i class="fa fa-user mr5" style="color: black;"></i> ` + data.customer.full_name + `
                                <i class="fa orange fa-star" aria-hidden="true" style="color: orange;"></i>
                            </p>
                            <p class="mt10"><i class="fa fa-phone mr10" style="color: black;" aria-hidden="true"></i><a class="__clickToCall blue" data-contact-id="5678"
                                                          rel="tooltip" data-original-title="Click để gọi"
                                                          data-placement="right" data-phone="0977766139" data-flag="1"
                                                          data-type="crm"> ` + data.customer.phone + `</a></p>
                            <p class="mt10 white-space"><i class="icon-envelope mr5"></i></p></div>
                        </div>
                         <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
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
                    </div>
                </div>
                <div class="chat-ajax" >

                </div>`;

                data.group_comments.forEach(function (item) {
                    html += `<div class="col comment-fast" style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;">
                                <div class="no-padd col-md-12">
                                    <div class="col-md-11"><p><a href="#" class="bold blue">` + (item.user ? item.user.full_name : "") + `</a>
                                        <span><i class="fa fa-clock"> ` + item.created_at + `</i></span></p>
                                    </div>` +
                        (data.id_login == item.user_id ? `<div class="tools-msg edit_area" style="position: absolute; right: 10px; top: 5px">
                                        <a data-original-title="Sửa"  rel="tooltip" style="margin-right: 5px">
                                            <i class="fas fa-edit btn-edit-comment" data-id="` + item.id + `"></i>
                                        </a>
                                        <a data-original-title="Xóa" rel="tooltip">
                                            <i class="fas fa-trash-alt btn-delete-comment" data-id="` + item.id + `"></i>
                                        </a>
                                    </div>` : "") +
                        `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px">` + item.messages + `
                                    </div>
                                </div>
                            </div>`;
                });
                $(".status-result").val(data.customer.status_id).change();
                $('.customer-chat').append(html);
                $('#view_chat').modal("show");
                $('.chat-save').attr('data-customer-chat-id', data.customer.id);
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
                    `<div class="col-md-12 comment" style="margin-top: 5px; margin-bottom: 5px">` + data.group_comment.messages + `</div>
                    </div>
                    </div>`;

                $('.chat-ajax').prepend(html);
            });

        });

        $(document).on('click', '.btn-edit-comment', function (e) {
            const target = $(e.target).parent().parent().parent();
            const group_comment_id = $(this).data('id');

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
            const target = $(e.target).parent().parent().parent().parent();

            const messages = $(target).find('.message').val();
            const id = $(target).find('.message').data('id');

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
            const target = $(e.target).parent().parent().parent();
            const group_comment_id = $(this).data('id');

            const result = confirm("Bạn muốn xoá tin nhắn này?");
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
            const status = $(this).data('name');
            $('#status').val(status);
            $('#birthday_tab').val('');
            let data = {
                status: status
            };

            searchAjax(data);
        });

        $(document).on('click', '.limiting', function () {
            const limit = $(this).data('limit');
            $('#birthday_tab').val('');
            let data = {
                limit: limit
            };

            searchAjax(data);
        });

        $(document).on('click', '.birthday_tab', function () {
            const birthday = $('.birthday_tab').data('original-title');
            $('#birthday_tab').val(birthday);
            let data = {birthday: birthday};

            searchAjax(data);
        });

        $(document).on('click', '.btn_choose_time', function (e) {
            let target = $(e.target).parent();
            const data_time = $(target).find('.btn_choose_time').data('time');
            $('#birthday_tab').val('');
            $('#btn_choose_time').val(data_time);
            const search = $('#search_value').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();
            let data = {
                data_time: data_time,
                group: group,
                telesales: telesales,
                search: search,
            };

            searchAjax(data);
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

        $(document).on('change', '.group, .telesales', delay(function () {
            const group = $('.group').val();
            const telesales = $('.telesales').val();
            const search = $('#search_value').val();
            $('#group').val(group);
            $('#telesales').val(telesales);
            $('#birthday_tab').val('');
            const data_time = $('#btn_choose_time').val();

            let data = {
                group: group,
                telesales: telesales,
                data_time: data_time,
                search: search
            };
            searchAjax(data);

        }, 500));

        $(document).on('keyup', '#search', delay(function () {
            const search = $('#search').val();
            $('#search_value').val(search);
            $('#birthday_tab').val('');
            const data_time = $('#btn_choose_time').val();
            const group = $('#group').val();
            const telesales = $('#telesales').val();

            let data = {
                search: search,
                data_time: data_time,
                group: group,
                telesales: telesales,
            };
            searchAjax(data);

        }, 500));

        $(document).on('click', '.invalid_account', function (e) {
            let target = $(e.target).parent();
            const invalid_account = $(target).find('.invalid_account').data('invalid');
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

        $(document).on('dblclick', '.description-cus', function (e) {
            let target = $(e.target).parent();
            $(target).find('.description-cus').empty();
            let id = $(this).data('id');
            let html = '';

            $.ajax({
                url: "ajax/customers/" + id,
                method: "get",
                data: {id: id}
            }).done(function (data) {

                html +=
                    '<textarea name="description" data-id="' + data.id + '" class="description-result-customer" style="width: 291px; height: 59px; font-size: 14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255); resize: none; min-width: 291px; max-width: 291px; overflow-y: hidden;">' + (data.description ? data.description : '') + '</textarea>';
                $(target).find(".description-cus").append(html);
            });
        });

        $(document).on('dblclick', '.category-db', function (e) {
            let target = $(e.target).parent();
            $(target).find('.category-db').empty();
            const id = $(this).data('id');
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
        $(document).on('focusout', '.description-result-customer', function (e) {
            let target = $(e.target).parent();
            let description = $(target).find('.description-result-customer').val();
            let id = $(this).data('id');

            $.ajax({
                url: "ajax/customers/" + id,
                method: "put",
                data: {
                    description: description,
                }
            }).done(function (data) {
                $(target).parent().find(".description-cus").empty();
                $(target).parent().find(".description-cus").html(data.description);
            });
        });

        $('body').not('.category-result').on('click', function (e) {
            if (!($('.category-result').parent().find('span.select2-container--focus').length) &&
                $('.category-result').parent().find('.select2-container--below .selection  .select2-selection--multiple').length
            ) {
                let category_ids = $(e.target).parent().find('.category-result').val();
                let id = $(e.target).parent().find('.category-result').data('id');

                $.ajax({
                    url: "ajax/customers/" + id,
                    method: "put",
                    data: {
                        category_ids: category_ids
                    }
                }).done(function (data) {
                    const blkstr = $.map(data.categories, function (val) {
                        const str = val.name;
                        return str;
                    }).join(", ");

                    $('.category-result').parent().parent().find('.category-db').html(blkstr);
                });
            }
        });

        $(document).on('click', '.selectall', function () {
            if ($(this).hasClass('active')) {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
                $(this).html('Chọn tất cả');
                $(this).removeClass('active');

            } else {
                $(this).addClass('active');
                $(':checkbox').each(function () {
                    this.checked = true;
                });
                $(this).html('Bỏ chọn tất cả');
            }
        });

        $(document).on('click', '#remove_selected_account', function () {
            const id = $('td .myCheck:checked');
            const ids = [];
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
            let pages = $(this).attr('href').split('page=')[1];
            const group = $('.group').val();
            const telesales = $('.telesales').val();
            const search = $('#search_value').val();
            let status = $('#status').val();
            let invalid_account = $('#invalid_account').val();
            let btn_choose_time = $('#btn_choose_time').val();
            const birthday = $('#birthday_tab').val();
            $.ajax({
                url: '{{ url()->current() }}',
                method: "get",
                data: {
                    page: pages,
                    group: group,
                    telesales: telesales,
                    invalid_account: invalid_account,
                    search: search,
                    status: status,
                    data_time: btn_choose_time,
                    birthday: birthday
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
            const id = $('td .myCheck:checked');
            const ids = [];
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
            const id = $('td .myCheck:checked');
            const ids = [];
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
        // anheasy
        $('.table-responsive .table-primary').floatThead({
            top: 183,
            scrollContainer: function ($table) {
                return $table.closest('');
            },
            position: 'absolute'
        });
        $('.table-ajax .table-primary').floatThead({
            top: 183,
            position: 'absolute'
        });
        $(window).on("scroll", function (e) {
            if ($(window).scrollTop() >= 150) {
                $('.search-box').addClass('searchbox-sticky');
                $('.filter-box').addClass('filterbox-sticky');
            } else {
                $('.search-box').removeClass('searchbox-sticky');
                $('.filter-box').removeClass('filterbox-sticky');
            }
        });
        // end anheasy

        $(document).on('click', '#change_relations', function () {
            $('#updateRelation').modal("show");
        });

        $(document).on('click', '.update-multiple-status', function () {
            const id = $('td .myCheck:checked');
            const ids = [];
            const status_id = $('.status-customer').val();
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
        })

        $(document).on('change', '.telesales-result', function (e) {
            let target = $(e.target).parent();
            const telesales_id = $(target).find('.telesales-result').val();
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
    </script>
@endsection
