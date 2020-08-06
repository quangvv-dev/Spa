@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('posts.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            {{--<div class="card-header">--}}
                {{--<input class="form-control name col-md-2" name="search" placeholder="Tìm kiếm" tabindex="1"--}}
                       {{--type="search">--}}
            {{--</div>--}}
            <div id="registration-form">
                @include('post.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        function searchCategory(data) {
            $.ajax({
                url: "{{ Url('posts/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }

        $(document).on('keyup', '.name', function () {
            const name = $('.name').val();
            const type = $('.type').val();
            const data = {
                name: name,
                type: type
            };

            searchCategory(data)
        });
        $('.coppy').click(function () {
            $('#slug').focus();
            $('#slug').select();
            document.execCommand('copy');
        })
        //
        // $(document).on('change', '.type', function () {
        //     const name = $('.name').val();
        //     const type = $('.type').val();
        //
        //     const data = {
        //         name: name,
        //         type: type
        //     };
        //
        //     searchCategory(data)
        // });
    </script>
@endsection
