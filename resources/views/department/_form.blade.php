@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('department/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('department.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên phòng ban', array('class' => ' required')) !!}
                        {!! Form::text('name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            {!! Form::label('parent_id','Trực thuộc', array('class' => 'required')) !!}
                            <select class="form-control select2" name="parent_id" data-placeholder="Danh mục cấp cao nhất">
                                <option></option>
                                {!! $departments !!}
                            </select>
                        </div>
                    </div>
            </div>
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                        {!! Form::label('description','Mô tả', array('class' => 'required')) !!}
                        {!! Form::textArea('description',null, array('class' => 'form-control textarea-custom')) !!}
                        <span class="help-block">{{ $errors->first('parent_id', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{route('department.index')}}" class="btn btn-danger">Về danh sách</a>
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
                },
                messages: {
                    name: "vui lòng nhâp tên danh mục",
                }
            });
        })
    </script>
@endsection
