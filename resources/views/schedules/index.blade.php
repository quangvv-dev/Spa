@extends('layout.app')
<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col">
                    @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::ADMIN
                        ||\Illuminate\Support\Facades\Auth::user()->role == \App\Constants\UserConstant::WAITER)
                        <a style="margin-left: 0.5%;" class="right btn btn-primary btn-flat" href="{{ url('orders') }}"><i
                                    class="fa fa-arrow-right"></i>Tới tạo đơn hàng</a>
                    @endif
                    <a style="color: #ffffff" class="right btn btn-primary btn-flat" data-toggle="modal"
                       data-target="#myModal"><i class="fa fa-plus-circle"></i>Thêm mới</a>
                </div>
            </div>

            <div class="card-header">
                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
                {{--                <div class="col-md-2">--}}
                {{--                    {!! Form::select('type',$category_pluck, null, array('class' => 'form-control header-search','data-placeholder'=>'Danh mục cha')) !!}--}}
                {{--                </div>--}}
            </div>

            <div id="registration-form">
                @include('schedules.ajax')
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
                var link = 'schedules/edit/' + id;
                $.ajax({
                    url: window.location.origin + '/' + link,
                    // url: "http://localhost/Spa/public/" + link,
                    method: "get",
                }).done(function (data) {
                    $('#update_id').val(data['id']);
                    $('#update_date').val(data['date']);
                    $('#update_time1').val(data['time_from']);
                    $('#update_time2').val(data['time_to']);
                    $('#update_status').val(data['status']);
                    $('#update_note').val(data['note']);
                    $('#update_action').val(data['person_action']).change();
                    ;
                });
            })
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
            });
            $("#fvalidate").validate({
                rules: {
                    note: {
                        required: true
                    },
                    // date: {
                    //     required: true
                    // },
                    time_from: {
                        required: true
                    },
                    time_to: {
                        required: true
                    },
                },
                messages: {
                    note: "Không được để trống !!!",
                    // date: "Không được để trống !!!",
                    time_from: "Không được để trống !!!",
                    time_to: "Không được để trống !!!",
                },
            });
        })
    </script>
@endsection
