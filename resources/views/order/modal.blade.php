<div id="paymentModal" class="modal fade mt30 bs-example-modal-sm in"
     tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thanh toán đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => url('order/'.$order->id.'/show'), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
                <div class="row">
                    <div class="col-md-12 no-padd"> <h1 class="tc gray mg0 bold text-center" style="padding: 0px;">{{ number_format($order->the_rest) }}</h1> </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                            {!! Form::label('payment_date', 'Ngày thanh toán', array('class' => ' required')) !!}
                            <input type="text" class="form-control payment-date" id="datepicker" data-toggle="datepicker" name="payment_date" value="{{ $order->now }}" required>
                            <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required">
                            {!! Form::label('phone', 'Số tiền', array('class' => ' required')) !!}
                            {!! Form::select('payment_type',[1 => "Tiền mặt", 2 => 'Thẻ'], null, array('id' => 'phone','class' => 'form-control select2 payment-type', 'placeholder' => 'Hình thức thanh toán', 'required' => true)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group required" style="margin-top: 29px">
                            {!! Form::text('gross_revenue', null, array('class' => 'form-control gross-revenue', "data-type"=>"currency", 'required' => true)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <p>Thanh toán
                            <span class="cash fr"></span>
                        </p>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <p>Còn lại
                            <span class="remain_cash fr"></span>
                        </p>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <p>Tiền trả lại
                            <span class="return_cash fr"></span>
                        </p>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        {!! Form::label('description', 'Ghi chú', array('class' => ' required')) !!}
                        <textarea row="2" class="form-control description" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" id="finish" data-dismiss="modal" class="btn btn-info" style="">
                    <a>Thanh toán</a></button>
                <button type="button" class="btn btn-info" data-dismiss="modal" id="btn_repaid" style="display: none;">
                    Hoàn tiền
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
