@extends('layout.app')
@section('content')
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <style>

        .wrapper header {
            display: flex;
            align-items: center;
            padding: 25px 30px 10px;
            justify-content: space-between;
        }
        header .icons span {
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            color: #878787;
            text-align: center;
            line-height: 38px;
            font-size: 1.9rem;
            user-select: none;
            border-radius: 50%;
        }

        .icons span:last-child {
            margin-right: -10px;
        }

        .calendar ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            text-align: center;
            margin-bottom: 0px;
        }


        .calendar li {
            color: #333;
            width: calc(100% / 7);
            font-size: 1.07rem;
        }

        .calendar .weeks li {
            font-weight: 500;
            cursor: default;
        }

        .calendar .days li {
            z-index: 1;
            cursor: pointer;
            position: relative;
            padding-bottom: 7%;
            background: rgb(255, 255, 255);
        }

        .days li.inactive {
            color: #aaa;
        }

        .days li.active {
            /*color: #fff;*/
            background: antiquewhite;
        }

        .days li::before {
            position: absolute;
            content: "";
            left: 50%;
            top: 50%;
            height: 40px;
            width: 40px;
            z-index: -1;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .card-body ul li {
            border: 1px solid #ccc;
        }

        .datepicker-container {
            /*min-width: 300px;*/
            width: 0px;
            transition: width 0.3s linear;
        }

        .datepicker-container.show {
            /*min-width: 300px;*/
            width: 300px;
        }

        .pop-box {
            background: #fff !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .1);
        }

        .datepicker-header {
            display: flex;
            align-items: center;
            background: rgb(78, 52, 46);
            color: #fff;
            flex-direction: row;
            user-select: none;
        }


        .datepicker-table {
            width: 100%;
        }

        .datepicker-date-slot, .datepicker-month-slot, .datepicker-year-slot {
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            font-size: 14px;
        }

        .datepicker-date-slot:hover, .datepicker-month-slot:hover, .datepicker-year-slot:hover {
            background: #f7f8f9;
            cursor: pointer;
        }

        .datepicker-header-title {
            flex-grow: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }

        .material-symbols-rounded {
            cursor: pointer;
        }
        .select {
            position: absolute;
            right: 10px;
        }

        .datepicker-table .selected {
            color: rgb(78, 52, 46);
            background: #ddd;
        }
        a.nav-link.active {
            font-weight: 600;
        }
        p{
            font-size: 14px;
            color: #050505;
            min-height: 22px;
            font-weight: 500;
        }
        .col-6-custom{
            border-bottom: 1px solid black;
            padding: 0;
        }
        @media only screen and (max-width: 1365px) {
            .col-6-custom p{
                font-size: 13px;
            }
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title bold">Bảng lương <span class="month-year">02/2023</span></h3></br>
                <div class="select">
                    <button class="btn btn-small btn-primary showMonth"><i class="fa fa-wallet"></i></button>
                    <div class="datepicker-container pop-box pop-box-click pop-box-contextmenu"
                         style="z-index: 1000000000;max-height: 469px;overflow: hidden;position: absolute;right: -14%;left: -185px;top: 54px;">
                        <div style="display:flex;flex-direction:column;justify-content:stretch">
                            <div class="datepicker-header">
                                <!--<div class="datepicker-header-btn icon-caret-left" prev="1"></div>-->
                                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                <div class="datepicker-header-title">2023</div>
                                <!--<div class="datepicker-header-btn icon-caret-right" next="1"></div>-->
                                <span id="next" class="material-symbols-rounded">chevron_right</span>
                            </div>
                            <div class="datepicker-container-table">
                                <table class="datepicker-table">
                                    <thead></thead>
                                    <tbody>
                                    <tr>
                                        <td class="datepicker-month-slot datepicker-month-visible 1">01</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 2">02</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 3">03</td>
                                    </tr>
                                    <tr>
                                        <td class="datepicker-month-slot datepicker-month-visible 4">04</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 5">05</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 6">06</td>
                                    </tr>
                                    <tr>
                                        <td class="datepicker-month-slot datepicker-month-visible 7">07</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 8">08</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 9">09</td>
                                    </tr>
                                    <tr>
                                        <td class="datepicker-month-slot datepicker-month-visible 10">10</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 11">11</td>
                                        <td class="datepicker-month-slot datepicker-month-visible 12">12</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="registration-form">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="nav-item">
                                <a href="{{route('users.edit',$user->id)}}" class="nav-link" >Thông tin tài khoản</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{url('personal/salary/'.$user->id)}}" data-toggle="tab">Bảng lương</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/'.$user->id)}}">Hồ sơ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('personal/images/'.$user->id)}}">Hợp đồng (file)</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    @include('users.include._form-salary')
                </div>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
{{--    @include('cham_cong.statistic.modal')--}}
@endsection
@section('_script')
    <script>
        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth();

        $(`.datepicker-table .${currMonth + 1}`).addClass('selected');

        $('.month-year').html(`${currMonth+1}/${currYear}`);
        $(document).on('click', '.datepicker-month-visible', function () {
            let month = $(this).html();
            let abc = parseInt(month);
            currMonth = abc - 1;
            currentCheckedMonth = abc - 1;
            currentCheckedYear = currYear;

            $('.month-year').html(`${abc}/${currYear}`);

            $.ajax({
                url: "{{ url('/personal/salary/'.request()->segments()[2]) }}",
                data: {year: currentCheckedYear,month:abc},
                success:function (data) {
                    $('.table-responsive').html(data);
                }
            })

            $('.datepicker-table .selected').removeClass('selected');
            $(this).addClass('selected');
        })
        $(document).on('click', '.showMonth', function () {
            $('.datepicker-container').toggleClass('show');
        })

        $(document).on('click', '#prev', function () {
            currYear = currYear - 1;
            $('.datepicker-header-title').html(currYear);
            selectedMonth();
        })
        $(document).on('click', '#next', function () {
            currYear = currYear + 1;
            $('.datepicker-header-title').html(currYear);
            selectedMonth();
        })
        function selectedMonth() {
            $('.datepicker-table .selected').removeClass('selected');
            if (currYear == currentCheckedYear) {
                let monthChecked = currentCheckedMonth + 1;
                $(`.datepicker-table .${monthChecked}`).addClass('selected');
            }
        }
    </script>
@endsection
