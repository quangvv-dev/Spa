<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 90%">
            <div class="modal-header">
                <h4>Tạo lịch hẹn mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('schedules/'.$id), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                        {!! Form::text('date', null, array('class' => 'form-control','data-toggle'=>'datepicker','required'=>true)) !!}
                    </div>
                    <div class="col-md-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('person_action', 'Nhân viên phụ trách', array('class' => ' required')) !!}
                        {!! Form::select('person_action',@$staff, @$doc->person_action, array('class' => 'form-control select2','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                        {!! Form::select('status',array(1=>'Hẹn gọi lại',2=>'Đặt lịch',3=>'Đã đến',4=>'Không đến',5=>'Hủy'), null, array('class' => 'form-control select2','required'=>true)) !!}
                    </div>
                    <div class="col-md-12 ">
                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                        {!! Form::textArea('note', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="updateModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 90%">
            <div class="modal-header">
                <h4>Cập nhật lịch hẹn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('schedules/'.$id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                <div class="row">
                    {!! Form::hidden('id', null, array('class' => 'form-control','id'=>'update_id')) !!}
                    <div class="col-md-12">
                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                        {!! Form::date('date', null, array('class' => 'form-control','id'=>'update_date','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('person_action', 'Nhân viên phụ trách', array('class' => ' required')) !!}
                        {!! Form::select('person_action',@$staff, @$doc->person_action, array('class' => 'form-control','data-placeholder'=>'người phụ trách','required'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                        {!! Form::select('status',array(1=>'Hẹn gọi lại',2=>'Đặt lịch',3=>'Đã đến',4=>'Không đến',5=>'Hủy'), null, array('class' => 'form-control','id'=>'update_status')) !!}
                    </div>
                    <div class="col-md-12 ">
                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                        {!! Form::textArea('note', null, array('class' => 'form-control','id'=>'update_note')) !!}
                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>

    </div>

</div>
{{--<script>--}}
{{--    $('.clockpicker').clockpicker();--}}
{{--</script>--}}
