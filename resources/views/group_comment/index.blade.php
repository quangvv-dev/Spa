@extends('layout.app')
@section('content')
    <link href="{{asset('/assets/plugins/wysiwyag/richtext.min.css')}}" rel="stylesheet"/>
    <style>
        .content_msg{
            border-bottom: 1px solid #e7effc;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
                <div class="col" style="float: right">
                    <a class="right btn btn-primary btn-flat" href="{{ url('schedules/'.request()->segment(count(request()->segments())) ) }}"><i
                                class="fa fa-arrow-right"></i>Tới đặt lịch</a>
                </div>
            </div>
            {!! Form::open(array('url' => url('group_comments/'.request()->segment(count(request()->segments())) ), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            <div class="col-md-12">
                {!! Form::textArea('messages', null, array('class' => 'messages')) !!}
            </div>
            <br>
            <div class="col-md-12">
                <button style="float: right" type="submit" class="btn btn-primary">Gửi</button>
            </div>
            {{ Form::close() }}

            <div class="card-header">
                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
            </div>

            <div id="registration-form">
                @include('group_comment.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>

    <script type="text/javascript">

        $(function (e) {
            $('.messages').richText();
        });
    </script>
@endsection
