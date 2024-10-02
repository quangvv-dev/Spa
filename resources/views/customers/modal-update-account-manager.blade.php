<div class="modal fade modal-custom" id="show-manager-account" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-custom linear-text fs-24" id="example-Modal3">Thay đổi người phụ trách</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => route('customers.update-multiple-status'), 'method' => 'post', 'id'=>'updateStatusCustomer')) !!}
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                            {!! Form::label('user_id', 'Trạng thái', array('class' => ' required')) !!}
                            <select name="telesales_id" id="manager-account" class="form-control select2"
                                    data-placeholder="Chọn nhân viên">
                                <option value=""></option>
                                @foreach($telesales as $k => $l)
                                    <optgroup label="{{ $k }}">
                                        @foreach($l as $kl => $vl)
                                            <option value="{{ $vl }}">{{ $kl }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary update-multiple-account-manager">Lưu</button>
            </div>
        </div>
    </div>
</div>
