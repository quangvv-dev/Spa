@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($user))
                {!! Form::model($user, array('url' => url('users/'.$user->id), 'method' => 'put', 'files'=> true,'class'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('users.store'), 'method' => 'post', 'files'=> true,'class'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('full_name', 'Tên người dùng', array('class' => ' required')) !!}
                        {!! Form::text('full_name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                        {!! Form::text('phone',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email', array('class' => ' required')) !!}
                        {!! Form::email('email',null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                        {!! Form::label('birthday', 'Ngày sinh', array('class' => ' required')) !!}
                        <div class="wd-200 mg-b-30">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                {!! Form::text('birthday', null, array('class' => 'form-control fc-datepicker')) !!}
                            </div>
                        </div>
                    </div>
                    <span class="help-block">{{ $errors->first('birthday', ':message') }}</span>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('role') ? 'has-error' : '' }}">
                        {!! Form::label('role', 'Quyền', array('class' => ' required')) !!}
                        {!! Form::text('role', null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('role', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('gender') ? 'has-error' : '' }}">
                        {!! Form::label('gender', 'Giới tính', array('class' => ' required')) !!}
                        {!! Form::text('gender', null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('mkt_id') ? 'has-error' : '' }}">
                        {!! Form::label('mkt_id', 'Nhân viên MKT', array('class' => ' required')) !!}
                        {!! Form::text('mkt_id', null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('mkt_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', 'Giới tính', array('class' => ' required')) !!}
                        {!! Form::select('status', $status, null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('status', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('active') ? 'has-error' : '' }}">
                        {!! Form::label('active', 'Trạng thái dăng nhập', array('class' => ' required')) !!}
                        {!! Form::text('active', null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('active', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Mật khẩu', array('class' => ' required')) !!}
                        <input type="password" name="password" autocomplete="new-password" required class="form-control">
                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                        {!! Form::label('confirm_password', 'Nhập lại mật khẩu', array('class' => ' required')) !!}
                        <input type="password" name="confirm_password" autocomplete="new-password" required class="form-control">
                        <span class="help-block">{{ $errors->first('confirm_password', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('status.index')}}" class="btn btn-danger">Trở lại</a>
            </div>

            {{ Form::close() }}

        </div>
    </div>
@endsection
