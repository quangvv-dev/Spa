@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('status/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('status.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên nhóm', array('class' => ' required')) !!}
                        {!! Form::text('name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                @if (isset($doc))
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('code', 'Mã nhóm', array('class' => ' required')) !!}
                            {!! Form::text('code',null, array('class' => 'form-control', 'required' => true,'readonly'=>true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('position', 'Vị trí', array('class' => ' required')) !!}
                            {!! Form::text('position',null, array('class' => 'form-control', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        {!! Form::label('type','Màu nền', array('class' => 'required')) !!}
                        {!! Form::select('type',$types_pluck, null, array('class' => 'form-control','data-placeholder'=>'Danh mục cha')) !!}
                        <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                    </div>
                </div>

                <div class="col-xs-12 col-md-2">
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        {!! Form::label('color','Màu nền', array('class' => 'required')) !!}
                        {{--                        {!! Form::color('color',$types_pluck, null, array('class' => 'form-control','data-placeholder'=>'Danh mục cha')) !!}--}}
                        <input type="color" name="color" value="{{isset($doc) && $doc->color ?$doc->color:''}}">
                        <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{route('status.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>

            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            $('form#fvalidate').validate({
                rules: {
                    name: 'required',
                    type: 'required',
                },
                messages: {
                    name: "vui lòng nhâp tên danh mục",
                    type: "vui lòng chọn thể loại",
                }
            });
        })
    </script>
@endsection
