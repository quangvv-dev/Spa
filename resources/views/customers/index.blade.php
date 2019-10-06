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
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('group', $group, null, array('class' => 'form-control group','placeholder'=>'Chọn nhóm KH')) !!}
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
                            <span>` + data.customer.full_name + `</span>
                            </a></div>
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
                    html += `<div class="col" style="margin-bottom: 5px; padding: 10px;background: aliceblue;border-radius: 29px;">
                                <div class="info-avatar no-padd col-md-12">
                                    <div class="col-md-11"><p><a href="#" class="bold blue">` + item.user.full_name + `</a>
                                        <span><i class="fa fa-clock"> ` + item.created_at + `</i></span></p>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 5px; margin-bottom: 5px">` + item.messages + `</div>
                                </div>
                        </div>`;
                });

                $('.customer-chat').append(html);
                $('#view_chat').modal("show");
                $('.chat-save').attr('data-customer-chat-id', data.customer.id);
            });
        });

        $(document).on('click', '.chat-save', function (e) {
            e.preventDefault();
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
                    <div class="col-md-11"><p><a href="#" class="bold blue">` + data.group_comment.user.full_name + `</a>
                        <span><i class="fa fa-clock"> ` + data.group_comment.created_at + `</i></span></p>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px; margin-bottom: 5px">` + data.group_comment.messages + `</div></div>`;

                $('.chat-ajax').prepend(html);
            });

        });

        function searchAjax(data) {
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

        $(document).on('click', '.birthday_tab', function () {
            const birthday = $('.birthday_tab').data('original-title');
            $('#birthday_tab').val(birthday);
            let data = {birthday: birthday};

            searchAjax(data);
        });

        $(document).on('change keyup click', '.group, .telesales, #search, .btn_choose_time', function (e) {
            let target = $(e.target).parent();
            const group = $('.group').val();
            const telesales = $('.telesales').val();
            const search = $('#search').val();
            $('#search_value').val(search);
            $('#birthday_tab').val('');
            const data_time = $(target).find('.btn_choose_time').data('time');

            let data = {
                group: group,
                telesales: telesales,
                search: search,
                data_time: data_time,
            };

            searchAjax(data);
        });

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

        $(document).on('dblclick', '.description', function (e) {
            let target = $(e.target).parent();
            $(target).find('.description').empty();
            let id = $(this).data('id');
            let html = '';

            $.ajax({
                url: "ajax/customers/" + id,
                method: "get",
                data: {id: id}
            }).done(function (data) {

                html +=
                    '<textarea name="description" data-id="' + data.id + '" class="handsontableInput description-result" style="width: 291px; height: 59px; font-size: 14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255); resize: none; min-width: 291px; max-width: 291px; overflow-y: hidden;">' + data.description + '</textarea>';
                $(target).find(".description").append(html);
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
                        '<option value="' + item.id + '" class="category-op">' + item.name + '</option>';
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
                    '<select class="status-result form-control" data-id="' + data.customer_id + '" name="status_id">' +
                    '<option value="">' + "Chọn trạng thái" + '</option>';
                data.data.forEach(function (item) {
                    html +=
                        '<option value="' + item.id + '" >' + item.name + '</option>';
                });

                html += '</select>';
                $(target).find(".status-db").append(html);
            });
        });

        $(document).on('focusout, change', '.description-result, .status-result', function (e) {
            let target = $(e.target).parent();
            let description = $(target).find('.description-result').val();
            let status_id = $(target).find('.status-result').val();
            let id = $(this).data('id');

            $.ajax({
                url: "ajax/customers/" + id,
                method: "put",
                data: {
                    description: description,
                    status_id: status_id
                }
            }).done(function () {
                window.location.reload();
            });
        });

        $(document).on('change.select2', '.category-result', function (e) {
            let target = $(e.target).parent();
            let category_ids = $(target).find('.category-result').val();
            let id = $(this).data('id');

            $.ajax({
                url: "ajax/customers/" + id,
                method: "put",
                data: {
                    category_ids: category_ids
                }
            }).done(function () {

            });

        });

        $('body').not('.category-result').on('click', function () {
            if (!($('.category-result').parent().find('span.select2-container--focus').length) &&
                $('.category-result').parent().find('.select2-container--below .selection  .select2-selection--multiple').length
            ) {
                location.reload();
            }
        });

        $('.selectall').click(function () {
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

        $('#remove_selected_account').click(function () {
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

                html += `<textarea data-id=` + data.id +` class="handsontableInput" style="width: auto; height: 58px; font-size: 14px; overflow-y: hidden;"> `+ data.full_name+`</textarea>`;
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

                html += `<textarea data-id=` + data.id +` class="phone-result" style="width: auto; height: 58px; font-size: 14px; overflow-y: hidden;"> `+ data.phone+`</textarea>`;
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
            }).done(function () {
                window.location.reload();
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
            }).done(function () {
                window.location.reload();
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

        $('#permanently_delete_account').click(function () {
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

    </script>
@endsection
