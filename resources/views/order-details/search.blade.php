<div class="row">
    <div class="col-md-12">
        <div class="input-group" id="adv-search">
            {{--<input type="text" class="form-control" placeholder="Search for snippets" />--}}
            <div class="input-group-btn">
                <div class="btn-group" role="group">
                    <div class="dropdown dropdown-lg" id="showBoxSearch">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret">Lựa chọn điều kiện lọc</span></button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <form class="form-horizontal" role="form" method="get">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            {!! Form::select('group', $group, null, array('class' => 'form-control group', 'placeholder'=>'Chọn nhóm KH')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            {!! Form::text('order_category', null, array('class' => 'form-control', 'placeholder'=>'Nhóm SP')) !!}
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
                                            {!! Form::select('telesale', $telesales, null, array('class' => 'form-control telesale', 'placeholder'=>'Người phụ trách')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            {!! Form::select('order_category', $source, null, array('class' => 'form-control source', 'placeholder'=>'Nguồn KH')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            {!! Form::select('payment_type',[1 => "Tiền mặt", 2 => 'Thẻ'], null, array('class' => 'form-control payment-type', 'placeholder' => 'Hình thức thanh toán')) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            {!! Form::select('marketing', $marketingUsers, null, array('class' => 'form-control marketing', 'placeholder'=>'Người tạo KH')) !!}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
