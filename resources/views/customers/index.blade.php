@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <style>
        .dropdown-toggle::after {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col relative">
                    <a title="Upload Data" style="position: absolute;right: 17%" class="btn" href="#"
                       data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-upload"></i></a>
                    <a title="Download Data" style="position: absolute;right: 13%" class="btn"
                       href="{{url('customer-export')}}">
                        <i class="fas fa-download"></i></a>
                    <a class="right btn btn-primary btn-flat" href="{{ route('customers.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('group', $group, null, array('class' => 'form-control group','placeholder'=>'Chọn nhóm KH')) !!}
                </div>
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('telesales', $telesales, null, array('class' => 'form-control telesales','placeholder'=>'Chọn nhân viên')) !!}
                </div>
            </div>
            <div class="card-header">
                <div class="display btn-group open">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true"
                            style="height: 39px; border-radius: 3px; margin-right: 10px"><i
                                class="fa fa-caret-down"></i></button>
                    <ul class="dropdown-menu">
                        <li class="pd5" id="search"><a class="invalid_account" data-invalid="1"
                                                       data-icon-class="fa fa-trash">
                                <span class="pr10"></span> Đang sử dụng </a>
                        </li>
                        <li class="pd5"><a class="invalid_account" data-invalid="0"
                                           data-icon-class="fa fa-dot-circle-o"> <span class="pr10"><i
                                            class="fa fa-dot-circle-o" aria-hidden="true"></i></span> Đã xoá </a>
                        </li>
                    </ul>
                </div>
                <div class="display btn-group" id="btn_tool_group" style="display: none;">
                    <button type="button" class="btn btn-default position dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"> Thao tác <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li class="dropdown_action"><a id="send_email">Gửi Email</a></li>
                        <li class="dropdown_action"><a id="send_sms">Gửi SMS</a></li>
                        <li class="dropdown_action"><a id="mark_as_potential">Tạo cơ hội</a></li>
                        <li class="dropdown_action"><a id="show_popup_task">Tạo công việc</a></li>
                        <li class="dropdown_action"><a id="show_group_type_account">Nhóm khách hàng</a></li>
                        <li class="dropdown_action"><a id="show_manager_account">Người phụ trách</a></li>
                        <li class="dropdown_action"><a data-toggle="modal" href="#change-account-viewers">Người xem</a>
                        </li>
                        <li class="dropdown_action"><a id="remove_selected_account">Xóa nhiều</a></li>
                        <li class="dropdown_action" id="restore_account" style="display: none;"><a>Khôi phục</a></li>
                        <li class="dropdown_action" id="permanently_delete_account" style="display: none;"><a>Xóa
                                hẳn</a></li>
                        <li class="dropdown_action"><a id="change_relations">Mối quan hệ</a></li>
                    </ul>
                </div>
                <div style="margin-left: 10px">
                    <button class="btn btn-default" style="height: 40px;">
                        <a href="{{ route('status.create') }}">
                            <i class="fa fa-plus font16"></i>
                        </a>
                    </button>
                </div>
                <div class="scrollmenu col-md-4">
                    @foreach(@$statuses as $k => $item)
                        <button class="status btn white account_relation position" data-name="{{$item->name}}"
                                style="background: {{$item->color ?:''}}">{{ $item->name }}<span
                                    class="not-number-account white">{{ $item->customers->count() }}</span></button>
                    @endforeach
                </div>
                <div class="col-md-5">
                    <div id="div_created_at_dropdown" style="float: right !important;"
                         class="display position pointer mt5 open" rel="tooltip"
                         data-placement="left" data-original-title="Thời gian tạo khách hàng"
                         style="padding-top:2px;padding-left:2px"><a class="dropdown-toggle" data-toggle="dropdown"
                                                                     aria-expanded="true"><i id="created_at_icon"
                                                                                             class="far fa-clock"
                                                                                             style="font-size:22px"></i></a>
                        <ul class="dropdown-menu pull-right tr">
                            <li class="created_at_item bor-bot tc"><a data-time="TODAY" class="btn_choose_time">Hôm
                                    nay</a>
                            </li>
                            <li class="created_at_item bor-bot tc"><a data-time="YESTERDAY" class="btn_choose_time">Hôm
                                    qua</a></li>
                            <li class="created_at_item bor-bot tc"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần
                                    này</a></li>
                            <li class="created_at_item bor-bot tc"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần
                                    trước</a></li>
                            <li class="created_at_item bor-bot tc"><a data-time="THIS_MONTH" class="btn_choose_time">Tháng
                                    này</a></li>
                            <li class="created_at_item bor-bot tc"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng
                                    trước</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @include('customers.modal')
            <div id="registration-form">
                @include('customers.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', '.status', function () {
            const status = $(this).data('name');
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {status: status}
            }).done(function (data) {
                $('.load').hide();
                $('#registration-form').html(data);
            });
        });

        $(document).on('click', '.invalid_account', function (e) {
            let target = $(e.target).parent();
            const invalid_account = $(target).find('.invalid_account').data('invalid');
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {invalid_account: invalid_account}
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        });

        $(document).on('change keyup click', '.group, .telesales, #search, .btn_choose_time', function (e) {
            let target = $(e.target).parent();
            const group = $('.group').val();
            const telesales = $('.telesales').val();
            const search = $('#search').val();
            const data_time = $(target).find('.btn_choose_time').data('time');
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {
                    group: group,
                    telesales: telesales,
                    search: search,
                    status: status,
                    data_time: data_time
                }
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        });

        $(document).on('dblclick', '.description', function (e) {
            var target = $(e.target).parent();
            $(target).find('.description').empty();
            var id = $(this).data('id');
            var html = '';

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
            var target = $(e.target).parent();
            $(target).find('.status-db').empty();
            var id = $(this).data('id');
            var html = '';

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

        $(document).on('select2:select', '.category-result', function (e) {
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
                $(document).on('click', function(evt) {
                    // if($(evt.target).closest('.category-op').length)
                    // if(()) {
                    //     window.location.reload();
                    // }
                });
                $("body").not($(".select2-results__option", ".select2-search__field")).click(function() {
                    alert('haha');
                });
            });
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
                console.log(ids);
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
    </script>
@endsection
