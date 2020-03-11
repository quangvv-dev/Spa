<div class="">
    {{--    <a class="col spin" style="display: flex;justify-content: center;"><i class="fa fa-2x fa-spinner fa-spin"></i></a>--}}
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
                                    title: '{!! 'KH: '.@$item->customer->full_name .', SĐT: '.@$item->customer->phone.' Lưu ý: '.$item->note !!}',
                                    description: '{{$item->note}}',
                                    @switch($item->status)
                                        @case(1)
                                    color: '#63cff9',
                                    @break
                                        @case(2)
                                    color: '#dccf34',
                                    @break
                                        @case(3)
                                    color: '#d03636',
                                    @break
                                        @case(4)
                                    color: '#4bcc4b',
                                    @break
                                        @case(5)
                                    color: 'gray',
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
                                console.log(info);
                                let id = info.id;
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
                @foreach($docs as $item)

                    <div class="modal fade" id="modal_{{$item->id}}" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content" style="height: 80%">
                                <div class="modal-header">
                                    <h4>Cập nhật lịch hẹn</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(array('url' => url('schedules/'.$item->user_id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                                    <div class="row">
                                        {!! Form::hidden('id', $item->id, array('class' => 'form-control','id'=>'update_id')) !!}
                                        <div class="col-md-6">
                                            {!! Form::label('full_name', 'Khách Hàng', array('class' => ' required')) !!}
                                            <input class="form-control" readonly
                                                   value="{{@$item->customer->full_name}}">
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                                            <input class="form-control" readonly value="{{@$item->customer->phone}}">
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                                            <input class="form-control {{'date-'.$item->id}}" id="update_date"
                                                   data-toggle="datepicker" value="{{$item->date_schedule}}"
                                                   name="date">
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            {!! Form::label('person_action', 'Người tạo', array('class' => ' required')) !!}
                                            {!! Form::select('person_action',@$staff, @$item->creator_id, array('id'=>'update_action','class' => 'form-control select2','data-placeholder'=>'người phụ trách','required'=>true,'disabled'=>true)) !!}
                                        </div>
                                        <div class="col-md-6 col-xs-12 clockpicker" data-placement="left"
                                             data-align="top"
                                             data-autoclose="true">
                                            {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                                            {!! Form::text('time_from', $item->time_from, array('class' => 'form-control','id'=>'update_time1')) !!}
                                        </div>
                                        <div class="col-md-6 col-xs-12 clockpicker" data-placement="left"
                                             data-align="top"
                                             data-autoclose="true">
                                            {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                                            {!! Form::text('time_to', $item->time_to, array('class' => 'form-control','id'=>'update_time2')) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                                            {!! Form::select('status',array(1 => 'Chưa qua',2 => 'Đặt lịch',3 => 'Đến/Mua',4 => 'Đến/Chưa mua',5 => 'Hủy'), @$item->status, array('class' => 'form-control','id'=>'update_status')) !!}
                                        </div>
                                        <div class="col-md-12">
                                            {!! Form::label('category_id', 'Nhóm dịch vụ', array('class' => ' required')) !!}
                                            {!! Form::select('category_id',$category, @$item->category_id, array('class' => 'form-control'))!!}
                                        </div>
                                        <div class="col-md-12 ">
                                            {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                                            {!! Form::textArea('note', $item->note, array('class' => 'form-control','id'=>'update_note','rows'=>5)) !!}
                                            <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                                        </div>
                                        <div class="col-md-12" style="padding-top: 10px">
                                            <button type="submit" class="btn btn-success">Lưu</button>
                                            <a class="btn btn-secondary btn-flat delete"data-url="{{url('schedules/'.$item->id)}}"
                                               href="javascript:"><i class="fa fa-arrow-"></i>Xoá lịch hẹn</a>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
