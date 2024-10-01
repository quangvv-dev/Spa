@extends('layout.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <style>
        .users-summary {
            display: inline-block;
            width: 30px;
            height: 30px;
        }

        .users-summary .userlink {
            background: rgb(230, 230, 230);
            overflow: hidden;
            text-indent: -10000px;
            border-radius: 50%;
            margin-left: 0;
        }

        .beacon-green, .beacon-red {
            opacity: 0.8;
            width: 120px;
            border: 1px solid #36c870;
            color: #fff !important;
            border-radius: 4px;
            font-size: .8em;
            display: inline-flex;
            padding: 5px 10px;
            justify-content: center;
        }

        .beacon-green {
            background: #49CE7E;
        }

        .beacon-red {
            background: #FB5E5A;
        }

        .nav-link.active {
            font-weight: bold !important;
        }

        .pointer {
            cursor: pointer;
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

        .abc {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column
        }

        th.text-center{
            position: sticky;
            top: 0;
        }
        th.text-center.bottom-th{
            top: 37px;
        }
        .bottom-th{
            top: 40px;
        }
        table.table.card-table.table-vcenter.text-nowrap.table-primary{
            position: relative;
        }
        .table-responsive{
            height: 80vh;
        }

        .select {
            position: relative;
        }

        .datepicker-table .selected {
            color: rgb(78, 52, 46);
            background: #ddd;
        }
        .padding-bot10{
            padding-bottom: 10px;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <form action="{{url()->current()}}" method="get" id="gridForm">

                <div class="card-header">
                    <div class="row" style="width: 100%;">
                        <h4 class="col-lg-2">Danh sách</h4>
                        <input type="hidden" class="value-month" name="month">
                        <input type="hidden" class="value-year" name="year">
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
                        <div class="col-lg-2 col-md-6">
                            {!! Form::select('branch_id', $branches, 1, array('class' => 'form-control branch_id', 'placeholder'=>'Chọn chi nhánh',)) !!}
                        </div>

                        {{--<button class="btn btn-primary searchData"><i class="fa fa-search"></i> Tìm kiếm</button>--}}
                    </div>
                    <div class="col">
                        {{--<a 1="" title="Upload Data" style="position: absolute;right: 0%" href="#" data-toggle="modal" data-target="#myModal">--}}
                        {{--<i class="fas fa-cloud-upload-alt"></i></a>--}}
                        <a 1="" title="Tải data" style="position: absolute;right: 3%" class="download"
                           data-value="download" href="javascript:void(0)"><i class="fas fa-cloud-download-alt"></i></a>
                    </div>
                </div>
            </form>
            <div id="registration-form">
                @include('cham_cong.statistic.ajax')
            </div>
            <!-- table-responsive -->
        </div>
    </div>
    @include('cham_cong.statistic.modal')
@endsection
@section('_script')
    <script src="{{asset('js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('js/dateranger-config.js')}}"></script>
    <script>
        $(function () {
            $(".draggable").draggable();
        });
        $(document).on('click', '#checkAll', function () {
            if (this.checked) {
                $('input:checkbox[getdataitem]').not(this).prop('checked', true);
            } else {
                $('input:checkbox[getdataitem]').not(this).prop('checked', false);
            }
        })

        $(document).on('click', '.showModal', function () {
            let dt = new Date();
            let elm = $(this);
            // let month = dt.getMonth() + 1 < 10 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
            let month = $('.datepicker-month-visible.selected').html();
            let date1 = elm.data('date') < 10 ? '0' + elm.data('date') : elm.data('date');
            let date = `${date1}-${month}-${dt.getFullYear()}`;
            let date_check = `${dt.getFullYear()}-${month}-${date1} 13:30:00`; //giờ ca chiều
            let user_id = elm.closest('tr').data('id');

            let cong = elm.html();
            let cong_an = cong > 0.8 ? 1 : 0;
            $.ajax({
                url: '/approval/get-detail-cham-cong',
                data: {
                    date: date,
                    user_id: user_id
                },
                success: function (data) {
                    if (data) {
                        $('#myModal .full_name').html(`${data.full_name}, Ngày ${date}`)

                        let date_text = '';
                        let time = '';
                        if (data.cham_cong.length > 0) {
                            let date_to = data.cham_cong[0].date_time_record;
                            let date_end = data.cham_cong[data.cham_cong.length - 1].date_time_record;
                            date_text = `${date_to} - ${date_end}`;
                            let time1 = Date.parse(date_to);
                            let time2 = Date.parse(date_end);
                            let time_check = Date.parse(date_check);
                            let time3 = '';
                            if (time2 > time_check) { //nếu chấm lần 2 vào ca chiều thì trừ đi 1.5 giờ
                                time3 = (time2 - time1) / 1000 - 5400;
                            } else {
                                time3 = (time2 - time1) / 1000;
                            }
                            let gio = Math.floor(time3 / 3600);
                            let phut = Math.floor((time3 % 3600) / 60);
                            time = `${gio} giờ ${phut} phút`;
                        }
                        let department = data.department ? data.department.name : '';
                        $('.cong').html(cong);
                        $('.cong-an').html(cong_an);
                        $('.ma-cham-cong').html(data.approval_code);
                        $('.department').html(department);
                        $('.chot-van-tay').html(date_text);
                        $('.time').html(time);


                        //Đơn từ
                        if (data.don_tu.length > 0) {
                            let html = '';
                            data.don_tu.forEach(item => {
                                let type = item.type == 0 ? 'Đơn nghỉ' : 'Đơn checkin/out';
                                let hours = array_HOURS[0][item.time_to];
                                let text = '';
                                if (item.type == 0) { //đơn nghỉ
                                    let hours_end = array_HOURS[0][item.time_end];
                                    text = `${hours} ${formatDate(item.date)} - ${hours_end} ${formatDate(item.date_end)}`
                                } else {
                                    text = `${hours} (${item.reason.name})`
                                }

                                html += `
                                    ${type} : ${text}
                                    </br>
                                `
                            })

                            $('#myModal #nav-don-tu').html(html);
                        } else {
                            $('#myModal #nav-don-tu').html('');
                        }


                        //Chốt vân tay

                        if (data.cham_cong.length > 0) {
                            let html = '';
                            data.cham_cong.forEach(item => {
                                let type = item.type == 0 ? '(máy)' : '(đơn)';
                                html += `
                                    <span class="bold">${item.date_time_record} ${type}, mã máy: ${item.name_machine}</span>
                                    </br>
                                `
                            })

                            $('#myModal #nav-cham-cong').html(html);
                        } else {
                            $('#myModal #nav-cham-cong').html('');
                        }

                    }
                }
            })

            $('#myModal').modal('show');
        })

        $(document).on('click', '.download', function () {
            let month = $('.value-month').val();
            let year = $('.value-year').val();
            let branch_id = $('.branch_id').val();
            let url = location.origin + `/approval/export-data-approval?month=${month}&year=${year}&branch_id=${branch_id}`;
            // location.href = url;
            window.open(url, '_blank');
        })

        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth();

        let currentCheckedMonth = currMonth;
        let currentCheckedYear = currYear;

        $(`.datepicker-table .${currMonth + 1}`).addClass('selected');

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

        $(document).on('change','.branch_id',function () {
            $('#gridForm').submit();
        })
        $(document).on('click', '.datepicker-month-visible', function () {
            let month = $(this).html();
            let abc = parseInt(month);
            currMonth = abc - 1;
            currentCheckedMonth = abc - 1;
            currentCheckedYear = currYear;
            $('.datepicker-table .selected').removeClass('selected');
            $(this).addClass('selected');
            $('.value-month').val(abc);
            $('.value-year').val(currYear);
            $('.datepicker-container').removeClass('show');
            $('#gridForm').submit();


            {{--$.ajax({--}}
                {{--url: "{{ url('/approval/history') }}",--}}
                {{--method: "get",--}}
                {{--data: {year: currentCheckedYear,month:abc}--}}
            {{--}).done(function (data) {--}}
                {{--base = data;--}}
                {{--renderCalendar();--}}
            {{--});--}}


        })
        $(document).on('click', '.showMonth', function (e) {
            e.preventDefault();
            $('.datepicker-container').toggleClass('show');
        })


    </script>
@endsection
