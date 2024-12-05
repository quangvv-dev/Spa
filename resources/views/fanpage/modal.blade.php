<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="width: 900px;height: 25%">
            <div class="modal-header">
                <h4>Tạo mới khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('fanpage.store'), 'method' => 'post', 'files'=> true, 'id'=>'fvalidate','autocomplete'=>'off')) !!}
                <div class="row">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                                    {!! Form::label('full_name', 'Tên KH', array('class' => 'control-label')) !!}
                                    {!! Form::text('full_name', null, array('class' => 'form-control')) !!}
                                    <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    {!! Form::label('phone', 'Số điện thoại', array('class' => 'control-label')) !!}
                                    {!! Form::text('phone', null, array('id' => 'phone','class' => 'form-control')) !!}
                                    <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                    {!! Form::label('facebook', 'Link Facebook', array('class' => 'required')) !!}
                                    {!! Form::text('facebook', null, array('id' => 'facebook','class' => 'form-control')) !!}
                                    <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                                    {!! Form::label('birthday', 'Ngày sinh', array('class' => ' required')) !!}
                                    <div class="wd-200 mg-b-30">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            {!! Form::text('birthday', null, array('class' => 'form-control fc-datepicker')) !!}
                                        </div>
                                    </div>
                                </div>
                                <span class="help-block">{{ $errors->first('birthday', ':message') }}</span>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                                    {!! Form::label('description', 'Mô tả', array('class' => ' required')) !!}
                                    {!! Form::text('description', null, array('id' => 'description','class' => 'form-control')) !!}
                                    <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                                    {!! Form::label('address', 'Địa chỉ', array('class' => ' required')) !!}
                                    {!! Form::text('address', null, array('id' => 'address','class' => 'form-control')) !!}
                                    <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('telesales_id') ? 'has-error' : '' }}">
                                    {!! Form::label('telesales_id', 'Người phụ trách', array('class' => ' required')) !!}
                                    {!! Form::select('telesales_id', $telesales,null, array('class' => 'form-control select2', 'placeholder' => 'Chọn nhân viên telesale')) !!}
                                    <span class="help-block">{{ $errors->first('telesales_id', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('status_id') ? 'has-error' : '' }}">
                                    {!! Form::label('status_id', 'Trạng thái', array('class' => 'control-label')) !!}
                                    {!! Form::select('status_id', $status, null, array('class' => 'form-control select2', 'placeholder' => 'Mối quan hệ')) !!}
                                    <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('group_id') ? 'has-error' : '' }}">
                                    {!! Form::label('group_id', 'Nhóm khách hàng', array('class' => 'required control-label')) !!}
                                        {!! Form::select('group_id[]', $group, null, array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder'=> "Chọn nhóm khách hàng" )) !!}
                                        <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>

                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('source_id') ? 'has-error' : '' }}">
                                    {!! Form::label('source_id', 'Nguồn khách hàng', array('class' => 'required control-label')) !!}
                                    {!! Form::select('source_id', $source, null, array('class' => 'form-control select2', 'placeholder' => 'Nguồn khách hàng')) !!}
                                    <span class="help-block">{{ $errors->first('source_id', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group required {{ $errors->has('gender') ? 'has-error' : '' }}">
                                    {!! Form::label('gender', 'Giới tính', array('class' => 'control-label')) !!}
                                    {!! Form::select('gender',[0 => 'Nữ', 1 => 'Nam'], null, array('class' => 'form-control select2', 'placeholder' => 'Chọn giới tính')) !!}
                                    <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-top: 10px">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

