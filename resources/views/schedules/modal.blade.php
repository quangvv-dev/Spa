<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="height: 80%">
            <div class="modal-header">
                <h4 style="font-weight: 900;color: #0fa2e8;">Tạo lịch hẹn mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('schedules/'.$id), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','autocomplete'=>'off')) !!}

                <div class="row">
                    {{--                    <div class="col-md-6 col-xs-12">--}}
                    {{--                        {!! Form::label('person_action', 'Người tạo', array('class' => ' required')) !!}--}}
                    {{--                        {!! Form::select('person_action',@$staff, @$doc->creator_id, array('class' => 'form-control select2','data-placeholder'=>'người phụ trách','required'=>true,'disable'=>true)) !!}--}}
                    {{--                    </div>--}}
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
                        {!! Form::select('status',array(2 => 'Đặt lịch',3 => 'Đến/Mua',4 => 'Đến/Chưa mua',5 => 'Hủy lịch'), null, array('class' => 'form-control select2','required'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('category_id', 'Nhóm dịch vụ', array('class' => ' required')) !!}
                        {!! Form::select('category_id',$group, @$item->category_id, array('class' => 'form-control select2'))!!}
                    </div>
                    <div class="col-md-12 ">
                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                        {!! Form::textArea('note', null, array('class' => 'form-control','rows'=>5)) !!}
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
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-weight: 900;color: #0fa2e8;">Cập nhật lịch hẹn</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('schedules/'.$id), 'method' => 'put', 'files'=> true,'class'=>'formUpdateSchedule','autocomplete'=>'off')) !!}

                <div class="row">
                    {!! Form::hidden('id', null, array('class' => 'form-control','id'=>'update_id')) !!}
                    {!! Form::hidden('format_date', 1, array('class' => 'form-control',)) !!}
                    <div class="col-md-6 col-xs-12">
                        {!! Form::label('date', 'Ngày hẹn', array('class' => ' required')) !!}
                        {!! Form::date('date', null, array('class' => 'form-control','id'=>'update_date','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-3 col-xs-12">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-3 col-xs-12">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2','readonly'=>true)) !!}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::label('status', 'Trạng thái hẹn lịch', array('class' => ' required')) !!}
                        {!! Form::select('status',array(2 => 'Đặt lịch',3 => 'Đến/Mua',4 => 'Đến/Chưa mua',5 => 'Hủy lịch'), null, array('class' => 'form-control','id'=>'update_status')) !!}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::label('category_id', 'Nhóm dịch vụ', array('class' => ' required')) !!}
                        {!! Form::select('category_id',$group, @$item->category_id, array('class' => 'form-control'))!!}
                    </div>
                    <div class="col-md-6 col-xs-12">
                        {!! Form::label('person_action', 'Người tạo', array('class' => ' required')) !!}
                        {!! Form::select('person_action',@$staff, @$item->creator_id, array('id'=>'update_action','class' => 'form-control select2','data-placeholder'=>'người phụ trách','required'=>true,'disabled'=>true)) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                        {!! Form::textArea('note', null, array('class' => 'form-control','id'=>'update_note','rows'=>5)) !!}
                        <span class="help-block">{{ $errors->first('note', ':message') }}</span>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="button" class="btn btn-success" id="save_schedules">Lưu</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

    </div>
</div>
