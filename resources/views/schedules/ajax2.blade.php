<div class="">
    <style>
        label.required {
            font-size: 14px;
        }
    </style>
    <div class="card">
        <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
        <div class="card-body">
            <div id='calendar1'>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                      crossorigin="anonymous">
                <link rel="stylesheet" href="{{asset('assets/css/bootstrap-clockpicker.min.css')}}">
                <script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
                <script src='{{asset('assets/plugins/fullcalendar/moment.min.js')}}'></script>
                <script src='{{asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}'></script>
                <script src='{{asset('assets/plugins/fullcalendar/vi.js')}}'></script>
                <script src="{{asset('assets/js/bootstrap-clockpicker.min.js')}}"></script>
                <script>
                    function formatYMDtoDMY(dateStr) {
                        dArr = dateStr.split("-");  // ex input "2010-01-18"
                        return dArr[2] + "/" + dArr[1] + "/" + dArr[0]; //ex out: "18/01/10"
                    }

                    function reformatDate(dateStr) {
                        dArr = dateStr.split("-");  // ex input "2010-01-18"
                        return dArr[0] + "/" + dArr[1] + "/" + dArr[2]; //ex out: "2010-01-18"
                    }

                    function reformatDMY(dateStr) {
                        dArr = dateStr.split("/");  // ex input "2010-01-18"
                        return dArr[2] + "/" + dArr[1] + "/" + dArr[0]; //ex out: "18/01/10"
                    }

                    $('document').ready(function () {
                        $('.clockpicker').clockpicker();
                        $('#calendar1').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            buttonText: {
                                today: 'Hôm nay',
                                month: 'Tháng',
                                week: 'Tuần',
                                day: 'Ngày',
                            },
                            locale: 'vi',
                            defaultDate: '{{$now}}',
                            navLinks: true, // can click day/week names to navigate views
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end) {

                            },
                            editable: true,
                            eventLimit: true, // allow "more" link when too many events
                            events: [
                                    @foreach($docs as $item)
                                {
                                    id: '{{$item->id}}',
                                    title: "{!! 'KH1231: '.@$item->customer->full_name .', SĐT: '.(auth()->user()->permission('phone.open')? @$item->customer->phone :@str_limit($item->customer->phone,7,'xxx')).' Lưu ý: '.$item->note !!}",
                                    note: "{{$item->note}}",
                                    description: "{{$item->note}}",
                                    full_name: '{{@$item->customer->full_name}}',
                                    phone: "{{@$item->customer->phone}}",
                                    creator_id: '{{@$item->creator_id}}',
                                    time_from: '{{$item->time_from}}',
                                    time_to: '{{$item->time_to}}',
                                    category_id: '{{@$item->category_id}}',
                                    date: '{{$item->date_schedule}}',
                                    status: '{{$item->status}}',
                                    branch_id: '{{$item->branch_id}}',
                                    @switch($item->status)
                                        @case(1)
                                    color: '#63cff9',
                                    @break
                                        @case(\App\Constants\ScheduleConstant::DAT_LICH)
                                    color: '#dccf34',
                                    @break
                                        @case(\App\Constants\ScheduleConstant::DEN_MUA)
                                    color: '#d03636',
                                    @break
                                        @case(\App\Constants\ScheduleConstant::CHUA_MUA)
                                    color: '#4bcc4b',
                                    @break
                                        @case(\App\Constants\ScheduleConstant::HUY)
                                    color: '#808080',
                                    @case(\App\Constants\ScheduleConstant::QUA_HAN)
                                    color: '#f36a26',
                                    @break
                                        @endswitch
                                        {{--url: '{{url('schedules/'.$item->user_id)}}',--}}
                                    start: '{{$item->date.'T'.$item->time_from.':00'}}',
                                    end: '{{$item->date.'T'.$item->time_to.':00'}}'
                                },
                                @endforeach
                            ],
                            //Su kien click
                            eventClick: function (info) {
                                let id = info.id;
                                $('#update_id').val(info.id).change();
                                $('#update_date').val(info.date).change();
                                $('#update_time1').val(info.time_from).change();
                                $('#update_time2').val(info.time_to).change();
                                $('#update_status').val(info.status).change();
                                $('#update_branch').val(info.branch_id).change();
                                $('#update_note').val(info.note).change();
                                $('#full_name').val(info.full_name).change();
                                $('#phone').val(hidden_phone == true ? info.phone : info.phone.slice(0, 7)+'xxx').change();
                                $('#action').val(info.creator_id).change();
                                $('.modal.fade').attr('id', 'modal_' + id).change();
                                $('.delete').data('url', 'schedules/' + id).change();
                                $('#modal_' + id).modal('show');
                            },
                            // editable: true,
                            eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc) {
                                var date = reformatDate(new Date(event.start).toISOString().slice(0, 10));
                                var id = event.id;
                                // if (!confirm("Bạn có chắc chắn muốn thay đổi?")) {
                                let date2 = reformatDMY(date);
                                $('.date-' + id).val(date2).change();
                                $.ajax({
                                    url: window.location.origin + '/ajax/' + 'schedules/' + id,
                                    method: "PUT",
                                    data: {
                                        date: date,
                                    }
                                }).done(function (data) {
                                    if (data) {
                                        revertFunc();
                                    } else {
                                        alert("Đã phát sinh lỗi xin thử lại sau !");
                                    }
                                });
                                // }

                            }
                        })
                        ;
                    })
                </script>

                <div class="modal fade" id="" role="dialog">
                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 style="font-weight: 900;color: #0fa2e8;">Cập nhật lịch hẹn</h4>
                                <button type="button" style="color: black" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {!! Form::hidden('id',null, array('class' => 'form-control','id'=>'update_id')) !!}
                                    <div class="col-md-4">
                                        {!! Form::label('full_name', 'Khách Hàng', array('class' => ' required')) !!}
                                        <input class="form-control" readonly value="" id="full_name">
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                                        <input class="form-control" readonly value="" id="phone">
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                                        <input class="form-control {{'date-'.@$item->id}}" id="update_date" data-toggle="datepicker" value="" name="date">
                                    </div>
                                    <div class="col-md-4 col-xs-12 clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1')) !!}
                                    </div>
                                    <div class="col-md-4 col-xs-12 clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2')) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                                        @if(\Illuminate\Support\Facades\Auth::user()->department_id == \App\Constants\DepartmentConstant::WAITER)
                                            {!! Form::select('status',array(2 => 'Đặt lịch',3 => 'Đến/Mua',4 => 'Đến/Chưa mua'), null, array('class' => 'form-control','id'=>'update_status')) !!}
                                        @else
                                            {!! Form::select('status',array(2 => 'Đặt lịch',3 => 'Đến/Mua',4 => 'Đến/Chưa mua',5 => 'Hủy lịch',6 => 'Quá hạn'), null, array('class' => 'form-control','id'=>'update_status')) !!}
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required')) !!}
                                        {!! Form::select('branch_id',$branchs, null, array('class' => 'form-control','id'=>'update_branch'))!!}
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        {!! Form::label('person_action', 'Người tạo', array('class' => ' required')) !!}
                                        {!! Form::select('person_action',@$staff,null, array('id'=>'action','class' => 'form-control','required'=>true,'disabled'=>true)) !!}
                                    </div>
                                    <div class="col-md-12 ">
                                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                                        {!! Form::textArea('note', null, array('class' => 'form-control','id'=>'update_note','rows'=>5)) !!}
                                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 10px">
                                        <button type="button" class="btn btn-success" id="update_schedule">Lưu
                                        </button>
                                        <a class="btn btn-secondary btn-flat delete" data-url=""
                                           href="javascript:"><i class="fa fa-arrow-"></i>Xoá lịch hẹn</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                @endforeach--}}

            </div>
        </div>
    </div>
</div>

