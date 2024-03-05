@extends('layout.app')
<link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('category/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('category.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Tên danh mục', array('class' => ' required')) !!}
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
                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                        {!! Form::label('parent_id','Danh mục cha') !!}
                        {!! Form::select('parent_id',$category_pluck, @$doc->parent_id, array('class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('parent_id', ':message') }}</span>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Giá công KTV') !!}
                        {!! Form::text('price',@number_format($doc->price), array('class' => 'form-control price', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('price', ':message') }}</span>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        {!! Form::label('avatar', 'Ảnh thumbnail') !!}
                        <div class="fileupload fileupload-{{isset($doc) ? 'exists' : 'new' }}"
                             data-provides="fileupload">
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px">
                                @if (isset($doc))
                                    <img src="{{ $doc->image }}" alt="image"/>
                                @endif
                            </div>
                            <div>
                                <button type="button" class="btn btn-default btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Chọn ảnh</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Thay đổi</span>
                                    <input type="file" name="image" accept="image/*" class="btn-default upload"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('category.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>

    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        $('body').on('keyup', '.price', function (e) {
            let price = $(this).val();
            price = formatNumber(price);
            $(this).val(price);
        })

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
