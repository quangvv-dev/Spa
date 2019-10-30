<!-- The Modal -->
<div class="modal fade" id="task">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            {!! Form::open(array('url' => route('task.customer'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}

            <div class="modal-body">
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Tên công việc', array('class' => ' required')) !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('project_id', 'Chọn dự án', array('class' => ' required')) !!}
                            {!! Form::select('project_id',[], null, array('class' => 'form-control select2','placeholder'=>'Chọn dự án')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                            {!! Form::select('type', $type, null, array('class' => 'form-control select2','placeholder'=>'Loại công việc', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('customer_id', 'Khách hàng liên quan', array('class' => ' required')) !!}
                            {!! Form::select('customer_id',$customers, null, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                            {!! Form::text('date_from', null, array('class' => 'form-control','id'=>'update_date', 'data-toggle' => 'datepicker')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                         data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'update_time1')) !!}
                    </div>
                    <div class="col-md-1 no-padd tc mt5 font20"><i class="fa fa-arrow-right"></i></div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('date_to', 'Ngày hẹn(Tới)', array('class' => ' required')) !!}
                            {!! Form::text('date_to', null, array('class' => 'form-control','id'=>'update_date', 'data-toggle' => 'datepicker')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 clockpicker" data-placement="left"
                         data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'update_time2')) !!}
                    </div>
                    <div class="col-md-1 col-xs-12">
                        {!! Form::label('all_day', 'Cả ngày', array('class' => ' required')) !!}
                        {!! Form::checkbox('all_day', null, null) !!}
                    </div>
                </div>
                <div class="col row">
                    <div class="col-md-12 col-xs-12">
                        {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 6)) !!}
                    </div>
                </div>
                <div class="col row" style="margin-top: 15px">
                    <div class="col-md-12 mb10 task_file"><p class="fl pr10 mt5">Tài liệu đính kèm</p>
                        <input type="file" name="file_document">
                    </div>
                </div>
                <div class="col row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Người thực hiện', array('class' => ' required')) !!}
                            {!! Form::select('user_id', $users, null, array('class' => 'form-control select2', 'required' => true, 'placeholder'=>'Người thực hiện',)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('priority', 'Độ ưu tiên', array('class' => ' required')) !!}
                            {!! Form::select('priority', $priority, null, array('class' => 'form-control select2', 'required' => true ,'placeholder'=>'Độ ưu tiên',)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('users', 'Người tham gia', array('class' => ' required')) !!}
                            {!! Form::select('user_id2[]', $users, null, array('class' => 'form-control select2', 'multiple' => 'multiple' , 'data-placeholder'=>'Người tham gia')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>

        </div>
        {{ Form::close() }}
    </div>
</div>
