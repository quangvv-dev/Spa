<div class="col-md-3 no-padd" id="search_box_view">
    <div class="gf-ui-search-box-view">
        <div class="search-group position">
            <div class="btn-group">
                <button class="btn btn-default" id="showBoxSearch"> Lựa chọn điều kiện lọc <span class="caret"></span>
                </button>
            </div>
        </div>
        <div id="boxSearch" class="col-md-9 padding border"
             style="position: absolute; background: rgb(255, 255, 255); z-index: 199; min-width: 910.667px; display: none">
            <form action="">
                <div class="col-md-12 no-padd" id="boxSearchContainer">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('group', $group, null, array('class' => 'form-control group select2', 'placeholder'=>'Chọn nhóm KH')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::text('phone', null, array('class' => 'form-control phone', 'autocomplete' => 'false', 'placeholder'=>'Số điện thoại')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('services', $services, null, array('class' => 'form-control service')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::text('customer', null, array('class' => 'form-control customer', 'placeholder'=>'Tìm theo KH')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('telesales', $telesales, null, array('class' => 'form-control telesales', 'placeholder'=>'Người phụ trách')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('support_id', $ktvUsers, null, array('class' => 'form-control waiters', 'placeholder'=>'KTV phụ trách')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('order_category', $source, null, array('class' => 'form-control source', 'placeholder'=>'Nguồn KH')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('payment_type',\App\Models\PaymentHistory::label, null, array('class' => 'form-control payment-type', 'placeholder' => 'Hình thức thanh toán')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('marketing', $marketingUsers, null, array('class' => 'form-control marketing', 'placeholder'=>'Người tạo KH')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                {!! Form::select('gifts', $gifts, null, array('class' => 'form-control gifts select2', 'placeholder'=>'Quà đã tặng')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12 no-padd tr mt10">
                <button class="btn btn-default" id="closeBoxSearch">Đóng</button>
                <button class="btn btn-info pl5" id="applyBoxSearch">Áp dụng</button>
            </div>
        </div>
    </div>
</div>
