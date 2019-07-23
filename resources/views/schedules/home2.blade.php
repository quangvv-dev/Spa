@extends('layout.app')

<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}' rel='stylesheet'/>
<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}' rel='stylesheet' media='print'/>
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
                            @endswitch;margin-left: 3px">{{ $item }}
                        <input type="hidden" class="status-val" value="{{$k}}">
                    </button>
                @endforeach
                <div class="col-md-2">
                    {!! Form::text('date', null, array('class' => 'form-control','id'=>'search','autocomplete'=>'off','data-toggle'=>'datepicker','placeholder'=>'Ngày hẹn')) !!}
                </div>
                <a class="btn btn-primary date"><i class="fas fa-search" style="font-size: 20px;color: #e0dede"></i></a>
            </div>
            <div class="side-app">
                @include('schedules.ajax2')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script src='{{asset('assets/plugins/fullcalendar/moment.min.js')}}'></script>
    <script src='{{asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}'></script>
    <script>
        $(document).ready(function () {
            $('body').delegate('.status', 'click', function () {
                var val = $(this).find('.status-val').val();
                if (val != 6) {
                    var url = window.location.origin + '/schedules/?search=' + val;
                    // var url = "http://localhost/Spa/public/schedules/?search=" + val;
                    location.replace(url)
                } else {
                    var url = window.location.origin + '/schedules/';
                    // var url = "http://localhost/Spa/public/schedules/";
                    location.replace(url)
                }
            });
            $(document).on('click', '.date', function () {
                var val = $('#search').val();
                if (val) {
                    var url = window.location.origin + '/schedules/?date=' + val;
                    // var url = "http://localhost/Spa/public/schedules/?date=" + val;
                } else {
                    var url = window.location.origin + '/schedules/';
                    // var url = "http://localhost/Spa/public/schedules/";
                }
                location.replace(url)
            });

            $('#calendar1').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '{{$now}}',
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    // var title = prompt('Tạo lịch đi nào:');
                    // var eventData;
                    // if (title) {
                    //     eventData = {
                    //         title: title,
                    //         start: start,
                    //         end: end
                    //     };
                    //     $('#calendar1').fullCalendar('renderEvent', eventData, true); // stick? = true
                    // }
                    // $('#calendar1').fullCalendar('unselect');
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                        @foreach($docs as $item)
                    {
                        id: '{{$item->user_id}}',
                        title: '{{@$item->customer->full_name .' '.$item->note}}',
                        description: '{{$item->note}}',
                        @switch($item->status)
                                @case(1)
                        color: '#f39b4f',
                        @break
                                @case(2)
                        color: '#7384db',
                        @break
                                @case(3)
                        color: '#4cb354',
                        @break
                                @case(4)
                        color: '#dccf34',
                        @break
                                @case(5)
                        color: '#d03636',
                        @break
                                @endswitch
                        url: '{{url('schedules/'.$item->user_id)}}',
                        start: '{{$item->date.'T'.$item->time_from.':00'}}',
                        end: '{{$item->date.'T'.$item->time_to.':00'}}'
                    },
                        @endforeach
                    {
                        title: 'Meeting',
                        description: 'Anh quang đến triệt lông',
                        // url: 'http://google.com/',
                        start: '2018-08-12T10:30:00',
                        end: '2018-08-12T12:30:00'
                    },
                ]
            });
            $("body").delegate(".fc-content", "click", function () {
                // alert('test');
            });
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
            });
        });
    </script>
    {{--    <script src='{{asset('assets/js/fullcalendar.js')}}'></script>--}}

@endsection
