@extends('layout.app')
@section('content')
    <style>
        label.required:after {
            content: " *";
            color: red;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1 ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class=""><a href="#tab1" class="active" data-toggle="tab">Cài đặt chung CRM</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active " id="tab1">
                            <div class="col-md-12 col-lg-12">
                                <span class="bold text-warning" style="font-size: 12px"><i class="fa fa-info-circle"></i><i>Hạn mức thăng hạng khách hàng theo số đơn hàng KH đã sử dụng !!!</i></span>
                                <div class="card">
                                    {!! Form::open(array('url' => route('settings.storeRank'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate','class'=>'sent-sms')) !!}
                                    <div class="col row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('silver', 'Thăng hạn rank Khách hàng (Membership)', array('class' => 'control-label required')) !!}
                                                {!! Form::text('silver',@number_format(setting('silver')), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('silver', ':message') }}</span>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('platinum', 'Thăng hạn rank Cộng tác viên (Platinum)', array('class' => 'control-label required')) !!}
                                                {!! Form::text('platinum',@number_format(setting('platinum')), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('platinum', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                {!! Form::label('gold', 'Thăng hạn rank Khách hàng thân thiết (GOLD)', array('class' => 'control-label required')) !!}
                                                {!! Form::text('gold',@@number_format(setting('gold')), array('class' => 'form-control')) !!}
                                                <span class="help-block">{{ $errors->first('gold', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="col bot" style="margin-top: 5px">
                                            <button type="submit" class="btn btn-success" id="click-sent">Lưu
                                            </button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('_script')
    <script src="{{asset('js/format-number.js')}}"></script>
    <script>
        $(document).on('keyup', '.number', function () {
            let earn = $(this).val();
            $(this).val(formatNumber(earn));
        })
    </script>
@endsection
