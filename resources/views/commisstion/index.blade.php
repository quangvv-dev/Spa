@extends('layout.app')
@section('content')
    <style>
        a#remove {
            color: #fb8787;
            margin-top: 34px !important;
        }
    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('commission/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => url()->full(), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col order" style="padding: 10px">
                @if(isset($commissions) && $commissions)
                    @foreach($commissions as $item)
                        <div class="row">
                            <div class="col-xs-12 col-md-3">
                                {!! Form::label('user_id', 'Nhân viên hưởng', array('class' => ' required')) !!}
                                {!! Form::select('user_id', $customers, $item->user_id, array('class' => 'form-control select2 user', 'required' => true,'disabled'=>true, 'placeholder' => 'Chọn nhân viên')) !!}
                                {!! Form::hidden('user_id', null, array('class' => 'form-control','readonly'=>true,'required'=>true)) !!}
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div class="form-group required {{ $errors->has('earn') ? 'has-error' : '' }}">
                                    {!! Form::label('earn', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                                    {!! Form::text('earn', $item->earn, array('class' => 'form-control rose_price number','readonly'=>true,'required'=>true)) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div class="form-group required {{ $errors->has('earn') ? 'has-error' : '' }}">
                                    {!! Form::label('earn', 'Hoa hồng hưởng (VNĐ)', array('class' => ' required')) !!}
                                    {!! Form::text('earn', $item->earn, array('class' => 'form-control rose_price number','readonly'=>true,'required'=>true)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="form-group required {{ $errors->has('note') ? 'has-error' : '' }}">
                    {!! Form::label('note', 'Ghi chú', array('class' => ' required')) !!}
                    {!! Form::textarea('note', null, array('class' => 'form-control', 'rows' => 3)) !!}
                </div>
            </div>
            <div class="col bot">
                <a href="javascript:void(0)" id="add_row" class="red">(+)Tạo người hưởng</a>
            </div>

            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{url('list-orders')}}" class="btn btn-danger">Về danh sách đơn hàng</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        $('.number').number(true);
        $(document).on('click', '#add_row', function () {
            $('.order').append(
            `<div class="add-commission">
                <div class="row item-file">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group required {{ $errors->has("full_name") ? "has-error" : "" }}">
                            {!! Form::label("user_id", "Nhân viên hưởng", array("class" => "required")) !!}
                            {!! Form::select("user_id", $customers, null, array("class" => "form-control select2 user", "required" => true, "placeholder" => "Chọn nhân viên")) !!}
                            <span class="help-block">{{ $errors->first("full_name", ":message") }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group required">
                            {!! Form::label("service_id", "Dịch vụ", array("class" => "required")) !!}
                            {!! Form::select("service_id", $services, null, array("class" => "form-control select2","required" => true, "placeholder" => "Chọn dịch vụ")) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group required">
                            {!! Form::label("percent", "Hoa hồng hưởng (%)", array("class" => "required")) !!}
                            {!! Form::text("percent", null, array("class" => "form-control number","required" => true)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1" style="margin-top:34px">
                        <a class="remove"> <i class="fa fa-times fa-2x"></i> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <a href="javascript:void(0)" id="add_service" class="red add_service">(+)Thêm dịch vụ</a>
                    </div>
                   <div class="row more-service">

                   </div>
                </div>

                </div>
                `);
            $('.number').number(true);
            $("#fvalidate").validate({
                rules: {
                    customer_id: {
                        required: true
                    },
                    rose_price: {
                        required: true
                    }
                },
                messages: {
                    customer_id: "Vui lòng chọn nhân viên hưởng",
                    rose_price: "Vui lòng nhập số tiền hưởng",
                },
            });

            $('.remove').click(function () {
                const parent = $(this).closest('.add-commission');
                parent.remove();
            });
            $('.select2').select2({
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                placeholder: function () {
                    $(this).data('placeholder');
                }
            });

            $('.select2-hidden-accessible').on('change', function () {
                $(this).valid();
            });
        });
        $("#fvalidate").validate({
            rules: {
                customer_id: {
                    required: true
                },
                rose_price: {
                    required: true
                }
            },
            messages: {
                customer_id: "Vui lòng chọn nhân viên hưởng",
                rose_price: "Vui lòng nhập số tiền hưởng",
            },
        });

        $(document).on('click', '.add_service', function (e) {
            let target = $(e.target).parent().parent();
            const add_service = $(target).find('.more-service');

            $(add_service).append(`
                <div class="col-xs-12 col-md-2" style="float: left">
                    <div class="form-group required">
                        {!! Form::label("service_id", "Dịch vụ", array("class" => "required")) !!}
                    {!! Form::select("service_id", $services, null, array("class" => "form-control select2","required" => true, "placeholder" => "Chọn dịch vụ")) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-md-2" style="float: left">
                    <div class="form-group required">
                        {!! Form::label("percent", "Hoa hồng hưởng (%)", array("class" => "required")) !!}
                        {!! Form::text("percent", null, array("class" => "form-control number","required" => true)) !!}
                    </div>
                </div>
            `);
            $('.select2').select2({
                width: '100%',
                theme: 'bootstrap',
                allowClear: true,
                placeholder: function () {
                    $(this).data('placeholder');
                }
            });
        });

    </script>
@endsection
