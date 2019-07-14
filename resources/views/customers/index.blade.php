@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col relative">
                    <a title="Upload Data" style="position: absolute;right: 13%" class="btn" href="#"
                       data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-upload"></i></a>
                    <a title="Download Data" style="position: absolute;right: 10%" class="btn"
                       href="{{url('customer-export')}}">
                        <i class="fas fa-download"></i></a>
                    <a class="right btn btn-primary btn-flat" href="{{ route('customers.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <div style="margin-left: 10px">
                    <button class="btn btn-default" style="height: 40px;">
                        <a href="{{ route('status.create') }}">
                            <i class="fa fa-plus font16"></i>
                        </a>
                    </button>
                </div>
                <div class="scrollmenu col-md-4">
                    @foreach(@$statuses as $k => $item)
                        <button class="status" style="background: {{$item->color ?:''}}">{{ $item->name }}</button>
                    @endforeach
                </div>

                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('group', $group, null, array('class' => 'form-control group','placeholder'=>'Chọn nhóm KH')) !!}
                </div>
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('telesales', $telesales, null, array('class' => 'form-control telesales','placeholder'=>'Chọn nhân viên')) !!}
                </div>
            </div>
            @include('customers.modal')
            <div id="registration-form">
                <div class="load" style="text-align: center">
                    <i class="fa fa-spinner fa-spin " style="font-size:46px"></i>
                </div>
                @include('customers.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.load').hide();
        });

        $(document).on('click', '.status', function () {
            $('.load').show();
            var status = $(this).html();
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {status: status}
            }).done(function (data) {
                $('.load').hide();
                $('#registration-form').html(data);
            });
        });

        $(document).on('change keyup', '.group, .telesales, #search', function () {
            $('.load').show();
            var group = $('.group').val();
            var telesales = $('.telesales').val();
            var search = $('#search').val();
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {
                    group: group,
                    telesales: telesales,
                    search: search,
                    status: status
                }
            }).done(function (data) {
                $('.load').hide();
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
                    '<input class="description-result form-control" data-id="'+data.id+'" name="description" value="'+ data.description +'">'
                ;
                $(target).find(".description").append(html);
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
                console.log(data.customer_id);
                html +=
                    '<select class="status-result form-control" data-id="'+data.customer_id+'" name="status_id">';
                data.data.forEach(function(item) {
                    html += '<option value="'+ item.id +'">' + item.name + '</option>';
                });

                html += '</select>';
                $(target).find(".status-db").append(html);
            });
        });

        $(document).on('focusout, change', '.description-result, .status-result', function (e) {
            var target = $(e.target).parent();
            var description = $(target).find('.description-result').val();
            var status_id = $(target).find('.status-result').val();
            var id = $(this).data('id');
            console.log(id);

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

        function myFunction() {
            var button = document.getElementById("button");
            if ($('td .myCheck:checked').length) {
                button.style.display = "block";
                selectall.style.display = "block";
            } else {
                button.style.display = "none";
                selectall.style.display = "none";
            }
        };

        $('.selectall').click(function(){
            if($(this).hasClass('active')) {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $(this).html('Chọn tất cả');
                $(this).removeClass('active');

            } else {
                $(this).addClass('active');
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $(this).html('Bỏ chọn tất cả');
            }
        });

        $('.deleteall').click(function () {
            var idss = $('td .myCheck:checked');
            var ids = [];
            $.each(idss, function(){
                ids.push($(this).data('id'));
            });
            swal({
                title: 'Bạn có chắc chắn xóa',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'OK'
            }).then(function(){
                $.ajax({
                    type: 'POST',
                    url: 'user/del',
                    dataType: "JSON",
                    data: {
                        "ids": ids,
                        "_token": '{{csrf_token()}}',
                    },
                    success:function (data) {
                        if(data){
                            location.href = "user";
                        }else{
                            swal(
                                'Cancelled',
                                "{{ __('message.cant_delete_item') }}",
                                'error'
                            )
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown)=>alert(errorThrown)
                })
            })
        });
    </script>
@endsection
