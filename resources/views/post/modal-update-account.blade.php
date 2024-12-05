<div class="modal fade" id="show-manager-account" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Thay đổi người phụ trách</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customer_post.update'), 'method' => 'post', 'id'=>'updateStatusCustomer')) !!}
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Trạng thái', array('class' => ' required')) !!}
                            {!! Form::select('telesales_id', $telesales, null, array('class' => 'form-control select2','id'=>'manager-account','placeholder'=>'Tất cả sales')) !!}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success update-multiple-account-manager">Lưu</button>
            </div>
        </div>
    </div>
</div>
