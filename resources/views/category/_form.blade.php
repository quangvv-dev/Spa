@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('category/'.$doc->id), 'method' => 'put', 'files'=> true)) !!}
            @else
                {!! Form::open(array('url' => route('category.store'), 'method' => 'post', 'files'=> true)) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên nhóm', array('class' => ' required')) !!}
                        {!! Form::text('name',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('code', 'Mã nhóm', array('class' => ' required')) !!}
                        {!! Form::text('code',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                        {!! Form::label('parent_id','Danh mục cha', array('class' => 'required')) !!}
                        {!! Form::select('parent_id',$category_pluck, @$doc->parent_id, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('parent_id', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('status.index')}}" class="btn btn-danger">Trở lại</a>
            </div>
{{--@php dd($category_pluck) @endphp--}}
            {{ Form::close() }}

        </div>
    </div>
@endsection
