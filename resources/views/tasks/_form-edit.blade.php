@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($task))
                {!! Form::model($task, array('url' => url('tasks/'.$task->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('tasks.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
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
                        <div class="form-group required {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                            {!! Form::select('type', $type, null, array('class' => 'form-control select2','placeholder'=>'Loại công việc', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('date_from') ? 'has-error' : '' }}">
                            {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                            {!! Form::text('date_from', null, array('class' => 'form-control','id'=>'update_date', 'data-toggle' => 'datepicker')) !!}
                            <span class="help-block">{{ $errors->first('date_from', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                         data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1')) !!}
                    </div>
                    <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                         data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2')) !!}
                    </div>
                </div>
                <div class="col row">

                </div>
                <div class="col row">
                    <div class="col-md-12 col-xs-12">
                        {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 6)) !!}
                    </div>
                </div>
                {{--<div class="col row" style="margin-top: 15px">--}}
                {{--<div class="col-md-12 mb10 task_file"><p class="fl pr10 mt5">Tài liệu đính kèm</p>--}}
                {{--<input type="file" name="file_document">--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="col row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Người thực hiện', array('class' => ' required')) !!}
                            {!! Form::select('user_id', $users2, null, array('class' => 'form-control select2', 'required' => true, 'placeholder'=>'Người thực hiện',)) !!}
                            <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('user_id2') ? 'has-error' : '' }}">
                            {!! Form::label('users', 'Người tham gia', array('class' => ' required')) !!}
                            @if(isset($task))
                                <select class="form-control select2" name="user_id2[]" multiple="multiple"
                                        data-placeholder="Chọn người tham gia">
                                    @foreach($users as $item)
                                        <option
                                            value="{{ $item->id }}" {{ isset($task) && in_array($item->id, $user) ? 'selected' : "" }}>{{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <span class="help-block">{{ $errors->first('user_id2', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required">
                            {!! Form::label('task_status_id', 'Trạng thái', array('class' => ' required')) !!}
                            {{--{!! Form::text('status_name',@$task->taskStatus->name, array('class' => 'form-control', 'required' => true,'readonly'=>true)) !!}--}}
                            {!! Form::select('task_status_id',$status, null, array('class' => 'form-control select2','id'=>'update_status')) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu</button>
            </div>

        </div>
        {{ Form::close() }}

    </div>
    </div>
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
        var status = $('#update_status').val();
        if (status != 1) {
            $('#update_status').attr('disabled', true)
        }
    </script>
@endsection
