@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
{{--            <div class="card-header">--}}
{{--                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"--}}
{{--                       type="search">--}}
{{--            </div>--}}
            <div id="registration-form">
                @include('chart_revenue.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('keyup', '.header-search', function (e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('category/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
        $(document).on('change', '.header-search', function () {
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('category/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
