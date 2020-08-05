@extends('layout.app')
@section('content')
    <link href="{{asset('/laningpage/frontend/css/summernote-bs4.css')}}" rel="stylesheet"/>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('posts/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('posts.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">

                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : '' }}">
                        {!! Form::label('campaign_id','Danh mục cha', array('class' => 'required')) !!}
                        {!! Form::select('campaign_id',$campaigns, null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('campaign_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'SĐT tư vấn', array('class' => ' required')) !!}
                        {!! Form::text('phone',null, array('class' => 'form-control', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Tiêu đề tin', array('class' => ' required')) !!}
                        {!! Form::text('title',null, array('class' => 'form-control title', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group required {{ $errors->has('slug') ? 'has-error' : '' }}">
                        {!! Form::label('slug', 'Đường dẫn', array('class' => ' required')) !!}
                        {!! Form::text('slug',null, array('class' => 'form-control slug', 'readonly' => true)) !!}
                        <span class="help-block">{{ $errors->first('slug', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12">
                    <div class="form-group required {{ $errors->has('content') ? 'has-error' : '' }}">
                        {!! Form::label('content', 'Nội dung tin', array('class' => ' required')) !!}
                        {!! Form::textArea('content',null, array('class' => 'form-control js-summernote','id'=>'content','rows'=>6)) !!}
                    </div>
                    <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                </div>
            </div>
        </div>
        <div class="col bot">
            <button type="submit" class="btn btn-success">Lưu</button>
            {{--<a href="{{route('category.index')}}" class="btn btn-danger">Về danh sách</a>--}}
        </div>
        {{ Form::close() }}

    </div>
    </div>
@endsection
@section('_script')
    {{--<script>--}}
    {{--$(document).ready(function () {--}}
    {{--$('.title').change(function () {--}}
    {{--var Text = $(this).stringToSlug();--}}
    {{--// Text = Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');--}}
    {{--$(".slug").val(Text).change();--}}
    {{--})--}}
    {{--// $('form#fvalidate').validate({--}}
    {{--//     rules: {--}}
    {{--//         name: 'required',--}}
    {{--//     },--}}
    {{--//     messages: {--}}
    {{--//         name: "vui lòng nhâp tên danh mục",--}}
    {{--//     }--}}
    {{--// });--}}
    {{--// jQuery('.select2').select2({ //apply select2 to my element--}}
    {{--//     placeholder: "-Chọn sản phẩm-",--}}
    {{--//     allowClear: true--}}
    {{--// });--}}
    {{--})--}}
    {{--</script>--}}
    <script src="{{asset('/laningpage/frontend/js/codebase.core.min.js')}}"></script>
    <script src="{{asset('/laningpage/frontend/js/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('/laningpage/frontend/js/speakingurl.min.js')}}"></script>
    <script src="{{asset('/laningpage/frontend/js/jquery.stringtoslug.min.js')}}"></script>
    <script>
        $(document).ready(function () {
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
            // $('.title').change(function () {
            //     var Text = $(this).stringToSlug();
            //     console.log(Text,'text');
            //     // Text = Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
            //     $(".slug").val(Text).change();
            // })
            // $('form#fvalidate').validate({
            //     rules: {
            //         name: 'required',
            //     },
            //     messages: {
            //         name: "vui lòng nhâp tên danh mục",
            //     }
            // });
            // jQuery('.select2').select2({ //apply select2 to my element
            //     placeholder: "-Chọn sản phẩm-",
            //     allowClear: true
            // });
        })

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        $(function () {

            $('.js-summernote').summernote({
                minHeight: 400,
                followingToolbar: true,
                callbacks: {
                    onImageUpload: function (images) {
                        for (var i = 0; i < images.length; i++) {
                            var formData = new FormData();
                            formData.append('_token', csrfToken);
                            formData.append('image', images[i]);
                            formData.append('folder', 'images/posts');
                            $.ajax({
                                method: 'POST',
                                url: '/ajax/image/store',
                                contentType: false,
                                cache: false,
                                processData: false,
                                data: formData,
                                success: function (url) {
                                    $('.js-summernote').summernote('insertImage', '/' + url);
                                }
                            });
                        }
                    },
                    onMediaDelete: function (target) {
                        var url = target[0].getAttribute('src');
                        if (!url.includes('/images/posts', 0)) {
                            return;
                        }

                        var formData = new FormData();
                        formData.append('_token', csrfToken);
                        formData.append('url', url.replace('/', ''));
                        console.log(url.replace('/', ''), 'formdata');
                        $.ajax({
                            type: "POST",
                            url: "/ajax/image/destroy",
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            success: function (data) {
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection
