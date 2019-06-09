@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($doc))
                {!! Form::model($doc, array('url' => url('order-detail/'.$doc->id), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('order-detail.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('user_id', 'Tìm kiếm khách hàng có trên hệ thống', array('class' => ' required')) !!}
                        {!! Form::select('user_id', $customers, null, array('class' => 'form-control select2 user', 'required' => true, 'placeholder' => 'Chọn khách hàng')) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('full_name', 'Tên khách hàng', array('class' => ' required')) !!}
                        {!! Form::text('full_name',null, array('class' => 'form-control full_name', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                        {!! Form::text('phone',null, array('class' => 'form-control phone', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'Địa chỉ', array('class' => ' required')) !!}
                        {!! Form::text('address',null, array('class' => 'form-control address', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
                {{--<div class="col-xs-12 col-md-2">--}}
                    {{--<div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">--}}
                        {{--{!! Form::label('gross_revenue', 'Doanh thu', array('class' => ' required')) !!}--}}
                        {{--{!! Form::number('gross_revenue', null, array('class' => 'form-control gross_revenue')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-primary">
                        <thead style="width: 100%" class="bg-primary text-white">
                        <tr>
                            <th class="text-white text-center">Dịch vụ</th>
                            <th class="text-white text-center">Số lượng</th>
                            <th class="text-white text-center">Đơn giá</th>
                            <th class="text-white text-center">Số buổi</th>
                            <th class="text-white text-center">VAT (%)</th>
                            <th class="text-white text-center">CK (%)</th>
                            <th class="text-white text-center">CK (đ)</th>
                            <th class="text-white text-center">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody class="order">
                            <tr>
                                <td width="250" scope="row">
                                    {!! Form::select('service_id[]', $service, null ,array('id' => "service", 'class' => 'select2 form-control service', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('quantity[]', 1, array('class' => 'form-control quantity', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('price[]', null, array('class' => 'form-control price', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::number('count_day[]', null, array('class' => 'form-control')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('percent_discount[]', 0, array('class' => 'form-control CK1')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                                </td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col bot">
                        <a href="javascript:void(0)" id="add_row" class="red">(+) Thêm sản phẩm</a>
                    </div>
                </div>

            </div>
            <div class="col bot">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('category.index')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).on('click', '#add_row', function() {
            $('.order').append(`
                <tr>
                    <td width="250" scope="row">
                        {!! Form::select('service_id[]', $service, null, array('id' => "service",'class' => 'select2 form-control service', 'required' => true)) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('quantity[]', 1, array('class' => 'form-control quantity', 'required' => true)) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('price[]', null, array('class' => 'form-control price', 'required' => true)) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('percent_discount[]', 0, array('class' => 'form-control CK1')) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                    </td>
                    <td class="text-center"></td>
                </tr>
            `)
        });

        $(document).on('change', '.service', function (e) {
            var target = $(e.target).parent().parent();
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('ajax/info-service') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                $(target).find('.price').val(data['price_sell']);
                $(target).find('.total').val(data['price_sell']);
                $('body').on('keyup', '.price, .VAT, .CK1, .CK2, .quantity', function (e) {
                    let target = $(e.target).parent().parent();
                    var quantity = $(target).find('.quantity').val();
                    var VAT = $(target).find('.VAT').val();
                    var price = $(target).find('.price').val();
                    var CK1 = $(target).find('.CK1').val();
                    var CK2 = $(target).find('.CK2').val();

                    if (CK1 > 0 && CK2 == 0) {
                        $(target).find('.CK2').prop('readonly', true);
                        $(target).find('.CK1').prop('readonly', false);
                    } else if (CK2 > 0 && CK1 == 0) {
                        $(target).find('.CK2').prop('readonly', false);
                        $(target).find('.CK1').prop('readonly', true);
                    } else {
                        $(target).find('.CK2').prop('readonly', false);
                        $(target).find('.CK1').prop('readonly', false);
                    }

                    console.log(price);

                    var total_service = price * quantity + price * quantity * (VAT / 100) - price * quantity * (CK1 / 100) - CK2;
                    $(target).find('.total').val(total_service);
                })
            });
        });

        $('.user').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('ajax/info-customer') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                console.log(data);
                $('.full_name').val(data['full_name']);
                $('.phone').val(data['phone']);
                $('.address').val(data['address']);
            });
        })
    </script>
@endsection
