@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
                    <a title="Download Data" style="position: absolute;right: 16%" class="btn" href="{{route('product.export')}}">
                        <i class="fas fa-download"></i></a>
                    <a title="Upload Data" class="btn" style="position: absolute;right: 13%" href="#" data-toggle="modal" data-target="#myModalImport">
                        <i class="fas fa-upload"></i></a>
                    <a class="right btn btn-primary btn-flat" href="{{request()->url().'/create' }}"><i
                                class="fa fa-plus-circle"></i> Tạo mới</a>
                </div>
            </div>
            <form>
                <div class="card-header" style="align-items: flex-end">
                    <input class="form-control header-search col-2" name="search" placeholder="Tìm kiếm…" tabindex="1"
                           type="search" value="{{@$input['search']}}">
                    <div class="col-md-2" style="font-size: 16px;">
                        {!! Form::select('trademarks', $trademarks, @$input['trademark'], array('class' => 'form-control trademarks','placeholder'=>'--Nhà cung cấp--')) !!}
                    </div>
                    <div class="col-md-2" style="font-size: 16px;">
                        {!! Form::select('category', $category_pluck, @$input['category'], array('class' => 'form-control select2 category','data-placeholder'=>'--Danh mục cha--')) !!}
                    </div>
                </div>
            </form>
            <div class="header-search">
                @include('product.ajax')
                @include('product.modal')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')

    <script type="text/javascript">


        $(document).on('change', '.category', function (e) {
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('products/') }}",
                method: "get",
                data: {category_id: id}
            }).done(function (data) {
                $('.table-responsive').html(data);

            });
        })

        $(document).on('change', '.trademarks', function (e) {
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('products/') }}",
                method: "get",
                data: {trademark: id}
            }).done(function (data) {
                $('.table-responsive').html(data);

            });
        })

        $(document).on('keyup', '.header-search', function (e) {
            e.preventDefault();
            var search = $(this).val();
            $.ajax({
                url: "{{ Url('products/') }}",
                method: "get",
                data: {search: search}
            }).done(function (data) {
                $('.table-responsive').html(data);

            });
        });
    </script>
@endsection
