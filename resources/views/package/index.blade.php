@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{route('package.create') }}"><i
                                class="fa fa-plus-circle"></i> Tạo mới</a></div>
            </div>
            <div class="card-header">
                <input class="form-control name col-md-2" name="search" placeholder="Tìm kiếm" tabindex="1"
                       type="search">
                {{--<div class="col-md-2" style="font-size: 16px;">--}}
                    {{--{!! Form::select('type', $category_pluck, null, array('class' => 'form-control type','data-placeholder'=>'Danh mục cha')) !!}--}}
                {{--</div>--}}
            </div>
            <div id="registration-form">
                @include('package.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        function searchCategory(data) {
            $.ajax({
                url: "{{ Url('package/') }}",
                method: "get",
                data: data
            }).done(function (data) {
                $('#registration-form').html(data);

            });
        }

        $(document).on('keyup', '.name', function () {
            const name = $('.name').val();
            const data = {
                search: name,
            };

            searchCategory(data)
        });

    </script>
@endsection
