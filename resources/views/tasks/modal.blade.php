<div class="modal fade modal-custom" id="modalTask" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chi tiết lịch CSKH</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(array('url' => route('tasks.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Tên công việc', array('class' => ' required')) !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    {!! Form::hidden('customer_id', @$customer->id, array('class' => 'form-control')) !!}
                    {!! Form::hidden('code', 'CSKH', array('class' => 'form-control')) !!}
                    {!! Form::hidden('ajax', 'Task', array('class' => 'form-control')) !!}
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                            {!! Form::text('date_from', null, array('class' => 'form-control','id'=>'date_from', 'data-toggle' => 'datepicker')) !!}

                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control','required'=>true)) !!}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                        {!! Form::select('type', [3=>'Của tôi',\App\Constants\StatusCode::GOI_LAI=>'Gọi lại (phân bổ cho Telesale)',\App\Constants\StatusCode::CSKH=>'CSKH (phân bổ cho CSKH)'], null,
                        array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-12 col-xs-12">
                        {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'description','rows' => 6)) !!}
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
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
<div class="modal fade modal-custom" id="modalUpdateTask" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Cập nhật công việc</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(array('url' => "", 'method' => 'put', 'files'=> true,'class'=>'formUpdateTask','id'=>'fvalidate','enctype'=>'multipart/form-data','autocomplete'=>'off')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Tên công việc', array('class' => ' required')) !!}
                            {!! Form::text('name', null, array('class' => 'form-control','id'=>'name_update', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    {!! Form::hidden('customer_id', @$customer->id, array('class' => 'form-control','id'=>'customer_update')) !!}
                    {{--{!! Form::hidden('code', 'CSKH', array('class' => 'form-control')) !!}--}}
                    {!! Form::hidden('ajax', 'Task', array('class' => 'form-control')) !!}
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('date_from', 'Ngày hẹn(Từ)', array('class' => ' required')) !!}
                            {!! Form::text('date_from', null, array('class' => 'form-control date_update','id'=>'date_from', 'data-toggle' => 'datepicker')) !!}

                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12 clockpicker" data-placement="left" data-align="top"
                         data-autoclose="true">
                        {!! Form::label('time_from', 'Giờ hẹn', array('class' => ' required')) !!}
                        {!! Form::text('time_from', null, array('class' => 'form-control time_from','required'=>true)) !!}
                    </div>
                    <div class="col-md-4 col-xs-12">
                        {!! Form::label('type', 'Loại công việc', array('class' => ' required')) !!}
                        {!! Form::select('type', [3=>'Của tôi',\App\Constants\StatusCode::GOI_LAI=>'Gọi lại (phân bổ cho Telesale)',\App\Constants\StatusCode::CSKH=>'CSKH (phân bổ cho CSKH)'], null,
                        array('class' => 'form-control','id'=>'updateType')) !!}
                    </div>
                    <div class="col-md-12 col-xs-12">
                        {!! Form::label('description', 'Nội dung', array('class' => ' required')) !!}
                        {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'description_update','rows' => 6)) !!}
                    </div>
                    <div class="col-md-12" style="padding-top: 10px">
                        <button type="submit" class="btn btn-success">Lưu</button>
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

