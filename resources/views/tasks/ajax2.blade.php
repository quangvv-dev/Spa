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
                        var status = $('#update_status').val();
                        if (status != 1) {
                            $('#update_status').attr('disabled', true)
                        }
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
                                    title: "{!! @$item->name !!}",
                                    user_id: "{!! @$item->user_id !!}",
                                    type: "{!! @$item->type !!}",
                                    description: "{{$item->description}}",
                                    time_from: '{{$item->time_from}}',
                                    time_to: '{{$item->time_to}}',
                                    date: '{{$item->date_schedule}}',
                                    status: '{{$item->task_status_id}}',
                                    @switch($item->task_status_id)
                                        @case(1)
                                    color: '#63cff9',
                                    @break
                                        @case(4)
                                    color: '#dccf34',
                                    @break
                                        @case(6)
                                    color: '#d03636',
                                    @break
                                        @case(3)
                                    color: '#4bcc4b',
                                    @break
                                        @case(5)
                                    color: '#808080',
                                    @break
                                        @endswitch
                                        {{--url: '{{url('schedules/'.$item->user_id)}}',--}}
                                    start: '{{$item->date_from.'T'.$item->time_from.':00'}}',
                                    end: '{{$item->date_from.'T'.$item->time_to.':00'}}'
                                },
                                @endforeach
                            ],
                            //Su kien click
                            eventClick: function (info) {
                                let id = info.id;
                                console.log(info, 'info');
                                $('#update_id').val(info.id).change();
                                $('#update_date').val(info.date).change();
                                $('#update_time1').val(info.time_from).change();
                                $('#update_time2').val(info.time_to).change();
                                $('#update_status').val(info.status).change();
                                $('#update_category').val(info.type).change();
                                if (info.status == 6)
                                    $('#update_status').attr('disabled', true).change();
                                $('#update_note').val(info.description).change();
                                $('#full_name').val(info.title).change();
                                $('#phone').val(info.phone).change();
                                $('#action').val(info.user_id).change();
                                $('.modal.fade').attr('id', 'modal_' + id).change();
                                $('.delete').data('url', 'schedules/' + id).change();
                                $('#modal_' + id).modal('show');
                            },
                            // editable: true,
                            // eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc) {
                            //     var date = reformatDate(new Date(event.start).toISOString().slice(0, 10));
                            //     var id = event.id;
                            //     // if (!confirm("Bạn có chắc chắn muốn thay đổi?")) {
                            //     let date2 = reformatDMY(date);
                            //     $('.date-' + id).val(date2).change();
                            //     $.ajax({
                            //         url: window.location.origin + '/ajax/' + 'tasks/' + id,
                            //         method: "PUT",
                            //         data: {
                            //             date: date,
                            //         }
                            //     }).done(function (data) {
                            //         if (data) {
                            //             revertFunc();
                            //         } else {
                            //             alert("Đã phát sinh lỗi xin thử lại sau !");
                            //         }
                            //     });
                            //     // }
                            //
                            // }
                        })
                        ;
                    })
                </script>

                <div class="modal fade" id="" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 style="font-weight: 900;color: #0fa2e8;">Cập nhật công việc</h4>
                                <button type="button" style="color: black" class="close" data-dismiss="modal">&times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {!! Form::hidden('id',null, array('class' => 'form-control','id'=>'update_id')) !!}
                                    <div class="col-md-12">
                                        {!! Form::label('full_name', 'Công việc', array('class' => 'required')) !!}
                                        <input class="form-control" readonly value="" id="full_name">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                                        <input class="form-control" id="update_date"
                                               data-toggle="datepicker" value="">
                                    </div>
                                    <div class="col-md-3 col-xs-12 clockpicker" data-placement="left" data-align="top"
                                         data-autoclose="true">
                                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1')) !!}
                                    </div>
                                    <div class="col-md-3 col-xs-12 clockpicker" data-placement="left" data-align="top"
                                         data-autoclose="true">
                                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2')) !!}
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::label('status', 'Trạng thái công việc', array('class' => ' required')) !!}
                                        {!! Form::select('status',$taskStatus, null, array('class' => 'form-control','id'=>'update_status')) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                                        {!! Form::select('type',$type, null, array('class' => 'form-control','id'=>'update_category','disabled'=>true))!!}
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        {!! Form::label('user_id', 'Người thực hiện', array('class' => ' required')) !!}
                                        {!! Form::select('user_id',@$users,null, array('id'=>'action','class' => 'form-control','required'=>true,'disabled'=>true)) !!}
                                    </div>
                                    <div class="col-md-12 ">
                                        {!! Form::label('description', 'Ghi chú', array('class' => ' required')) !!}
                                        {!! Form::textArea('description', null, array('class' => 'form-control','id'=>'update_note','rows'=>5)) !!}
                                        <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 10px">
                                        <button type="button" class="btn btn-success" id="update_task">Lưu
                                        </button>
                                        {{--<a class="btn btn-secondary btn-flat delete" data-url=""--}}
                                        {{--href="javascript:"><i class="fa fa-arrow-"></i>Xoá lịch hẹn</a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

