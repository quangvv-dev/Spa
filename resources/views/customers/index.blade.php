@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('customers.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div style="margin-left: 10px">
                    <button class="btn btn-default" style="height: 40px;">
                        <a href="{{ route('status.create') }}">
                            <i class="fa fa-plus font16"></i>
                        </a>
                    </button>
                </div>
                <div class="scrollmenu col-md-6">
                    @foreach(@$statuses as $k => $item)
                        <button class="status" style="background: {{$item->color ?:''}}">{{ $item->name }}</button>
                    @endforeach
                </div>
            </div>
            <div id="registration-form">
                <div class="load" style="text-align: center">
                    <i class="fa fa-spinner fa-spin " style="font-size:46px"></i>
                </div>
                @include('customers.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.load').hide();
        })
        $(document).on('keyup', '#search', function (e) {
            $('.load').show();
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('.load').hide();
                $('#registration-form').html(data);
            });
        });
        $(document).on('click', '.status', function () {
            $('.load').show();
            var status = $(this).html();
            $.ajax({
                url: "{{ Url('customers/') }}",
                method: "get",
                data: {status: status}
            }).done(function (data) {
                $('.load').hide();
                $('#registration-form').html(data);
            });
        });
    </script>
@endsection
