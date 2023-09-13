<div class="modal fade" id="show-branch-account" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Chuyển chi nhánh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customers.update-multiple-branch'), 'method' => 'post', 'id'=>'updateStatusCustomer')) !!}
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required')) !!}
                            {!! Form::select('branch_id',@$branchs, null, array( 'id'=>'changeBranch','class' => 'form-control select2','placeholder'=>'Chọn chi nhánh','required'=>true)) !!}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success update-multiple-branch">Lưu</button>
            </div>
        </div>
    </div>
</div>
