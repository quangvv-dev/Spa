<!-- The Modal -->
<style>
    .datepicker-container.datepicker-dropdown {
        z-index: 9999 !important;
    }
</style>
<div class="modal fade" id="wallet">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(array('url' => route('wallet.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            <div class="modal-body">
                <h4>Nạp tiền vào ví</h4>
                <div class="col row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('price', 'Số tiền nạp', array('class' => ' required')) !!}
                            {!! Form::text('price', null, array('class' => 'form-control','required'=>true,'data-type'=>'currency')) !!}
                            <span class="help-block">{{ $errors->first('price', ':message') }}</span>
                        </div>
                        <input type="hidden" name="customer_id" value="{{request()->segment(2)}}">
                    </div>
                    @if(auth()->user()->permission('edit.order_date'))
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('created_at', 'Ngày nạp', array('class' => ' required')) !!}
                                {!! Form::text('created_at', null, array('class' => 'form-control fc-datepicker')) !!}
                                <span class="help-block">{{ $errors->first('created_at', ':message') }}</span>
                            </div>
                        </div>
                    @endif
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
<script type="text/javascript">
    $('.fc-datepicker').datepicker({
        format: "dd-mm-yyyy",
    }).datepicker("setDate",'now');;
    // $('.select2').select2({ //apply select2 to my element
    //     allowClear: true
    // });
</script>
<script src="{{asset('js/format-number.js')}}"></script>
