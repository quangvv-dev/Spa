@extends('layout.app')
<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a style="color: #ffffff" class="right btn btn-primary btn-flat" data-toggle="modal"
                                    data-target="#myModal"><i
                                class="fa fa-plus-circle"></i> Tạo mới</a></div>
            </div>

            <div class="card-header">
                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                {{--                <div class="col-md-2">--}}
                {{--                    {!! Form::select('type',$category_pluck, null, array('class' => 'form-control header-search','data-placeholder'=>'Danh mục cha')) !!}--}}
                {{--                </div>--}}
            </div>
            <div id="registration-form">
                @include('position.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('assets/js/util.js')}}"></script> <!-- util functions included in the CodyHouse framework -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.update').on('click', function () {
                var id = $(this).attr("data-id");
                var link = 'position/edit/' + id;
                $.ajax({
                    url: window.location.origin + '/' + link,
                    // url: "http://localhost/Spa/public/" + link,
                    method: "get",
                }).done(function (data) {
                    // console.log(data, data['date'])
                    $('#update_id').val(data['id']);
                    $('#update_name').val(data['name']);
                });
            })
        })
    </script>
@endsection
