@extends('layout.app')
<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    .cd-schedule-modal__event-info {
        font-size: 16px;
        padding-top: 31px;
        padding-left: 5px;
    }
</style>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            <div class="card-header">
                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"
                       type="search">
            </div>
            <div id="registration-form">
                <div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
                    <div class="cd-schedule__timeline">
                        <ul>
                            <li><span>07:00</span></li>
                            <li><span>07:30</span></li>
                            <li><span>08:00</span></li>
                            <li><span>08:30</span></li>
                            <li><span>09:00</span></li>
                            <li><span>09:30</span></li>
                            <li><span>10:00</span></li>
                            <li><span>10:30</span></li>
                            <li><span>11:00</span></li>
                            <li><span>11:30</span></li>
                            <li><span>12:00</span></li>
                            <li><span>12:30</span></li>
                            <li><span>13:00</span></li>
                            <li><span>13:30</span></li>
                            <li><span>14:00</span></li>
                            <li><span>14:30</span></li>
                            <li><span>15:00</span></li>
                            <li><span>15:30</span></li>
                            <li><span>16:00</span></li>
                            <li><span>16:30</span></li>
                            <li><span>17:00</span></li>
                            <li><span>17:30</span></li>
                            <li><span>18:00</span></li>
                        </ul>
                    </div> <!-- .cd-schedule__timeline -->

                    <div class="cd-schedule__events">
                        <ul>
                            <li class="cd-schedule__group" data-date="{{$now}}">
                                <div class="cd-schedule__top-info"><span>Hôm Nay ( {{$now}} )</span></div>

                                <ul>
                                    @foreach($docs as $item)
                                        <li class="cd-schedule__event" style="max-width: 30% !important;" data-event-id="{{$item->id}}">
                                            <a data-start="{{$item->time_from}}" data-end="{{$item->time_to}}"
                                               data-content="event-rowing-workout"
                                               data-event="event-{{$item->status}}" href="#0">
                                                <em class="cd-schedule__name">{{$item->creator->full_name}}</em>
                                                <em class="cd-schedule__name">{{$item->short_des}}</em>

                                                <textarea class="hidden" style="display:none">{{$item->note}}</textarea>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="cd-schedule-modal">
                        <header class="cd-schedule-modal__header">
                            <div class="cd-schedule-modal__content">
                                <span class="cd-schedule-modal__date"></span>
                                <h3 class="cd-schedule-modal__name"></h3>
                            </div>

                            <div class="cd-schedule-modal__header-bg"></div>
                        </header>

                        <div class="cd-schedule-modal__body">
                            <div class="cd-schedule-modal__event-info"></div>
                            <div class="cd-schedule-modal__body-bg"></div>
                        </div>

                        <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
                    </div>

                    <div class="cd-schedule__cover-layer"></div>
                </div> <!-- .cd-schedule -->
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
                    // console.log(data, data['date'])
                    $('#update_id').val(data['id']);
                    $('#update_date').val(data['date']);
                    $('#update_time1').val(data['time_from']);
                    $('#update_time2').val(data['time_to']);
                    $('#update_status').val(data['status']);
                    $('#update_note').val(data['note']);
                });
            })
        })
    </script>
@endsection
