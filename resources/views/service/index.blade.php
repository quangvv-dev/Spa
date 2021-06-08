@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
                    @if(\Request::is('products'))
                    <a title="Download Data" style="position: absolute;right: 16%" class="btn" href="{{route('product.export')}}">
                        <i class="fas fa-download"></i></a>
                    <a title="Upload Data" class="btn" style="position: absolute;right: 13%" href="#" data-toggle="modal" data-target="#myModalImport">
                        <i class="fas fa-upload"></i></a>
                    @endif
                    <a class="right btn btn-primary btn-flat" href="{{request()->url().'/create' }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a>
                </div>
            </div>
            <div class="card-header">
                <input class="form-control header-search col-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                <div class="col-md-2" style="font-size: 16px;">
                    {!! Form::select('category', $category_pluck, null, array('class' => 'form-control','data-placeholder'=>'Danh mục cha')) !!}
                </div>
            </div>
            <div class="header-search">
                @include('service.ajax')
{{--                @include('service.modal')--}}
            </div>
            <!-- table-responsive -->
        </div>
        {{--        @include('status._form')--}}
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('keyup', '.header-search', function (e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('services/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('.table-responsive').html(data);

            });
        });
    </script>
@endsection
