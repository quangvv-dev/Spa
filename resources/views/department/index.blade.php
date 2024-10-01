@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title linear-text fs-24">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('department.create') }}"><i
                                class="fa fa-plus-circle"></i> Tạo mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                <div class="col-md-2">
                    {{--<select class="form-control header-search" name="parent_id">--}}
                        {{--<option value="" disabled selected>Trực thuộc</option>--}}
                        {{--{!! $departments !!}--}}
                    {{--</select>--}}
                    {!! Form::select('type',$category_pluck, null, array('class' => 'form-control header-search','placeholder'=>'Trực thuộc')) !!}
                </div>
            </div>
            <div id="registration-form">
                @include('department.ajax')
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
                url: "{{ Url('department/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
        $(document).on('change', '.header-search', function () {
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('department/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
