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
                <div class="col-xs-12 col-md-3">
                    <select id="branch" name="branch_id" class="form-control">
                        <option value="">Tất cả chi nhánh</option>
                        @forelse($branchs as $k => $item)
                            <option value="{{$k}}">{{$item}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-xs-12 col-md-3">
                    <select id="branch" name="branch_id" class="form-control">
                        <option value="">Tất cả chi nhánh</option>
                        @forelse($branchs as $k => $item)
                            <option value="{{$k}}">{{$item}}</option>
                        @empty
                        @endforelse
                    </select>
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
        $(document).on('change', '#branch', function () {
            var branch = $(this).val();
            $.ajax({
                url: "{{ Url('users/') }}",
                method: "get",
                data: {branch_id: branch}
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        });
    </script>
@endsection
