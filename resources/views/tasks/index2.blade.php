@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/task.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12" style="margin-top: 30px; background-color: white">
        <div class="row">
            <div class="col-md-2 bor-r">
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
                                <div class="dropdown padding5-10 position"><span
                                            class="display uppercase">Công việc</span><a class="dropdown-toggle"
                                                                                                 data-toggle="dropdown"><s
                                                class="gf-icon-setting-g gf-icon-h02 reset fr"></s></a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"
                                        style="width: 100px; position: absolute; left: 150px; top: 20px; padding: 0px;">
                                            <li class="bor-bot choose-type1" data-value-type="qf1"><a href="#">Bạn thực hiện</a></li>
                                            <li class="bor-bot choose-type1" data-value-type="qf2"><a href="#">Phòng ban bạn</a></li>
                                            <li class="bor-bot choose-type1" data-value-type="qf3"><a href="#">Bạn tham gia</a></li>
                                    </ul>
                                </div>
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
            <div class="col-md-10">
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
                    <div class="row padding col-md-12">
                        <div class="padding5-10 position b-hover white-space pr20" >
                            <select class="form-control pl20 choose-type" style="font-size: 14px;">
                                <option>Chọn loại công việc</option>
                                @foreach($type as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="col-md-5 elfinder-button-search"><input type="text"--}}
                                                                            {{--placeholder="Tìm kiếm tên công việc"--}}
                                                                            {{--class="form-control search-task"></div>--}}
                        {{--<div class="col-md-3 pl10 position">--}}
                        {{--<div class="w100i ant-select ant-select-enabled">--}}

                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div id="registration-form">
                        @include('tasks.ajax')
                    </div>
                </div>
            </div>
        </div>
{{--//--}}
        <div class="modal-body">
            <div class="col row">
                <div class="col-xs-12 col-md-12">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên công việc', array('class' => ' required')) !!}
                        {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('project_id', 'Chọn phòng ban', array('class' => ' required')) !!}
                        {!! Form::select('department_id',$departments, null, array('class' => 'form-control select2','placeholder'=>'Chọn phòng ban')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                        {!! Form::select('type', $type, null, array('class' => 'form-control select2','placeholder'=>'Loại công việc', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('customer_id', 'Khách hàng liên quan', array('class' => ' required')) !!}
                        {!! Form::select('customer_id',$customers, null, array('class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col row">
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                        {!! Form::text('date_from', null, array('class' => 'form-control','id'=>'update_date', 'data-toggle' => 'datepicker')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                     data-align="top"
                     data-autoclose="true">
                    {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                    {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1')) !!}
                </div>
                <div class="col-md-1 no-padd tc mt5 font20"><i class="fa fa-arrow-right"></i></div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('date_to', 'Ngày hẹn(Tới)', array('class' => ' required')) !!}
                        {!! Form::text('date_to', null, array('class' => 'form-control','id'=>'update_date', 'data-toggle' => 'datepicker')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                     data-align="top"
                     data-autoclose="true">
                    {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                    {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2')) !!}
                </div>
                <div class="col-md-1 col-xs-12">
                    {!! Form::label('all_day', 'Cả ngày', array('class' => ' required')) !!}
                    {!! Form::checkbox('all_day', null, null) !!}
                </div>
            </div>
            <div class="col row">
                <div class="col-md-12 col-xs-12">
                    {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                    {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 6)) !!}
                </div>
            </div>
            <div class="col row" style="margin-top: 15px">
                <div class="col-md-12 mb10 task_file"><p class="fl pr10 mt5">Tài liệu đính kèm</p>
                    <input type="file" name="file_document">
                </div>
            </div>
            <div class="col row">
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('user_id', 'Người thực hiện', array('class' => ' required')) !!}
                        {!! Form::select('user_id', $users, null, array('class' => 'form-control select2', 'required' => true, 'placeholder'=>'Người thực hiện',)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('priority', 'Độ ưu tiên', array('class' => ' required')) !!}
                        {!! Form::select('priority', $priority, null, array('class' => 'form-control select2', 'required' => true ,'placeholder'=>'Độ ưu tiên',)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('users', 'Người tham gia', array('class' => ' required')) !!}
                        {!! Form::select('user_id2[]', $users, null, array('class' => 'form-control select2', 'multiple' => 'multiple' , 'data-placeholder'=>'Người tham gia')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div>
{{--//--}}
    @include('tasks._form')
@endsection
@section('_script')
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

        $(document).on('change', '.choose-type', function () {
            const type = $(this).val();
            const name = $('.search-task').val();
            const type1 = $('#task1').val();
            $('#type-task').val(type);
            search({
                type: type,
                name: name,
                type1: type1
            })
        });

        $(document).on('click', '.choose-type1', function () {
            const type1 = $(this).data('value-type');
            const name = $('.search-task').val();
            $('#task1').val(type1);
            const type = $('#type-task').val()
            search({
                type: type,
                name: name,
                type1: type1
            })
        });

        $(document).on('keyup', '.search-task', function () {
            const name = $('.search-task').val();
            const type = $('#type-task').val();
            const type1 = $('#task1').val();
            search({
                name: name,
                type: type,
                type1: type1
            })
        });

        function search(data) {
            $.ajax({
                url: "{{ Url('tasks/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }
        $('.update-status').click(function () {
            const id = $(this).data('id');

            swal({
                title: 'Bạn có muốn hoàn thành công việc ?',
                type: "success",
                showCancelButton: true,
                cancelButtonClass: 'btn-secondary waves-effect',
                confirmButtonClass: 'btn-danger waves-effect waves-light',
                confirmButtonText: 'OK'
            }, function () {
                $.ajax({
                    type: 'POST',
                    url: 'ajax/tasks/update',
                    data: {
                        id: id,
                    },
                    success: function () {
                        window.location.reload();
                    }
                })
            })
        });
    </script>
@endsection
