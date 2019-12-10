<div class="modal fade" id="updateRelation" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Thay đổi mối quan hệ hàng loạt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customers.update-multiple-status'), 'method' => 'put', 'id'=>'updateRelationCustomer')) !!}
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Mối quan hệ', array('class' => ' required')) !!}
                            {!! Form::select('user_id', $status, null, array('class' => 'form-control select2 status-customer', 'required' => 'required')) !!}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success update-multiple-status">Lưu</button>
            </div>
        </div>
    </div>
</div>
