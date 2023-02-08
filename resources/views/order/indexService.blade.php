@extends('layout.app')
@section('_style')
    <link href="{{asset('assets/plugins/image-picker/image-picker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/order-new-design.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')

    <div class="col-md-12 col-lg-12">
        <div class="card">
            {{--<div class="card-header">--}}
            {{--<h3 class="card-title">{{$title}}</h3>--}}
            {{--</div>--}}
            @if (isset($order))
                {!! Form::model($order, array('url' => url('orders/'.$order->id. '/edit'), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('order-detail.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="color-h1">Thông tin khách hàng</h4>
                    </div>
                </div>
                <div class="row">
                    @if(isset($customer))
                        {!! Form::hidden('user_id', $customer->id, array('class' => 'form-control', 'required' => true)) !!}
                    @endif
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('full_name') ? 'has-error' : '' }}">
                            {!! Form::label('full_name', 'Tên khách hàng', array('class' => ' required')) !!}
                            {!! Form::text('full_name',$customer ? $customer->full_name: null , array('class' => 'form-control full_name input-custom', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('full_name', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('phone') ? 'has-error' : '' }}">
                            {!! Form::label('phone', 'Số điện thoại', array('class' => ' required')) !!}
                            {!! Form::text('phone', $customer ? $customer->phone: null, array('class' => 'form-control phone input-custom', 'required' => true)) !!}
                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                            {!! Form::label('address', 'Địa chỉ', array('class' => ' required')) !!}
                            {!! Form::text('address', $customer ? $customer->address: null, array('class' => 'form-control address input-custom')) !!}
                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group required {{ $errors->has('address') ? 'has-error' : '' }}">
                            {!! Form::label('status_id', 'Trạng thái', array('class' => ' required')) !!}
                            @if(isset($customer))
                                <select id="status" class="form-control select2" name="status_id" required="required"
                                        data-placeholder="Trạng thái">
                                    @foreach($status as $key => $value)
                                        <option
                                                value="{{ $key }}" {{ $key == $customer->status_id ? 'selected' : "" }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            @else
                                {!! Form::select('status_id', $status, null, array('class' => 'form-control select2','id'=>'status', 'required' => true, 'placeholder' => 'Trạng thái')) !!}
                            @endif
                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h4 class="col-2 color-h1">Thông tin dịch vụ</h4>
                    <div class="col-md-2">
                        <a href="javascript:void(0)" id="add_row" class="red bold d-flex">Thêm dịch vụ &nbsp;
                            <span class="icon-plus"><i class="fa fa-plus"></i></span>
                        </a>
                    </div>
                    @if(request()->get('type')=='combos'||@$role_type ==3)
                        <div class="col-md-2">
                            <a href="javascript:void(0)" id="add_row2" class="red bold d-flex">Thêm sản phẩm &nbsp;
                                <span class="icon-plus"><i class="fa fa-plus"></i></span>
                            </a>
                        </div>
                    @endif
                </div>


                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap">
                        <thead class="bg-primary">
                        <tr style="white-space: nowrap">
                            <th class="custom-th text-center" width="350px">Dịch vụ</th>
                            <th class="custom-th text-center">S.buổi | SL</th>
                            <th class="custom-th text-center">Đơn giá</th>
                            {{--<th class="text-white text-center">VAT (%)</th>--}}
                            <th class="custom-th text-center">CK(%)</th>
                            <th class="custom-th text-center">CK(đ)</th>
                            <th class="custom-th text-center" colspan="2">Thành tiền</th>
                            <th class="custom-th text-center"></th>
                        </tr>
                        </thead>
                        <tbody class="order">

                        @if(!empty($order))
                            @foreach($order->orderDetails as $orderDetail)
                                <tr>
                                    <td class="width350">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-10">
                                                {!! Form::text('order_detail_id[]', $orderDetail->id, array('class' => 'form-control hidden')) !!}
                                                <select class="select2 form-control service" required id="service" name="service_id[]">
                                                    <option>-Chọn dịch vụ-</option>
                                                    @if($orderDetail->service->type == \App\Constants\StatusCode::PRODUCT)
                                                        @foreach($products as $service)
                                                            <option
                                                                    value="{{$service->id}}" {{$service->id == $orderDetail->booking_id ? "selected": ""}} >{{@$service->category->name}}
                                                                - {{$service->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach($services as $service)
                                                            <option
                                                                    value="{{$service->id}}" {{$service->id == $orderDetail->booking_id ? "selected": ""}} >{{@$service->category->name}}
                                                                - {{$service->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <span class="btn btn-default col-md-1 no-padd add_note" style="height:34px; background-color: #ffffff;"> <i
                                                        class="fa fa-plus font16" aria-hidden="true"></i> </span>
                                            <textarea class="product_note form-control pt5 italic" style="margin-left: 12px; display: none" placeholder="Ghi chú"
                                                      name="service_note[]">{{@$orderDetail->service->description}}</textarea>
                                        </div>
                                    </td>
                                    <td class="text-center" width="50">
                                        @if(@$orderDetail->service->type == \App\Constants\StatusCode::PRODUCT)
                                            {!! Form::text('quantity[]', $orderDetail->quantity, array('class' => 'form-control quantity input-custom', 'required' => true)) !!}
                                            {{--                                            {!! Form::hidden('days[]', 0, array('class' => 'form-control input-custom', 'required' => true)) !!}--}}
                                        @else
                                            {{--                                            {!! Form::hidden('quantity[]', 0, array('class' => 'form-control quantity input-custom', 'required' => true)) !!}--}}
                                            {!! Form::text('days[]', @$orderDetail->days, array('class' => 'form-control input-custom', 'required' => true)) !!}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {!! Form::text('price[]', number_format($orderDetail->price), array('class' => 'form-control price input-custom', 'required' => true)) !!}
                                    </td>
                                    {{--<td class="text-center">--}}
                                    {{--{!! Form::text('vat[]', $orderDetail->vat, array('class' => 'form-control VAT')) !!}--}}
                                    {{--</td>--}}
                                    <td class="text-center">
                                        <input type="text" class="form-control CK1 input-custom" value="0">
                                    </td>
                                    <td class="text-center">
                                        {!! Form::text('number_discount[]', number_format($orderDetail->number_discount), array('class' => 'form-control CK2 input-custom')) !!}
                                    </td>
                                    <td class="text-center" colspan="2">
                                        {!! Form::text('total_price[]', number_format($orderDetail->total_price), array('class' => 'form-control total input-custom','readonly'=>true)) !!}
                                    </td>
                                    <td class="tc vertical-middle remove_row">
                                        {{--<button class='btn btn-secondary'><i class="fa-trash fa"></i></button>--}}
                                        <img class="pointer" src="{{asset('assets/images/delete.png')}}" alt="">
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <h4 class="color-h1">Thông tin khác</h4>
                    </div>
                    <div class="col-6 div-left">
                        {!! Form::hidden('role_type', @$order->role_type, array('id' => 'role_type')) !!}
                        <input type="hidden" name="spa_therapisst_id" id="spa_therapisst_id" value="{{@$order->spa_therapisst_id}}">
                        <div class="box-add user-bac-sy">
                            <div class="btn-icon">
                                <span class="icon-plus"><i class="fa fa-plus"></i></span>
                                <br>
                                <span class="chon-bac-si">Chọn B.Sĩ</span>
                                <span class="small-tip small-tip-custom text-bac-si">{{@$order->spaTherapisst->full_name}}</span>
                            </div>
                        </div>
                        {{--<div class="box-add">--}}
                        {{--<div class="btn-icon">--}}
                        {{--<span class="icon-plus"><i class="fa fa-plus"></i></span>--}}
                        {{--<br>--}}
                        {{--Thêm y tá--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="box-add user-support">
                            <input type="hidden" name="support_id" id="support_id" value="{{@$order->support_id}}">
                            <div class="btn-icon">
                                <span class="icon-plus"><i class="fa fa-plus"></i></span>
                                <br>
                                <span class="chon-tu-van">Chọn tư vấn</span>
                                <span class="small-tip small-tip-custom text-tu-van">{{@$order->support->full_name}}</span>
                            </div>
                        </div>
                        <div class="row date-create">
                            <div class="col-6 mt-5">
                                {!! Form::label('created_at', 'Ngày tạo đơn', array('class' => ' required')) !!}
                                {!! Form::text('created_at', isset($order) ? date("d-m-Y", strtotime($order->created_at)) : date("d-m-Y", strtotime("now")), array('class' => 'form-control fc-datepicker')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 info">
                        <div class="row">
                            <div class="col-6 title">Tạm tính</div>
                            <div class="col-6 text-right bold tam_tinh">0</div>
                        </div>
                        <div class="row">
                            <div class="col-6 title">Khuyến mãi</div>
                            <div class="col-6 text-right"><a href="javascript:void(0)" id="get_Voucher">Chọn khuyến mãi</a></div>
                        </div>
                        <div class="row">
                            <div class="col-6 title">Khuyến mãi (dv)</div>
                            <div class="col-6 text-right"><a href="javascript:void(0)" id="get_Voucher_Services">Chọn khuyến mãi</a></div>
                        </div>
                        <div class="row">
                            <div class="col-6 title">Chiết khấu tổng đơn (%)</div>
                            <div class="col-6 text-right">
                                <input id="discount_percent" type="number" class="input-custom" style="width: 50px; height: 30px;padding-left: 5px" min="0" max="100">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 title">Chiết khấu (VNĐ)</div>
                            <div class="col-6 text-right bold">
                                <input id="all_discount_order"  type="text" class="input-custom" style="width: 100px; height: 30px;padding-left: 5px" value="{{isset($order)?@number_format($order->discount_order):0}}">
                                <input type="hidden" name="discount_order" id="discount_order" value="0">

                                <input name="discount" value="{{isset($order)?@$order->discount:0}}" type="hidden"
                                       id="discount">
                                <input value="{{isset($order)?@$order->voucher_id:0}}" name="voucher_id" id="voucher_id"
                                       type="hidden">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 title">Tổng thanh toán</div>
                            <div class="col-6 text-right bold text-danger" id="sum_total">{{isset($order)?@number_format($order->all_total):0}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {{--<div class="col bot" style="margin-top: 10px;">--}}
                {{--<button type="submit" class="btn btn-success">Lưu</button>--}}
                {{--<a href="{{route('order.list')}}" class="btn btn-danger">Về danh sách</a>--}}
                {{--</div>--}}
                <div class="col bot" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-success save">Lưu</button>
                    <a href="{{route('order.list')}}" class="btn btn-danger back">Huỷ</a>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
    {{--<input type="hidden" class="data-order" value="{{isset($order) ? }}">--}}
    <input type="hidden" class="arrBacSy" value="{{$spaTherapissts}}">
    <input type="hidden" class="arrSupport" value="{{$customer_support}}">
    @include('order.modalBacSy')
    @include('order.modalSupport')
    @include('order.modalVoucher')
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        var searchParams = new URLSearchParams(window.location.search)
        var param = searchParams.get('type');
        var param2 = {{@$role_type?:0}};
        $(document).on('click', '#add_row', function () {

            $('.order').append(`
                <tr>
                    <td class="width350">
                <div class="row">
                    <div class="col-xs-12 col-md-10">
                        <select class="select2 select3 form-control service" required id="service" name="service_id[]">
                            <option>-Chọn dịch vụ-</option>
                            @foreach($services as $service)
                <option value="{{@$service->id}}">{{@$service->category->name}} - {{@$service->name}} </option>
                            @endforeach
                </select>
            </div>
            <span class="btn btn-default col-md-1 no-padd add_note" style="height:34px; background-color: #ffffff"> <i class="fa fa-plus font16" aria-hidden="true"></i> </span>
            <textarea class="product_note form-control pt5 italic" style="margin-left: 12px; display: none" placeholder="Ghi chú" name="service_note[]"></textarea>
            <div class="row">
            </td>
            <td class="text-center" width="50">
{!! Form::text('days[]', 0, array('class' => 'form-control input-custom', 'required' => true)) !!}
                    {!! Form::hidden('quantity[]', 1, array('class' => 'form-control', 'required' => true)) !!}
                </td>
                <td class="text-center">
{!! Form::text('price[]', null, array('class' => 'form-control price input-custom', 'required' => true)) !!}
                </td>
{{--<td class="text-center">--}}
                    {{--{!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}--}}
                    {{--</td>--}}
                <td class="text-center">
            <input type="text" class="form-control CK1 input-custom" value="0">
            </td>
                <td class="text-center">
{!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2 input-custom')) !!}
                </td>
                <td class="text-center" colspan="2">
{!! Form::text('total_price[]', null, array('class' => 'form-control total input-custom','readonly'=>true)) !!}
                </td>
                <td class="tc vertical-middle remove_row">
                    <img class="pointer" src="{{asset('assets/images/delete.png')}}" alt="">
                    </td>
                </tr>
`);
            $('.select3').select2({ //apply select2 to my element
                allowClear: true
            });
        });

        $(document).on('click', '#add_row2', function () {
            $('.order').append(`
                <tr>
                    <td class="width350">
                    <div class="row">
                    <div class="col-xs-12 col-md-10">
                        <select class="select2 select3 form-control service" required id="service" name="service_id[]">
                            <option>-Chọn sản phẩm-</option>
                            @foreach($products as $product)
                <option value="{{@$product->id}}">{{@$product->category->name}} - {{@$product->name}} </option>
                            @endforeach
                </select>
            </div>
            <span class="btn btn-default col-md-1 no-padd add_note" style="height:34px; background-color: #ffffff"> <i class="fa fa-plus font16" aria-hidden="true"></i> </span>
            <textarea class="product_note form-control pt5 italic" style="margin-left: 12px; display: none" placeholder="Ghi chú" name="service_note[]"></textarea>
            </div>
            </td>
            <td class="text-center" width="50">
            {!! Form::text('quantity[]', 1, array('class' => 'form-control quantity input-custom', 'required' => true)) !!}
                    {!! Form::hidden('days[]', 0, array('class' => 'form-control', 'required' => true)) !!}
                </td>
                <td class="text-center">
            {!! Form::text('price[]', null, array('class' => 'form-control price input-custom', 'required' => true)) !!}
                </td>
                {{--<td class="text-center">--}}
                    {{--{!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}--}}
                    {{--</td>--}}
                <td class="text-center">
                    <input type="text" class="form-control CK1 input-custom" value="0">
                </td>
                <td class="text-center">
            {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2 input-custom')) !!}
                </td>
                <td class="text-center" colspan="2">
            {!! Form::text('total_price[]', null, array('class' => 'form-control total input-custom','readonly'=>true)) !!}
                </td>
                <td class="tc vertical-middle remove_row">
                    <img class="pointer" src="{{asset('assets/images/delete.png')}}" alt="">
                </td>
            </tr>
        `);

// select
            $('.select3').select2({ //apply select2 to my element
                allowClear: true
            });
        });


        var value_total = 0;
        $(document).on('change', '.service', function (e) {
            let target = $(e.target).parent().parent().parent().parent();
            let id = $(this).val();
            if (param2 === 1||param === 'services') {
                $('#role_type').val({{\App\Constants\StatusCode::SERVICE}}).change();
            } else {
                $('#role_type').val({{\App\Constants\StatusCode::COMBOS}}).change();
            }
            $.ajax({
                url: "{{ Url('ajax/info-service') }}",
                method: "get",
                data: {id: id}
            }).done(function (data) {
                $(target).find('.price').val(formatNumber(data.price_sell));
                $(target).find('.total').val(formatNumber(data.price_sell));
                value_total = 0;
                $(".total").each(function () {
                    value_total += parseInt(replaceNumber($(this).val()));
                });
                $('#sum_total').html(formatNumber(value_total));

            });
        });

        $('body').on('keyup', '.price, .VAT, .CK1, .CK2, .quantity', function (e) {
            let target = $(e.target).parent().parent();
            let quantity = $(this).closest('tr').find('.quantity').val();
            if (quantity == 'NaN' || quantity==undefined) {
                quantity =1;
            }
            console.log(quantity,'quantity');
            // let VAT = $(target).find('.VAT').val();
            let price = $(target).find('.price').val();

            let CK2 = $(target).find('.CK2').val();
            let CK1 = $(target).find('.CK1').val();

            price = replaceNumber(price);
            if (CK1 > 0) {
                CK2 = CK1 * price * quantity / 100;
            }
            console.log(12313123,price);

            let total_service = parseInt(price)* parseInt(quantity) - parseInt(replaceNumber(CK2));
            console.log(total_service,'quantity');

            $(target).find('.price').val(formatNumber(price));
            $(target).find('.CK2').val(formatNumber(CK2));
            $(this).closest('tr').find('.total').val(formatNumber(total_service));
            value_total = 0;
            $(".total").each(function () {
                value_total += parseInt(replaceNumber($(this).val()));
            });
            console.log(11111111,value_total);
            $('#sum_total').html(formatNumber(value_total));
            $('.tam_tinh').html(formatNumber(value_total));
        });
        $('#get_Voucher').click(function () {
            let status = $('#status').val();
            $.ajax({
                url: "{{ Url('api/voucher') }}",
                method: "get",
                data: {status: status}
            }).done(function (response) {
                let html = '';
                let data = response.data;
                if (data.length > 0) {
                    data.forEach(function (item) {
                        if (item.type == {{\App\Constants\PromotionConstant::MONEY}}) {
                            html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
                                <li>
                                    <span class="ruleName"></span><span class="ruleValue">` + item.title + `</span>
                                </li>
                                    <span class="ruleName">Giảm giá: </span><span class="ruleValue">` + formatNumber(item.money_promotion) + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Đơn hàng từ: </span><span class="ruleValue">` + formatNumber(item.min_price) + `</span>
                                </li>
                            </ul>
                            <div class="div">
                                <a href="#" data-id="` + item.id + `" class="btn btn-warning chooseVoucher">Áp dụng</a>
                            </div>
                        </div> `;

                        } else {
                            html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
                                <li>
                                    <span class="ruleName"></span><span class="ruleValue">` + item.title + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Giảm giá: </span><span class="ruleValue">` + formatNumber(item.money_promotion) + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Đơn hàng từ: </span><span class="ruleValue">` + formatNumber(item.min_price) + `</span>
                                </li>
                            </ul>
                            <div class="div">
                                <a href="#" data-id="` + item.id + `" class="btn btn-warning chooseVoucher">Áp dụng</a>
                            </div>
                        </div> `;
                        }
                    });
                } else {
                    html = `<span style="color: red"><i>Không có mã khuyến mại khả dụng !!!</i></span>`;
                }
                $('.promotionItem').html(html);

            });
            $('#voucherModal').modal('show');
        });

        $('#get_Voucher_Services').click(function () {
            let status = $('#status').val();
            let service = $('#fvalidate').find("select[name='service_id[]']").val()
            $.ajax({
                url: "{{ Url('api/voucher-services') }}",
                method: "get",
                data: {status: status, service: service}
            }).done(function (response) {
                let html = '';
                let data = response.data;
                console.log(data);
                if (data.length > 0) {
                    data.forEach(function (item) {
                        if (item.type == {{\App\Constants\PromotionConstant::PERCENT}}) {
                            html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
                                <li>
                                    <span class="ruleName"></span><span class="ruleValue">` + item.title + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Giảm giá: </span><span class="ruleValue">` + item.percent_promotion + `%</span>
                                </li>
                                <li>
                                    <span class="ruleName">Tối đa: </span><span class="ruleValue">` + formatNumber(item.max_discount) + `</span>
                                </li>
                            </ul>
                            <div class="div">
                                <a href="#" data-id="` + item.id + `" class="btn btn-warning chooseVoucher">Áp dụng</a>
                            </div>
                        </div>`;
                        } else {
                            html +=  html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
                                <li>
                                    <span class="ruleName"></span><span class="ruleValue">` + item.title + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Giảm giá: </span><span class="ruleValue">` + formatNumber(item.money_promotion) + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Đơn hàng từ: </span><span class="ruleValue">` + formatNumber(item.min_price) + `</span>
                                </li>
                            </ul>
                            <div class="div">
                                <a href="#" data-id="` + item.id + `" class="btn btn-warning chooseVoucher">Áp dụng</a>
                            </div>
                        </div> `;
                        }


                    });
                } else {
                    html = `<span style="color: red"><i>Không có mã khuyến mại khả dụng !!!</i></span>`;
                }
                $('.promotionItem').html(html);

            });
            $('#voucherModal').modal('show');
        });

        $(document).on('click', '.remove_row', function (e) {
            $(e.target).closest('tr').remove();
            value_total = 0;
            $(".total").each(function () {
                value_total += parseInt(replaceNumber($(this).val()));
            });
            $('#sum_total').html(formatNumber(value_total));
            $('#voucher_id').val(0);
            $('#voucher').html(0);
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
                }
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

        $(document).on('click', '.add_note', function (e) {
            const clicks = $(this).data('clicks');
            const target = $(e.target).parent().parent();

            if (clicks) {
                $(target).find('.product_note').css({'display': 'none'});
            } else {
                $(target).find('.product_note').css({'display': 'block'});
            }
            $(this).data("clicks", !clicks);
        })

        $(document).on('click', '.chooseVoucher', function (e) {
            let id = $(this).data('id');
            let total = $('#sum_total').html()
            $.ajax({
                url: "/api/voucher/" + id,
                method: "get",
                data: {total_price: parseInt(replaceNumber(total))}
            }).done(function (response) {
                if (response.code == 200) {
                    $('#voucher').html(formatNumber(response.data.discount));
                    $('#discount').val(response.data.discount);
                    value_total = 0;
                    $(".total").each(function () {
                        value_total += parseInt(replaceNumber($(this).val()));
                    });
                    value_total = parseInt(value_total) - parseInt(response.data.discount);
                    $('#sum_total').html(formatNumber(value_total));
                    $('#voucher_id').val(response.data.voucher_id);
                    $('#voucherModal').modal('hide');
                } else {
                    swal({
                        title: 'Đơn hàng không đủ điều kiện !!!',
                        type: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        })
        $(document).on('change', '#discount_percent', function (e) {
            let money = $(this).val() ? parseInt($(this).val()) : 0;

            let chiet_khau = Math.round((parseInt(money) * value_total) / 100);

            console.log(123123,money,value_total,chiet_khau);

            $('#discount_order').val(chiet_khau);
            $('#all_discount_order').val(formatNumber(chiet_khau));

            let sum_total = value_total - chiet_khau;

            $('#sum_total').html(formatNumber(sum_total));
            console.log(money, 'money-discount');
        });
    </script>
    <script>

        $(document).on('click','.user-bac-sy',function () {
            $('#userBacSy').modal('show');
        })
        $(document).on('click','.user-support',function () {
            $('#userSupport').modal('show');
        })


        $(document).on('click','.selectSupport',function () {
            console.log(11111,$(this).data('id'));
            let data = $(this).data('id');
            let data_name = $(this).data('name');
            $('.selectSupport .thumbnail').removeClass('selected');
            $(this).find('.thumbnail').addClass('selected');
            $('#support_id').val(data);
            $('.text-tu-van').html(data_name);
        })

        $(document).on('click','.selectDoctor',function () {
            let data = $(this).data('id');
            let data_name = $(this).data('name');
            $('.selectDoctor .thumbnail').removeClass('selected');
            $(this).find('.thumbnail').addClass('selected');
            $('#spa_therapisst_id').val(data);
            $('.text-bac-si').html(data_name);
        })

        $(document).on('keyup','#all_discount_order',function () {
            let abc = formatNumber($(this).val());
            $('#all_discount_order').val(abc);

            $('#discount_order').val(replaceNumber(abc));
            let total = value_total - replaceNumber(abc);

            total = total > 0 ? total : 0;


            $('#discount_percent').val(0);
            $('#sum_total').html(formatNumber(total))
        })


        $( ".quickSearchPageDoctor").keyup(function() {
            let value = $(this).val();
            let arr_page1 = $('.arrBacSy').val();
            arr_page1 = JSON.parse(arr_page1);
            let selected = $('#spa_therapisst_id').val();
            doSearch(value,arr_page1,'#userBacSy',selected);
        });

        $( ".quickSearchPageSupport").keyup(function() {
            let value = $(this).val();
            let arr_page1 = $('.arrSupport').val();
            arr_page1 = JSON.parse(arr_page1);
            let selected = $('#support_id').val();
            doSearch(value,arr_page1,'#userSupport',selected);
        });


        let delayTimer;
        function doSearch(text,arr_page1,classes,selected_id) {
            clearTimeout(delayTimer);

            delayTimer = setTimeout(function() {
                html = '';
                if(arr_page1.length>0){
                    arr_page1.forEach(f=>{
                        let re = new RegExp(`${text}`, 'gi');
                        if (f.full_name.match(re)) {
                            let avatar = f.avatar ? f.avatar  :'';
                            let selected = f.id == selected_id ? 'selected' : '';
                            let select = classes == '#userBacSy' ? 'selectDoctor' : 'selectSupport';
                            html += `
                                <li class="`+select+`" data-id='`+f.id+`' data-name="`+f.full_name+`">
                                    <div class="thumbnail `+selected+`">
                                        <img class="image_picker_image" src="`+avatar+`">
                                        <p>`+f.full_name+`</p>
                                    </div>
                                </li>
                            `
                        }else{
                            // console.log('ngon ngay1');
                        }
                    })
                    $(classes +' ' + '.image_picker_selector ul').html(html)
                }
            }, 500); // Will do the ajax stuff after 1000 ms, or 1 s
        }
    </script>
@endsection
