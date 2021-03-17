@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('package/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('package.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên gói', array('class' => ' required')) !!}
                        {!! Form::text('name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('order_price') ? 'has-error' : '' }}">
                        {!! Form::label('order_price', 'Giá bán', array('class' => ' required')) !!}
                        {!! Form::text('order_price',@number_format($doc->order_price), array('class' => 'form-control price', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('order_price', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Giá nạp cho KH', array('class' => ' required')) !!}
                        {!! Form::text('price',@number_format($doc->price), array('class' => 'form-control price', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('price', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('package.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('form#fvalidate').validate({
                rules: {
                    name: 'required',
                },
                messages: {
                    name: "vui lòng nhâp tên danh mục",
                }
            });

            $('body').on('keyup', '.price', function (e) {
                let target = $(e.target).parent().parent();
                let price = $(target).find('.price').val();
                price = replaceNumber(price);
                $(target).find('.price').val(formatNumber(price));
            });
        })

    </script>
@endsection
