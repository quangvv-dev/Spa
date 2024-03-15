@extends('layout.app')
<link href="{{ asset(('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css')) }}" rel="stylesheet"/>
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => route('campaigns.edit',$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('campaigns.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-md-12 col-xs-12">

                    <div class="col row">
                        <div class="col-6 form-group">
                            {!! Form::label('name', 'Tên chiến dịch', array('class' => ' required control-label')) !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                        </div>
                        <div class="col-3 form-group required {{ $errors->has('start_date') ? 'has-error' : '' }}">
                            {!! Form::label('start_date', 'Ngày BĐ chiến dịch (từ ngày)') !!}
                            <input class="form-control" id="search" autocomplete="off"
                                   data-toggle="datepicker" name="from_date"
                                   type="text"
                                   value="{{isset($order) ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : ''}}">
                        </div>
                        <div class="col-3 form-group required {{ $errors->has('end_date') ? 'has-error' : '' }}">
                            {!! Form::label('end_date', 'Ngày kết thúc chiến dịch (tới ngày) ') !!}
                            <input class="form-control" id="search" autocomplete="off"
                                   data-toggle="datepicker" name="end_date"
                                   type="text"
                                   value="{{isset($order) ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : ''}}">
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('cskh_id', 'CSKH phụ trách', array('class' => ' required control-label')) !!}
                            {!! Form::select('cskh_id', $cskh, null, array('class' => 'form-control select2', 'required' => true,'multiple'=>true, 'data-placeholder'=>'Chọn CSKH',)) !!}
                            <span class="help-block">{{ $errors->first('cskh_id', ':message') }}</span>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('sale_id', 'Telesale phụ trách', array('class' => ' required control-label')) !!}
                            {!! Form::select('sale_id', $sale, null, array('class' => 'form-control select2', 'required' => true,'multiple'=>true, 'data-placeholder'=>'Chọn Sale',)) !!}
                            <span class="help-block">{{ $errors->first('sale_id', ':message') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12" style="border: dotted 2px #45aaf2">
                    <div class="col bot" style="margin-top: 10px">
                        <span class="bold text-warning">TỆP KHÁCH HÀNG</span>
                    </div>

                    <div class="col row">
                        <div class="col-6 form-group">
                            {!! Form::label('branch_id', 'Chi nhánh', array('class' => ' required control-label')) !!}
                            {!! Form::select('branch_id[]', $branchs, null, array('class' => 'form-control select2','id'=>'branchs', 'required' => true,'multiple'=>true, 'data-placeholder'=>'Chọn chi nhánh',)) !!}
                            <span class="help-block">{{ $errors->first('branch_id', ':message') }}</span>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('customer_status', 'Mối quan hệ', array('class' => ' required control-label')) !!}
                            {!! Form::select('customer_status[]', $status, null, array('class' => 'form-control select2','id'=>'customer_status', 'required' => true,'multiple'=>true, 'data-placeholder'=>'Chọn chi nhánh',)) !!}
                            <span class="help-block">{{ $errors->first('status_id', ':message') }}</span>
                        </div>
                        <div class="col-3 form-group required {{ $errors->has('start_date') ? 'has-error' : '' }}">
                            {!! Form::label('start_date', 'Ngày phát sinh đơn hàng (từ ngày)') !!}
                            <input class="form-control" id="search" autocomplete="off"
                                   data-toggle="datepicker" name="from_order"
                                   type="text"
                                   value="{{isset($order) ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : ''}}">
                        </div>
                        <div class="col-3 form-group required {{ $errors->has('end_date') ? 'has-error' : '' }}">
                            {!! Form::label('end_date', 'Ngày phát sinh đơn hàng (tới ngày) ') !!}
                            <input class="form-control" id="search" autocomplete="off"
                                   data-toggle="datepicker" name="to_order"
                                   type="text"
                                   value="{{isset($order) ? \Carbon\Carbon::parse($order->date)->format('d/m/Y') : ''}}">
                        </div>
                    </div>
                    <span><i class="alert-file text-danger"></i></span>

                    <div class="col bot" style="margin-top: 5px">
                        <button type="button" class="btn btn-primary" id="test-file">K.tra tệp <i
                                class="fas fa-sync"></i></button>
                    </div>
                </div>
            </div>
            <div class="col bot" style="margin-top: 10px">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('category.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>

    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>

        $('body').on('click', '#test-file', function (e) {
            let from_order = $('input[name=from_order]').val();
            let to_order = $('input[name=to_order]').val();
            let branch = $('#branchs').val();
            let status = $('#customer_status').val();
            $.ajax({
                url: "{{ Url('/ajax/check-campaign') }}",
                method: "get",
                data: {
                    from_order: from_order,
                    to_order: to_order,
                    branch: branch,
                    status: status
                }
            }).then(function (data) {
                $('.alert-file').html('Tệp có '+data+' khách hàng !');
            });
        });
        $('body').on('keyup', '.price', function (e) {
            let price = $(this).val();
            price = formatNumber(price);
            $(this).val(price);
        });

        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true,
                zIndex: 2048,
            });
            $('form#fvalidate').validate({
                rules: {
                    name: 'required',
                },
                messages: {
                    name: "vui lòng nhâp tên danh mục",
                }
            });
        })
    </script>
@endsection
