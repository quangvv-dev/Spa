@extends('landipage.layout')
<link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('landipages/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('landipages.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Tiêu đề landipage', array('class' => ' required')) !!}
                        {!! Form::text('title',null, array('class' => 'form-control title', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('slug', 'Đường dẫn', array('class' => ' required')) !!}
                        {!! Form::text('slug',old('slug')?:null, array('class' => 'form-control slug', 'readonly' => true)) !!}
                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="col-6">
                        {!! Form::label('active', 'Kích hoạt', array('class' => ' required')) !!}
                        <input type="checkbox" name="active" value="1" {{@$doc->active == 1?'checked':''}}>
                    </div>
                    <div class="col">
                        {!! Form::label('position', 'Nổi bật', array('class' => ' required')) !!}
                        <input type="checkbox" name="position"  value="1" {{@$doc->position == 0?'':'checked'}}>
                    </div>
                </div>


                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        {!! Form::label('avatar', 'Ảnh đại diện') !!}
                        <div class="fileupload fileupload-{{isset($doc) ? 'exists' : 'new' }}"
                             data-provides="fileupload">
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px">
                                @if (isset($doc))
                                    <img src="{{ $doc->thumbnail }}" alt="image"/>
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
                <div class="col-xs-12 col-md-12">
                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('content', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('content',old('content')?:null, array('class' => 'form-control','row'=>8)) !!}
                        <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                    </div>
                </div>

            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('landipages.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
    <script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/laningpage/frontend/js/speakingurl.min.js')}}"></script>
    <script src="{{asset('/laningpage/frontend/js/jquery.stringtoslug.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('content', {
                // filebrowserBrowseUrl: '/browser/browse.php',
                // filebrowserUploadUrl: '/uploader/upload.php'
            });
            $(".title").stringToSlug({
                setEvents: 'keyup keydown blur change',
                getPut: '.slug',
                space: '-',
                prefix: '',
                suffix: '',
                replace: '',
                AND: 'and',
                options: {},
                callback: false
            });
            $('.title').change(function () {
                var Text = $(this).stringToSlug();
                console.log(Text, 'text');
                // Text = Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
                $(".slug").val(Text).change();
            })

            // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        })

    </script>
@endsection
