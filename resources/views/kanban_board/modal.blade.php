<div class="modal fade modal-task" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Lịch CSKH</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(array('url' => null, 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Tên công việc', array('class' => ' required')) !!}
                            <label class="switch" style="float: right">
                                <input name="checkbox" class="checkTask"
                                       type="checkbox">
                                <span class="slider round"></span>
                            </label>
                            {{--{!! Form::hidden('task_id', null, array('id'=>'currentTask')) !!}--}}
                            {!! Form::text('name', null, array('class' => 'form-control','id'=>'name', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        {!! Form::label('customer_id', 'Khách hàng', array('class' => ' required')) !!}
                        <a id="customer" href=""><span class="form-group bold name-customer"> </span></a>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        {!! Form::label('phone', 'SĐT', array('class' => ' required')) !!}
                        {!! Form::text('phone', null, array('class' => 'form-control phone-customer','readonly'=>'true')) !!}

                    </div>
                    <div class="col-xs-12 col-md-4">
                        {!! Form::label('user_id', 'Người phụ trách', array('class' => ' required')) !!}
                        {!! Form::text('user_id', null, array('class' => 'form-control','id'=>'user_id','readonly'=>'true')) !!}
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                            {!! Form::text('date_from', null, array('class' => 'form-control','id'=>'date_from', 'data-toggle' => 'datepicker')) !!}

                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn ( Từ)', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','id'=>'time_from')) !!}
                    </div>
                    <div class="col-md-4 col-xs-12" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_to', 'Giờ hẹn (Tới)', array('class' => ' required')) !!}
                        {!! Form::text('time_to', null, array('class' => 'form-control','id'=>'time_to')) !!}
                    </div>
                    <div class="col-md-12 col-xs-12">

                        {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'description','rows' => 6)) !!}
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
            <div class="modal-footer">
                {{--<button type="submit" class="btn btn-success">Lưu</button>--}}
                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>--}}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

