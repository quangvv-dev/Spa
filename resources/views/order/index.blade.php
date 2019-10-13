@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
            </div>

            @if (isset($order))
                {!! Form::model($order, array('url' => url('orders/'.$order->id. '/edit'), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('order-detail.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('user_id', 'Tìm kiếm khách hàng có trên hệ thống', array('class' => ' required')) !!}
                        @if(isset($customer))
                            <select class="form-control select2 user" name="user_id" required="required"  data-placeholder="Chọn khách hàng">
                                @foreach($customers as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $customer->id ? 'selected' : "" }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        @else
                            {!! Form::select('user_id', $customers, null, array('class' => 'form-control select2 user', 'required' => true, 'placeholder' => 'Chọn khách hàng')) !!}
                            @endif
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                        {!! Form::label('full_name', 'Tên khách hàng', array('class' => ' required')) !!}
                        {!! Form::text('full_name',$customer ? $customer->full_name: null , array('class' => 'form-control full_name', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                        {!! Form::text('phone', $customer ? $customer->phone: null, array('class' => 'form-control phone', 'required' => true)) !!}
                        <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'Địa chỉ', array('class' => ' required')) !!}
                        {!! Form::text('address', $customer ? $customer->address: null, array('class' => 'form-control address')) !!}
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('status_id', 'Trạng thái', array('class' => ' required')) !!}
                        @if(isset($customer))
                            <select id="status" class="form-control select2" name="status_id" required="required"  data-placeholder="Trạng thái">
                                @foreach($status as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $customer->status_id ? 'selected' : "" }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        @else
                            {!! Form::select('status_id', $status, null, array('class' => 'form-control select2','id'=>'status', 'required' => true, 'placeholder' => 'Trạng thái')) !!}
                        @endif
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap table-primary">
                        <thead style="width: 100%" class="bg-primary text-white">
                        <tr>
                            <th class="text-white text-center">Dịch vụ</th>
                            <th class="text-white text-center">Số lượng</th>
                            <th class="text-white text-center">Đơn giá</th>
                            <th class="text-white text-center">VAT (%)</th>
                            <th class="text-white text-center">CK (đ)</th>
                            <th class="text-white text-center">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody class="order">
                        @if(!empty($order))
                            @foreach($order->orderDetails as $orderDetail)
                            <tr>
                                <td width="250" scope="row">
                                    {!! Form::text('order_detail_id[]', $orderDetail->id, array('class' => 'form-control hidden')) !!}
                                    {!! Form::select('service_id[]', $services, $orderDetail->booking_id ,array('id' => "service", 'class' => 'select2 form-control service', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('quantity[]', $orderDetail->quantity, array('class' => 'form-control quantity', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('price[]', $orderDetail->price, array('class' => 'form-control price', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('vat[]', $orderDetail->vat, array('class' => 'form-control VAT')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('number_discount[]', $orderDetail->number_discount, array('class' => 'form-control CK2')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('total_price[]', $orderDetail->total_price, array('class' => 'form-control total','readonly'=>true)) !!}
                                </td>
                                <td class="tc vertical-middle remove_row">
                                    <button class='btn btn-danger'>X</button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td width="250" scope="row">
                                    {!! Form::select('service_id[]', $services, null ,array('id' => "service", 'class' => 'select2 form-control service', 'required' => true)) !!}
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
                                    {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                                </td>
                                <td class="tc vertical-middle remove_row">
                                    <button class='btn btn-danger'>X</button>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="col bot">
                        <a href="javascript:void(0)" id="add_row" class="red">(+) Thêm sản phẩm</a>
                    </div>
                    <div class="col row">
                        <div class="col-md-3">
                            {!! Form::label('count_day', 'Số buổi liệu trình (nếu có)') !!}
                            {!! Form::number('count_day', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('spa_therapisst_id', 'Kỹ thuật viên') !!}
                            {!! Form::select('spa_therapisst_id', $spaTherapissts, null, array('class' => 'form-control select2', 'placeholder' => 'Chọn kỹ thuật viên')) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="col bot" style="margin-top: 10px;">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('order.list')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection
@section('_script')
    <script>
        $(document).on('click', '#add_row', function () {
            $('.order').append(`
                <tr>
                    <td width="250" scope="row">
                        {!! Form::select('service_id[]', $services, null, array('id' => "service",'class' => 'select2 form-control service', 'required' => true)) !!}
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
                        {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                    </td>
                    <td class="tc vertical-middle remove_row"><button class='btn btn-danger'>X</button></td>
            </tr>
`)
        });

        $(document).on('change', '.service', function (e) {
            let target = $(e.target).parent().parent();
            let id = $(this).val();
            $.ajax({
                url: "{{ Url('ajax/info-service') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                $(target).find('.price').val(data['price_sell']);
                $(target).find('.total').val(data['price_sell']);
            });
        });

        $('body').on('keyup', '.price, .VAT, .CK1, .CK2, .quantity', function (e) {
            let target = $(e.target).parent().parent();
            let quantity = $(target).find('.quantity').val();
            let VAT = $(target).find('.VAT').val();
            let price = $(target).find('.price').val();
            let CK2 = $(target).find('.CK2').val();

            let total_service = price * quantity + price * quantity * (VAT / 100) - CK2;
            $(target).find('.total').val(total_service);
        })

        $('.user').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ Url('ajax/info-customer') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                $('.full_name').val(data['full_name']);
                $('.phone').val(data['phone']);
                $('.address').val(data['address']);
                $('#status').val(data['status_id']).trigger( "change" );
            });
        });

        $(document).on('click', '.remove_row', function (e) {
            $(e.target).parent().parent().remove();
        });

        $("#fvalidate").validate({
            rules: {
                user_id: {
                    required: true
                },
                full_name: {
                    required: true
                },
                phone: {
                    required: true
                },
                status_id: {
                    required: true
                },
                'service_id[]': {
                    required: true
                },
                'price[]': {
                    required: true
                },
            },
            messages: {
                user_id: "Chưa chọn khách hàng",
                full_name: {
                    required: "Tên khách hàng không được để trống",
                },
                phone: "Số điện thoại không được để trống",
                status_id: "Chưa chọn trạng thái",
                'service_id[]': "Chưa chọn dịch vụ",
                'price[]': "Chưa nhập giá",
            },
        });

    </script>
@endsection
