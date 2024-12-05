<!-- The Modal -->
<div class="modal fade" id="wallet">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(array('url' => route('wallet.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            <div class="modal-body">
                <h4>Nạp tiền vào ví</h4>
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('package_id', 'Gói nạp', array('class' => ' required')) !!}
                            {!! Form::select('package_id',$package, null, array('class' => 'form-control select2','required'=>true,'placeholder'=>'Chọn gói nạp')) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                        <input type="hidden" name="customer_id" value="{{request()->segment(2)}}">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Tạo đơn nạp</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>

        </div>
        {{ Form::close() }}
    </div>
</div>
<script>
    $('.select2').select2({ //apply select2 to my element
        allowClear: true
    });
</script>
