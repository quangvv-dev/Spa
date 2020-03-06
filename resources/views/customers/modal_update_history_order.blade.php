<div class="modal fade" id="updateHistoryOrderModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Liệu trình</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('method' => 'put', 'id'=>'historyUpdateOrrder')) !!}
                    <div class="col row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                {!! Form::label('user_id', 'Kỹ thuật viên', array('class' => ' required')) !!}
                                {!! Form::select('user_id', $waiters, null, array('class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                {!! Form::label('type_delete', 'Loai') !!}
                                 {!! Form::select('type_delete', [0 => 'Trong liệu trình', 1 => 'Đã bảo hành', 2 => 'Đang bảo lưu'], null, array('class' => 'form-control select2')) !!}
                                <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                                {!! Form::label('description', 'Ghi chú', array('class' => ' required')) !!}
                                {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 3)) !!}
                                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success save-update-history-order">Lưu</button>
            </div>
        </div>
    </div>
</div>
