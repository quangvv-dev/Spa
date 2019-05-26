@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                {{--<div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('customers.create') }}"><i--}}
                                {{--class="fa fa-plus-circle"></i>Thêm mới</a></div>--}}
            </div>
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
            </div>
            <div id="registration-form">
                @include('order-details.ajax')
            </div>
        </div>
    </div>
@endsection
{{--@section('_script')--}}
    {{--<script type="text/javascript">--}}
        {{--$(document).on('keyup', '#search', function (e) {--}}
            {{--e.preventDefault();--}}
            {{--var search = $(this).val();--}}
            {{--$.ajax({--}}
                {{--url: "{{ Url('customers/') }}",--}}
                {{--method: "get",--}}
                {{--data: {search: search}--}}
            {{--}).done(function (data) {--}}
                {{--$('#registration-form').html(data);--}}

            {{--});--}}
        {{--});--}}
        {{--$(document).on('click', '.status', function () {--}}
            {{--var status = $(this).html();--}}
            {{--$.ajax({--}}
                {{--url: "{{ Url('customers/') }}",--}}
                {{--method: "get",--}}
                {{--data: {status: status}--}}
            {{--}).done(function (data) {--}}
                {{--$('#registration-form').html(data);--}}

            {{--});--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
