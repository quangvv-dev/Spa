<div class="row col-md-6">
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('group', $group, null, array('class' => 'form-control group', 'placeholder'=>'Chọn nhóm KH')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::text('order_category', null, array('class' => 'form-control', 'placeholder'=>'Nhóm SP')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('services', $services, null, array('class' => 'form-control service')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::text('customer', null, array('class' => 'form-control customer', 'placeholder'=>'Tìm theo KH')) !!}
        </div>
    </div>
</div>
<div class="row col-md-6">
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('telesale', $telesales, null, array('class' => 'form-control telesale', 'placeholder'=>'Người phụ trách')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('order_category', $source, null, array('class' => 'form-control source', 'placeholder'=>'Nguồn KH')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('payment_type',[1 => "Tiền mặt", 2 => 'Thẻ'], null, array('class' => 'form-control payment-type', 'placeholder' => 'Hình thức thanh toán')) !!}
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="form-group">
            {!! Form::select('marketing', $marketingUsers, null, array('class' => 'form-control marketing', 'placeholder'=>'Người tạo KH')) !!}
        </div>
    </div>
</div>
