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
                <script src="{{asset('assets/js/bootstrap-clockpicker.min.js')}}"></script>
                <script>
                    $('document').ready(function () {
                        $('.clockpicker').clockpicker();
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

                            },
                            editable: true,
                            eventLimit: true, // allow "more" link when too many events
                            events: [
                                    @foreach($docs as $item)
                                {
                                    id: '{{$item->id}}',
                                    title: '{{'KH: '.@$item->customer->full_name .', SĐT: '.@$item->customer->phone.' Lưu ý: '.$item->note}}',
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
                                            {{--url: '{{url('schedules/'.$item->user_id)}}',--}}
                                    start: '{{$item->date.'T'.$item->time_from.':00'}}',
                                    end: '{{$item->date.'T'.$item->time_to.':00'}}'
                                },
                                @endforeach
                            ],
                            eventClick: function (info) {
                                let id = info.id;
                                // console.log(id);
                                $('#modal_' + id).modal('show');
                            }
                        })
                        ;
                    })
                </script>
                @foreach($docs as $item)

                    <div class="modal fade" id="modal_{{$item->id}}" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content" style="height: 70%">
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
                                            {!! Form::date('date', $item->date, array('class' => 'form-control','id'=>'update_date','readonly'=>true)) !!}
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            {!! Form::label('person_action', 'Nhân viên phụ trách', array('class' => ' required')) !!}
                                            {!! Form::select('person_action',@$staff, @$item->person_action, array('id'=>'update_action','class' => 'form-control select2','data-placeholder'=>'người phụ trách','required'=>true)) !!}
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
                                        <div class="col-md-12">
                                            {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                                            {!! Form::select('status',array(1=>'Hẹn gọi lại',2=>'Đặt lịch',3=>'Đã đến',4=>'Không đến',5=>'Hủy'), $item->status, array('class' => 'form-control','id'=>'update_status')) !!}
                                        </div>
                                        <div class="col-md-12 ">
                                            {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                                            {!! Form::textArea('note', $item->note, array('class' => 'form-control','id'=>'update_note','rows'=>5)) !!}
                                            <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                                        </div>
                                        <div class="col-md-12" style="padding-top: 10px">
                                            <button type="submit" class="btn btn-success">Lưu</button>
                                            <a class="btn btn-primary btn-flat"
                                               href="{{url('orders')}}"><i class="fa fa-arrow-right"></i>Tới tạo đơn
                                                hàng</a>
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
