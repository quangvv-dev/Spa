@extends('layout.app')

<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}' rel='stylesheet'/>
<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}' rel='stylesheet' media='print'/>
<style>
    .container {
        max-width: 90% !important;
    }
</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>
            <div class="card-header">
                @foreach($color as $k => $item)
                    <button class="status btn white account_relation position"
                            style="background: @switch($k)
                            @case(1)
                            {{'#f39b4f'}}
                            @break
                            @case(2)
                            {{'#7384db'}}
                            @break
                            @case(3)
                            {{'#4cb354'}}
                            @break
                            @case(4)
                            {{'#dccf34'}}
                            @break
                            @case(5)
                            {{'#d03636'}}
                            @break
                            @case(6)
                            {{'#63cff9'}}
                            @break
                            @endswitch;margin-left: 3px">{{ $item }}
                        <input type="hidden" class="status-val" value="{{$k}}">
                    </button>
                @endforeach
                <div class="col-md-2">
                    {!! Form::text('date', null, array('class' => 'form-control','id'=>'search','autocomplete'=>'off','data-toggle'=>'datepicker','placeholder'=>'Ngày hẹn')) !!}
                </div>
                <a class="btn btn-primary date"><i class="fas fa-search" style="font-size: 20px;color: #e0dede"></i></a>
                <div class="col-md-2">
                    {!! Form::select('person_action',@$staff2, $user, array( 'id'=>'person_action','class' => 'form-control','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('customer_plus', $customer, array( 'id'=>'customer_plus','class' => 'form-control','placeholder'=>'SĐT khách hàng')) !!}
                </div>
            </div>
            <div class="side-app">
                @include('schedules.ajax2')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).ready(function () {
            $('.page-title').hide();
            $('.breadcrumb').hide();
            $('body').delegate('.status', 'click', function () {
                // $('.spin').show();
                var val = $(this).find('.status-val').val();
                if (val != 6) {
                    var url = window.location.origin + '/schedules/?search=' + val;
                    location.replace(url)
                } else {
                    var url = window.location.origin + '/schedules/';
                    location.replace(url)
                }
                // $.ajax({
                //     url: window.location.origin + '/' + 'schedules',
                //     method: "get",
                //     data: {
                //         search: val,
                //     }
                // }).done(function (data) {
                //     $('#calendar1').html(data);
                //     $('.spin').hide();
                // });
            });
            $(document).on('change', '#search', function () {
                $('.spin').show();
                var val = $(this).val();
                if (val) {
                    var url = window.location.origin + '/schedules/?date=' + val;
                } else {
                    var url = window.location.origin + '/schedules/';
                }
                location.replace(url)
                // $.ajax({
                //     url: window.location.origin + '/' + 'schedules',
                //     method: "get",
                //     data: {
                //         date: val,
                //     }
                // }).done(function (data) {
                //     $('#calendar1').html(data);
                //     $('.spin').hide();
                // });
            });
            $(document).on('change', '#person_action', function () {
                var val = $(this).val();
                if (val != 0) {
                    var url = window.location.origin + '/schedules/?user=' + val;
                } else {
                    var url = window.location.origin + '/schedules/';
                }
                location.replace(url)
            });

            $(document).on('change', '#customer_plus', function () {
                var val = $(this).val();
                if (val != 0) {
                    var url = window.location.origin + '/schedules/?customer=' + val;
                } else {
                    var url = window.location.origin + '/schedules/';
                }
                location.replace(url)
            });

            $("body").delegate(".fc-content", "click", function () {
                // alert('test');
            });
            $('[data-toggle="datepicker"]').datepicker({
                format: 'dd-mm-yyyy',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>

@endsection
