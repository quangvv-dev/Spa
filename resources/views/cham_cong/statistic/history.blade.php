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

        header .icons {
            display: flex;
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

        header .icons span:hover {
            background: #f2f2f2;
        }

        header .current-date {
            font-size: 1.45rem;
            font-weight: 500;
        }

        .calendar {
            padding: 20px;
        }

        .calendar ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            text-align: center;
            margin-bottom: 0px;
        }

        .calendar .days {
            margin-bottom: 20px;
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

        .select {
            position: absolute;
            right: 10px;
        }

        .datepicker-table .selected {
            color: rgb(78, 52, 46);
            background: #ddd;
        }
    </style>

    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách</h3></br>

                <form action="{{url()->current()}}" method="get" id="gridForm">
                    <div class="ml-5">
                        <input type="text" class="form-control" style="height: 33px;" placeholder="Tìm kiếm">
                    </div>
                </form>


                <div class="select">
                    <button class="btn btn-small btn-primary showMonth">Chọn</button>
                    <div class="datepicker-container pop-box pop-box-click pop-box-contextmenu"
                         style="z-index: 1000000000;max-height: 469px;overflow: hidden;position: absolute;right: -14%;left: -344%;top: 54px;">
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
                                        <td class="datepicker-month-slot datepicker-month-visible 3 selected">03</td>
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
            <div class="card-body">
                <div class="calendar">
                    <ul class="weeks">
                        <li>Thứ 2</li>
                        <li>Thứ 3</li>
                        <li>Thứ 4</li>
                        <li>Thứ 5</li>
                        <li>Thứ 6</li>
                        <li>Thứ 7</li>
                        <li>Chủ nhật</li>
                    </ul>
                    <ul class="days">
                        <li class="inactive"><span>27</span></li>
                        <li class="inactive"><span>28</span></li>
                        <li class="" style="position: relative">
                            <div class="abc">
                                <div style="position:absolute;top:6px;right:6px;font-size:0.7em;color:#333">01/03</div>
                                <div style="color:#777">1</div>
                                <div style="font-size:0.6em;padding-bottom:5px" title="Thời gian thực tế">08:30 -
                                    18:00
                                </div>
                                <div style="font-size:0.6em;" title="CAIT">CAIT</div>
                                <div style="font-size:0.6em;padding-bottom:5px">
                                    <div style="padding:2px;display:flex;justify-content:space-between;font-size:85%"
                                         title="Đơn quên checkin/out">
                                        <div style="font-size:80%"><span class="icon-realtime-protection"></span></div>
                                        <div style="padding-left:3px;">08:30</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class=""><span>2</span></li>

                    </ul>
                </div>

            </div>
            <!-- table-responsive -->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script defer>
        const daysTag = document.querySelector(".days"),
            currentDate = document.querySelector(".current-date"),
            prevNextIcon = document.querySelectorAll(".icons span");
        // getting new date, current year and month
        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth();

        let currentCheckedMonth = currMonth;
        let currentCheckedYear = currYear;

        const months = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
            "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        const renderCalendar = () => {

            let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // nhận ngày đầu tiên của tháng
                lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // nhận ngày cuối cùng của tháng
                lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // nhận được ngày cuối cùng của tháng
                lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // lấy ngày cuối cùng của tháng trước
            let liTag = "";


            for (let i = firstDayofMonth - 1; i > 0; i--) { // creating li of previous month last days
                liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
            }
            for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
                // adding active class to li if the current day, month, and year matched
                let isToday = i === date.getDate() && currMonth === new Date().getMonth()
                && currYear === new Date().getFullYear() ? "active" : "";
                liTag += `
                    <li class="${isToday} ${i}">
                        <div class="abc">
                            <div style="position:absolute;top:6px;right:6px;font-size:0.7em;color:#333">${i}/03</div>
                            <div style="color:#777">1</div>
                            <div style="font-size:0.8em;padding-bottom:5px" title="Thời gian thực tế">08:30 - 18:00</div>
                            <div style="font-size:0.8em;" title="CAIT">CAIT</div>
                            <div style="font-size:0.8em;padding-bottom:5px">
                                <div style="padding:2px;display:flex;justify-content:space-between;font-size:85%"
                                     title="Đơn quên checkin/out">
                                    <div style="font-size:80%"><span class="icon-realtime-protection"></span></div>
                                    <div style="padding-left:3px;">08:30</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    `;
            }
            if (lastDayofMonth > 0) {
                for (let i = lastDayofMonth; i < 7; i++) { // creating li of next month first days
                    liTag += `<li class="inactive"><span>${i - lastDayofMonth + 1}</span></li>`
                }
            }

            // currentDate.innerText = `${months[currMonth]}/${currYear}`; // passing current mon and yr as currentDate text
            $('.current-date').html(`${months[currMonth]}/${currYear}`)
            daysTag.innerHTML = liTag;
        }
        renderCalendar();
        // prevNextIcon.forEach(icon => { // getting prev and next icons
        //     icon.addEventListener("click", () => { // adding click event on both icons
        //         // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        //         currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
        //         if (currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
        //             // creating a new date of current year & month and pass it as date value
        //             date = new Date(currYear, currMonth, new Date().getDate());
        //             currYear = date.getFullYear(); // updating current year with new date year
        //             currMonth = date.getMonth(); // updating current month with new date month
        //         } else {
        //             date = new Date(); // pass the current date as date value
        //         }
        //         renderCalendar(); // calling renderCalendar function
        //     });
        // });

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
        $(document).on('click', '.datepicker-month-visible', function () {
            let month = $(this).html();
            let abc = parseInt(month);
            currMonth = abc - 1;
            currentCheckedMonth = abc - 1;
            currentCheckedYear = currYear;
            renderCalendar();
            $('.datepicker-table .selected').removeClass('selected');
            $(this).addClass('selected');
        })
        $(document).on('click', '.showMonth', function () {
            $('.datepicker-container').toggleClass('show');
        })

        function selectedMonth() {
            $('.datepicker-table .selected').removeClass('selected');
            if (currYear == currentCheckedYear) {
                let monthChecked = currentCheckedMonth + 1;
                $(`.datepicker-table .${monthChecked}`).addClass('selected');
            }
        }

        $(document).on('click', '.abc', function () {
            $('#exampleModal').modal('show');
        })
    </script>

@endsection
