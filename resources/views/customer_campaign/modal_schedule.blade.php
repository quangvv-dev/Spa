<div class="modal fade" id="createScheduleModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 80%">
            <div class="modal-header">
                <h4 style="font-weight: 900;color: #0fa2e8;">Tạo lịch hẹn mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => '', 'method' => 'post', 'files'=> true,'id'=>'createSchedule','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                        {!! Form::text('date', null, array('class' => 'form-control','data-toggle'=>'datepicker','required'=>true)) !!}
                    </div>
                    <div class="col-md-6 col-xs-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-6 col-xs-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                        {!! Form::select('status',array(2 => 'Đặt lịch'), null, array('class' => 'form-control select2','required'=>true)) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required')) !!}
                        {!! Form::select('branch_id',$branchs, null, array('class' => 'form-control select2','required'=>true)) !!}
                    </div>
                    <div class="col-md-12 ">
                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                        {!! Form::textArea('note', null, array('class' => 'form-control','rows'=>5)) !!}
                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="button" class="btn btn-success btn-create-schedule">Tạo lịch</button>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>

    </div>

</div>
