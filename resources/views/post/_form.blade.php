@extends('layout.app')
@section('content')
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
                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Tiêu đề form', array('class' => ' required')) !!}
                        {!! Form::text('title',null, array('class' => 'form-control title', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : '' }}">
                        {!! Form::label('campaign_id','Chiến dịch', array('class' => 'required')) !!}
                        {!! Form::select('campaign_id',$campaigns, null, array('class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('campaign_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('group') ? 'has-error' : '' }}">
                        {!! Form::label('group','Nhóm khách hàng', array('class' => 'required')) !!}
                        {!! Form::select('group[]',$category, null, array('class' => 'form-control select2','required'=>true,'multiple'=>true,'data-placeholder'=>'Chọn nhóm KH')) !!}
                        <span class="help-block">{{ $errors->first('group', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('sale_id') ? 'has-error' : '' }}">
                        {!! Form::label('sale_id','Nhân viên sale phụ trách', array('class' => 'required')) !!}
                        {!! Form::select('sale_id[]',$sale, null, array('class' => 'form-control select2','required'=>true,'multiple'=>true,'data-placeholder'=>'Chọn Sale')) !!}
                        <span class="help-block">{{ $errors->first('sale_id', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group {{ $errors->has('sale_id') ? 'has-error' : '' }}">
                        {!! Form::label('branch_id','Chi nhánh', array('class' => 'required')) !!}
                        {!! Form::select('branch_id',$branchs, null, array('class' => 'form-control select2','required'=>true,'placeholder'=>'Chọn chi nhánh')) !!}
                        <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="col bot">
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{route('posts.index')}}" class="btn btn-danger">Về danh sách</a>
        </div>
        {{ Form::close() }}

    </div>
    </div>
@endsection
{{--@section('_script')--}}
    {{--<script src="{{asset('/laningpage/frontend/js/codebase.core.min.js')}}"></script>--}}
    {{--<script src="{{asset('/laningpage/frontend/js/summernote-bs4.min.js')}}"></script>--}}
    {{--<script src="{{asset('/laningpage/frontend/js/speakingurl.min.js')}}"></script>--}}
    {{--<script src="{{asset('/laningpage/frontend/js/jquery.stringtoslug.min.js')}}"></script>--}}
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--$(".title").stringToSlug({--}}
                {{--setEvents: 'keyup keydown blur change',--}}
                {{--getPut: '.slug',--}}
                {{--space: '-',--}}
                {{--prefix: '',--}}
                {{--suffix: '',--}}
                {{--replace: '',--}}
                {{--AND: 'and',--}}
                {{--options: {},--}}
                {{--callback: false--}}
            {{--});--}}
            {{--// $('.title').change(function () {--}}
            {{--//     var Text = $(this).stringToSlug();--}}
            {{--//     console.log(Text,'text');--}}
            {{--//     // Text = Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');--}}
            {{--//     $(".slug").val(Text).change();--}}
            {{--// })--}}
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

        {{--var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");--}}
        {{--$(function () {--}}

            {{--$('.js-summernote').summernote({--}}
                {{--minHeight: 400,--}}
                {{--followingToolbar: true,--}}
                {{--callbacks: {--}}
                    {{--onImageUpload: function (images) {--}}
                        {{--for (var i = 0; i < images.length; i++) {--}}
                            {{--var formData = new FormData();--}}
                            {{--formData.append('_token', csrfToken);--}}
                            {{--formData.append('image', images[i]);--}}
                            {{--formData.append('folder', 'images/posts');--}}
                            {{--$.ajax({--}}
                                {{--method: 'POST',--}}
                                {{--url: '/ajax/image/store',--}}
                                {{--contentType: false,--}}
                                {{--cache: false,--}}
                                {{--processData: false,--}}
                                {{--data: formData,--}}
                                {{--success: function (url) {--}}
                                    {{--$('.js-summernote').summernote('insertImage', '/' + url);--}}
                                {{--}--}}
                            {{--});--}}
                        {{--}--}}
                    {{--},--}}
                    {{--onMediaDelete: function (target) {--}}
                        {{--var url = target[0].getAttribute('src');--}}
                        {{--if (!url.includes('/images/posts', 0)) {--}}
                            {{--return;--}}
                        {{--}--}}

                        {{--var formData = new FormData();--}}
                        {{--formData.append('_token', csrfToken);--}}
                        {{--formData.append('url', url.replace('/', ''));--}}
                        {{--console.log(url.replace('/', ''), 'formdata');--}}
                        {{--$.ajax({--}}
                            {{--type: "POST",--}}
                            {{--url: "/ajax/image/destroy",--}}
                            {{--contentType: false,--}}
                            {{--cache: false,--}}
                            {{--processData: false,--}}
                            {{--data: formData,--}}
                            {{--success: function (data) {--}}
                            {{--}--}}
                        {{--});--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
