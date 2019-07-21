@extends('layout.app')

<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}' rel='stylesheet'/>
<link href='{{asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}' rel='stylesheet' media='print'/>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

{{--            <div class="card-header">--}}
{{--                <input class="form-control header-search col-md-2" name="search" placeholder="Search…" tabindex="1"--}}
{{--                       type="search">--}}
{{--            </div>--}}
{{--            <div id="registration-form">--}}
{{--                <div class="container">--}}
                    <div class="side-app">
{{--                        <div class="page-header">--}}
{{--                            <h4 class="page-title">Full Calendar</h4>--}}
{{--                            <ol class="breadcrumb">--}}
{{--                                <li class="breadcrumb-item"><a href="#">Ui Design</a></li>--}}
{{--                                <li class="breadcrumb-item active" aria-current="page">Full calendar</li>--}}
{{--                            </ol>--}}
{{--                        </div>--}}

                        <div class="">
                            <div class="card">
                                <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
                                <div class="card-body">
                                    <div id='calendar1'></div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card">
                                <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
                                <div class="card-body">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                </div>--}}
{{--            </div>--}}
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script src='{{asset('assets/plugins/fullcalendar/moment.min.js')}}'></script>
    <script src='{{asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}'></script>
    <script src='{{asset('assets/js/fullcalendar.js')}}'></script>

@endsection
