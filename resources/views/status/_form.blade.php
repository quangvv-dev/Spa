@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('status/'.$doc->id), 'method' => 'put', 'files'=> true,'class'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('status.store'), 'method' => 'post', 'files'=> true,'class'=>'fvalidate')) !!}
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
                @endif
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        {!! Form::label('type','Danh mục', array('class' => 'required')) !!}
                        {!! Form::select('type',$types_pluck, null, array('class' => 'form-control','required' => true)) !!}
                        <span class="help-block">{{ $errors->first('type', ':message') }}</span>
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
