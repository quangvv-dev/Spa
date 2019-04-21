@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="nav-tabs-custom" id="setting_tabs">
            <ul class="nav nav-tabs" style="height: 40px">
                <li class="active pad">
                    <a href="#tab_1" data-toggle="tab" title="{{trans("status.account")}}">
                        <i class="fa fa-user">Nhóm khách hàng </i>
                    </a>
                </li>
                <li class="pad">
                    <a href="#tab_2" data-toggle="tab" title="{{trans("status.info")}}">
                        <i class="fa fa-image"> Nguồn khách hàng</i>
                    </a>
                </li>
                    <li class="pad">
                        <a href="#tab_3" data-toggle="tab" title="{{trans("status.shopinfo")}}">
                            <i class="fa fa-shopping-bag">Mối quan hệ</i>
                        </a>
                    </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @if (isset($doc))
                        {!! Form::model($doc, array('url' => route('status.update'), 'method' => 'put', 'files'=> true,'class'=>'fvalidate')) !!}
                    @else
                        {!! Form::open(array('url' => route('status.store'), 'method' => 'post', 'files'=> true,'class'=>'fvalidate')) !!}
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('name', trans("status.name"), array('class' => ' required')) !!}
                                {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                                {!! Form::label('username', trans("status.username"), array('class' => 'required')) !!}
                                {!! Form::text('username', null, array('class' => 'form-control','required' => true)) !!}
                                <span class="help-block">{{ $errors->first('username', ':message') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
{{--                        @if (isset($doc))--}}
{{--                            <div class="col-xs-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" id="show_pass" name="show_pass" class="check">--}}
{{--                                        <span class="label-text">{{ trans("status.change_password") }}</span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-xs-12 col-md-6">--}}
{{--                                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">--}}
{{--                                    <div class="checkbox">--}}
{{--                                        <label>--}}
{{--                                            {!! Form::checkbox('active', null,@$doc->active,array('class' => 'check')) !!}--}}
{{--                                            <span class="text">{{trans("status.active")}}</span>--}}
{{--                                        </label>--}}
{{--                                        <span class="help-block">{{ $errors->first('active', ':message') }}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group password_field {{ $errors->has('password') ? 'has-error' : '' }}">
                                {!! Form::label('password', trans("status.password"),array('class'=>empty($doc)?"required":'')) !!}
                                {!! Form::password('password', array('class' => 'form-control',empty($doc)?"required":'')) !!}
                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div
                                    class="form-group password_field {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                {!! Form::label('password_confirmation', trans("status.password_confirmation"),array('class'=>empty($doc)?"required":'')) !!}
                                {!! Form::password('password_confirmation', array('class' => 'form-control',empty($doc)?"required":'')) !!}
                                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
                            </div>
                        </div>

{{--                        <div class="col-xs-12">--}}
{{--                            <div class="imgupload">--}}
{{--                                <img class="imguploadfile" src="{{getAvatar(@$doc,'avatar')}}"/>--}}
{{--                                <a href="#" class="btn btn-default">{{ trans('form.select_image') }}--}}
{{--                                    <input type='file' onchange="readURL(this);" name="img_file" class="input_file_img"/>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    {{ Form::close() }}
                </div>

                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {!! Form::label('phone', trans("status.phone"), array('class' => ' required')) !!}
                                {!! Form::text('phone', null, array('class' => 'form-control', 'required' => true)) !!}
                                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                                {!! Form::label('email', trans("status.email"), array('class' => ' required')) !!}
                                {!! Form::text('email', null, array('class' => 'form-control', 'required' => true)) !!}
                                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="tab-pane" id="tab_3">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group required {{ $errors->has('name_shop') ? 'has-error' : '' }}">
                                    {!! Form::label('name_shop', trans("status.name_shop"), array('class' => ' required')) !!}
                                    {!! Form::text('name_shop', null, array('class' => 'form-control', 'required' => true)) !!}
                                    <span class="help-block">{{ $errors->first('name_shop', ':message') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <div class="form-group required {{ $errors->has('about') ? 'has-error' : '' }}">
                                    {!! Form::label('about', trans("status.about"), array('class' => ' required')) !!}
                                    {!! Form::text('about', null, array('class' => 'form-control', 'required' => true)) !!}
                                    <span class="help-block">{{ $errors->first('about', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group required {{ $errors->has('shop_address') ? 'has-error' : '' }}">
                                    {!! Form::label('shop_address', trans("status.shop_address"), array('class' => ' required')) !!}
                                    {!! Form::text('shop_address', null, array('class' => 'form-control', 'required' => true)) !!}
                                    <span class="help-block">{{ $errors->first('shop_address', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>
@endsection
