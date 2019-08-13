@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="container">
        <div class="side-app">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <div id="fix-scroll" class="row padding mb10 header-dard border-bot shadow"
                             style="width: 100%; padding: 10px;">
                            <div class="col-md-4 no-padd">
                            </div>
                            <div class="col-md-8 no-padd">
                                <ul class="fr mg0 pt10 no-padd">
                                    <li class="display pl5"><a data-time="TODAY" class="btn_choose_time">Hôm nay</a>
                                    </li>
                                    <li class="display pl5"><a data-time="THIS_WEEK" class="btn_choose_time">Tuần
                                            này</a></li>
                                    <li class="display pl5"><a data-time="LAST_WEEK" class="btn_choose_time">Tuần
                                            trước</a></li>
                                    <li class="display pl5"><a data-time="THIS_MONTH"
                                                               class="btn_choose_time border b-gray active padding0-5">Tháng
                                            này</a></li>
                                    <li class="display pl5"><a data-time="LAST_MONTH" class="btn_choose_time">Tháng
                                            trước</a></li>
                                    <li class="display pl5"><a data-time="THIS_YEAR" class="btn_choose_time">Năm nay</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="registration-form">
                            @include('customers.ajax_chart')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('click', '.btn_choose_time', function (e) {
            let target = $(e.target).parent();

            const data_time = $(target).find('.btn_choose_time').data('time');

            $.ajax({
                url: "{{ Url('report/customers') }}",
                method: "get",
                data: {
                    data_time: data_time,
                }
            }).done(function (data) {
//                console.log(data);
                $('#registration-form').html(data);
            });
        })
    </script>
@endsection
