@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('users.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control col-md-2 col-xs-12" name="search" placeholder="Search…" tabindex="1"
                       type="text" id="search">
                <div class="col-md-2 col-xs-12">
                    {!! Form::select('status',$status, null, array('class' => 'form-control header-search','placeholder'=>'Mối quan hệ ...')) !!}
                </div>
            </div>
            <div id="registration-form">
                @include('users.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('keyup', '#search', function (e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('users/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
        $(document).on('change', '.header-search', function () {
            var status = $(this).val();
            $.ajax({
                url: "{{ Url('users/') }}",
                method: "get",
                data: {status: status}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
