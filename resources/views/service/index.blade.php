@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{request()->url().'/create' }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header">
            <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                   type="search">
            </div>
            <div class="header-search">
                @include('service.ajax')
            </div>
            <!-- table-responsive -->
        </div>
        {{--        @include('status._form')--}}
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('keyup','.header-search',function(e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('services/') }}",
                method: "get",
                data:{search: search}
            }).done(function (data) {
                $('.table-responsive').html(data);

            });
        });
    </script>
@endsection
