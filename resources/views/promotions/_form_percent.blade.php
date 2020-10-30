@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>


            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab1" class="active" data-toggle="tab">Voucher theo %</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content" style="font-size: 15px;">
                        <div class="tab-pane active" id="tab1">
                            {!! Form::model($doc, array('url' => url('promotions/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                                        {!! Form::label('title', 'Tiêu đề voucher', array('class' => 'required')) !!}
                                        {!! Form::text('title', null, array('id' => 'title','class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group required {{ $errors->has('code') ? 'has-error' : '' }}">
                                        {!! Form::label('code', 'Mã khuyến mại', array('class' => 'required')) !!}
                                        {!! Form::text('code', null, array('class' => 'form-control','readonly'=>true)) !!}
                                        <span class="help-block">{{ $errors->first('code', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div
                                        class="form-group required {{ $errors->has('percent_promotion') ? 'has-error' : '' }}">
                                        {!! Form::label('percent_promotion', 'Khuyến mại theo %', array('class' => 'required')) !!}
                                        {!! Form::number('percent_promotion', null, array('class' => 'form-control','min'=>1,'max'=>100)) !!}
                                        <span
                                            class="help-block">{{ $errors->first('percent_promotion', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group required {{ $errors->has('min_price') ? 'has-error' : '' }}">
                                        {!! Form::label('min_price', 'Giá trị đơn hàng tối thiểu áp dụng (VNĐ)', array('class' => 'required')) !!}
                                        {!! Form::text('min_price', null, array('class' => 'form-control min_price')) !!}
                                        <span class="help-block">{{ $errors->first('min_price', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div
                                        class="form-group required {{ $errors->has('max_discount') ? 'has-error' : '' }}">
                                        {!! Form::label('max_discount', 'Số tiền tối đa được giảm (VNĐ)', array('class' => 'required')) !!}
                                        {!! Form::text('max_discount', null, array('id' => 'max_discount','class' => 'form-control')) !!}
                                        <span class="help-block">{{ $errors->first('max_discount', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div
                                        class="form-group required {{ $errors->has('current_quantity') ? 'has-error' : '' }}">
                                        {!! Form::label('current_quantity', 'Số lượng voucher', array('class' => 'required')) !!}
                                        {!! Form::text('current_quantity', null, array('class' => 'form-control current_quantity')) !!}
                                        <span
                                            class="help-block">{{ $errors->first('current_quantity', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group required {{ $errors->has('group') ? 'has-error' : '' }}">
                                        {!! Form::label('group', 'Trạng thái khác hàng áp dụng', array('class' => 'required')) !!}
                                        {!! Form::select('group', $status, null, array('class' => 'form-control select2 group','multiple'=>true,'data-placeholder'=>'Đối tượng áp dụng')) !!}
                                        <span class="help-block">{{ $errors->first('group', ':message') }}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="2">
                            </div>
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{route('promotions.index')}}" class="btn btn-danger">Trở lại</a>
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        $(document).on('.current_quantity', '.min_price', '#money_promotion', '#max_discount', function () {
            alert(1);
            let val = $(this).val();
            $(this).val(formatNumber(val)).change();
        });
    </script>
@endsection
