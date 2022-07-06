<style>
    .select2-results__option {
        color: #0a0c0d !important;
    }
</style>
<div class="modal fade" id="updateHistoryOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Kỹ thuật viên chính', array('class' => ' required')) !!}
                            {!! Form::select('user_id', $waiters, null, array('class' => 'form-control select2')) !!}
                            <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required {{ $errors->has('support_id') ? 'has-error' : '' }}">
                            {!! Form::label('support_id', 'Người hỗ trợ (nếu có)') !!}
                            {!! Form::select('support_id', $waiters, null, array('class' => 'form-control select2','placeholder'=>'Chon KTV')) !!}
                            <span class="help-block">{{ $errors->first('support_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required {{ $errors->has('support_id') ? 'has-error' : '' }}">
                            {!! Form::label('support2_id', 'Người hỗ trợ 2 (nếu có)') !!}
                            {!! Form::select('support2_id', $waiters, null, array('class' => 'form-control select2','placeholder'=>'Chon KTV 2')) !!}
                            <span class="help-block">{{ $errors->first('support2_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('service_id', 'Dịch vụ', array('class' => ' required')) !!}
                            {!! Form::select('service_id', [], null, array('id'=>'service_modal','class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('service_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('type_delete', 'Loai') !!}
                            {!! Form::select('type_delete', [0 => 'Trừ liệu trình', 1 => 'Đã bảo hành', 2 => 'Đang bảo lưu'], null, array('class' => 'form-control')) !!}
                            <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group required {{ $errors->has('tip_id') ? 'has-error' : '' }}">
                            {!! Form::label('tip_id', 'Thủ thuật (nếu có)') !!}
                            {!! Form::select('tip_id',$tips, null, array('class' => 'form-control select2','placeholder'=>'Chọn thủ thuật')) !!}
                            <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                        </div>
                    </div>
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
<script>
    $('.select2').select2({ //apply select2 to my element
        allowClear: true,
        dropdownParent: $('#example-Modal3')
    });
</script>
