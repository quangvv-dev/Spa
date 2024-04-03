<div class="col-md-12 col-lg-12">
                                <span class="bold text-warning" style="font-size: 12px"><i
                                        class="fa fa-info-circle"></i><i>Hạn mức thăng hạng khách hàng theo số đơn hàng KH đã sử dụng !!!</i></span>
    <div class="card">
        {!! Form::open(array('url' => route('settings.storeRank'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
        <div class="col row">
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('silver', 'Thăng hạn rank Người mua hàng (Sliver)', array('class' => 'control-label required')) !!}
                    {!! Form::text('silver',@number_format(setting('silver')), array('class' => 'form-control')) !!}
                    <span
                        class="help-block">{{ $errors->first('silver', ':message') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('platinum', 'Thăng hạn rank Khách hàng VIP', array('class' => 'control-label required')) !!}
                    {!! Form::text('platinum',@number_format(setting('platinum')), array('class' => 'form-control')) !!}
                    <span
                        class="help-block">{{ $errors->first('platinum', ':message') }}</span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('gold', 'Thăng hạn rank Khách hàng (GOLD)', array('class' => 'control-label required')) !!}
                    {!! Form::text('gold',@number_format(setting('gold')), array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('gold', ':message') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::label('exchange', '% Hoa hồng CTV', array('class' => 'control-label required')) !!}
                    {!! Form::text('exchange',@number_format(setting('exchange')), array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('exchange', ':message') }}</span>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('server_call_center', 'SERVER TỔNG ĐÀI', array('class' => 'control-label required')) !!}
                    {!! Form::select('server_call_center',[\App\Constants\StatusCode::SERVER_3CX=>'Sever 3CX',\App\Constants\StatusCode::SERVER_CGV_TELECOM=>'Sever CGV_Telecom',\App\Constants\StatusCode::SERVER_GTC_TELECOM=>'Server GtcTelecom' ], @setting('server_call_center'), array('class' => 'form-control','data-placeholder'=>'Danh mục cha')) !!}
                </div>
                <div class="form-group"></div>
            </div>
        </div>
        <hr class="mt-2 mb-2">
        <div class="col row">
            <div class="col-md-6 col-xs-12">
                <div class="">
                    <h5 style="color: #e10a46">TH: 01 NHÂN VIÊN PHỤ TRÁCH</h5>
                </div>
                <div class="form-group">
                    {!! Form::label('exchange_yta_single', 'Hoa hồng y tá', array('class' => 'control-label required')) !!}
                    {!! Form::text('exchange_yta_single',@number_format(setting('exchange_yta_single')), array('class' => 'form-control number')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('exchange_support_single', '% Hoa hồng tư vấn', array('class' => 'control-label required')) !!}
                    {!! Form::text('exchange_support_single',@@number_format(setting('exchange_support_single')), array('class' => 'form-control number')) !!}
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="col-12">
                    <h5 style="color: #e10a46">TH: 02 NHÂN VIÊN PHỤ TRÁCH</h5>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('exchange_yta1', 'Hoa hồng y tá chính', array('class' => 'control-label required')) !!}
                            {!! Form::text('exchange_yta1',@number_format(setting('exchange_yta1')), array('class' => 'form-control number')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('exchange_yta2', 'Hoa hồng y tá phụ', array('class' => 'control-label required')) !!}
                            {!! Form::text('exchange_yta2',@number_format(setting('exchange_yta2')), array('class' => 'form-control number')) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('exchange_support1', '% Hoa hồng tư vấn chính', array('class' => 'control-label required')) !!}
                            {!! Form::text('exchange_support1',@@number_format(setting('exchange_support1')), array('class' => 'form-control number')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('exchange_support2', '% Hoa hồng tư vấn phụ', array('class' => 'control-label required')) !!}
                            {!! Form::text('exchange_support2',@number_format(setting('exchange_support2')), array('class' => 'form-control number')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<hr class="mt-2 mb-2">--}}

        <div class="col row">
            <div class="col-md-6 col-xs-12 bot" style="margin-top: 5px">
                <button type="submit" class="btn btn-success" id="click-sent">Lưu
                </button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
