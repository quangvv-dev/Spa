@extends('layout.app')
@section('content')
    <style>
        tfoot td {
            border: none !important;
        }

        td input.form-control {
            font-size: 14px;
        }

        td select.form-control {
            font-size: 14px;
        }
        .width350{
            max-width: 350px;
        }

    </style>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
            </div>

            @if (isset($order))
                {!! Form::model($order, array('url' => url('orders/'.$order->id. '/edit'), 'method' => 'put', 'files'=> true,'id'=>'fvalidate')) !!}
            @else
                {!! Form::open(array('url' => route('order-detail.store'), 'method' => 'post', 'files'=> true,'id'=>'fvalidate')) !!}
            @endif
            <div class="col row">
                @if(isset($customer))
                    {!! Form::hidden('user_id', $customer->id, array('class' => 'form-control quantity', 'required' => true)) !!}
                @endif
                {!! Form::hidden('role_type', isset($order)&&$order->role_type?$order->role_type:\App\Constants\StatusCode::PRODUCT, array('id' => 'role_type')) !!}
                <div class="col-xs-12 col-md-3">
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
                <div class="col-xs-12 col-md-4">
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
                            <select id="status" class="form-control select2" name="status_id" required="required"
                                    data-placeholder="Trạng thái">
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
                        <thead class="bg-primary text-white">
                        <tr style="white-space: nowrap">
                            <th class="text-white text-center">Dịch vụ</th>
                            <th class="text-white text-center">Số lượng</th>
                            <th class="text-white text-center">Đơn giá</th>
                            {{--<th class="text-white text-center">VAT(%)</th>--}}
                            <th class="text-white text-center">CK(%)</th>
                            <th class="text-white text-center" style="width: 100px">CK(đ)</th>
                            <th class="text-white text-center" colspan="2">Thành tiền</th>
                            <th class="text-white text-center"></th>
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
                                                <select class="select2 form-control service" required id="service" required
                                                        name="service_id[]">
                                                    <option>-Chọn sản phẩm-</option>
                                                    @foreach($products as $product)
                                                        <option
                                                            value="{{$product->id}}" {{$product->id == $orderDetail->booking_id ? "selected": ""}} >{{@$product->category->name}}
                                                            - {{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="btn btn-default col-md-1 no-padd add_note"
                                                  style="height:34px; background-color: #ffffff;"> <i
                                                    class="fa fa-plus font16" aria-hidden="true"></i> </span>
                                            <textarea class="product_note form-control pt5 italic"
                                                      style="margin-left: 12px; display: none" placeholder="Ghi chú"
                                                      name="service_note[]">{{@$orderDetail->service->description}}</textarea>
                                        </div>
                                    </td>
                                    <td class="text-center" width="50">
                                        {!! Form::text('quantity[]', $orderDetail->quantity, array('class' => 'form-control quantity', 'required' => true)) !!}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::text('price[]', number_format($orderDetail->price), array('class' => 'form-control price', 'required' => true)) !!}
                                    </td>
                                    {{--<td class="text-center">--}}
                                        {!! Form::hidden('vat[]', 0, array('class' => 'form-control VAT')) !!}
                                    {{--</td>--}}
                                    <td class="text-center">
                                        <input type="text" class="form-control CK1">
                                    </td>
                                    <td class="text-center">
                                        {!! Form::text('number_discount[]', number_format($orderDetail->number_discount), array('class' => 'form-control CK2')) !!}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::text('total_price[]', number_format($orderDetail->total_price), array('class' => 'form-control total','readonly'=>true)) !!}
                                    </td>
                                    <td class="tc vertical-middle remove_row">
                                        <button class='btn btn-secondary'><i class="fa-trash fa"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else

                            <tr>
                                <td class="width350">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10">

                                            <select class="select2 form-control service" required id="service"
                                                    name="service_id[]">
                                                @foreach($products as $product)
                                                    <option value="{{@$product->id}}">{{@$product->category->name}}
                                                        - {{@$product->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <span class="btn btn-default col-md-1 no-padd add_note"
                                              style="height:34px; background-color: #ffffff;"> <i
                                                class="fa fa-plus font16"
                                                aria-hidden="true"></i> </span>
                                        <textarea class="product_note form-control pt5 italic"
                                                  style="margin-left: 12px; display: none" placeholder="Ghi chú"
                                                  name="service_note[]"></textarea>
                                    </div>
                                </td>
                                <td class="text-center" width="50">
                                    {!! Form::text('quantity[]', 1, array('class' => 'form-control quantity', 'required' => true)) !!}
                                </td>
                                <td class="text-center">
                                    {!! Form::text('price[]', null, array('class' => 'form-control price', 'required' => true)) !!}
                                </td>
                                {{--<td class="text-center">--}}
                                    {{--{!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}--}}
                                {{--</td>--}}
                                <td class="text-center">
                                    <input type="text" class="form-control CK1" value="0">
                                </td>
                                <td class="text-center">
                                    {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                                </td>
                                <td class="text-center" colspan="2">
                                    {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                                </td>
                                <td class="tc vertical-middle remove_row">
                                    <button class='btn btn-secondary'><i class="fa-trash fa"></i></button>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <div class="col-md-12"><a href="javascript:void(0)" id="add_row" class="red">(+) Sản phẩm</a></div>
                            </td>
                            <td colspan="5">
                                @if(empty($order))
                                    <a href="javascript:void(0)" id="get_Voucher" class="right">
                                        <i class="fa fa-check-square text-primary"></i> Chọn Voucher KM !!!</a>
                                @endif
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="5">
                                <div class="col row">
                                    <input type="hidden" value="0" name="spa_therapisst_id">
                                    <div class="col-md-5">
                                        {!! Form::label('support_id', 'Người tư vấn (nếu có)') !!}
                                        {!! Form::select('support_id', $customer_support, null, array('class' => 'form-control select2', 'placeholder' => 'Chọn người tư vấn')) !!}
                                    </div>
                                    <div class="col-md-5">
                                        <div
                                            class="form-group required {{ $errors->has('birthday') ? 'has-error' : '' }}">
                                            {!! Form::label('created_at', 'Ngày tạo đơn', array('class' => ' required')) !!}
                                            <div class="wd-200 mg-b-30">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar tx-16 lh-0 op-6"></i>
                                                        </div>
                                                    </div>
                                                    {!! Form::text('created_at', isset($order) ? date("d-m-Y", strtotime($order->created_at)) : date("d-m-Y", strtotime("now")), array('class' => 'form-control fc-datepicker')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="help-block">{{ $errors->first('created_at', ':message') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center bold"><b>Giảm giá (VNĐ)</b></td>
                            <td class="text-center bold"
                                id="voucher">{{isset($order)?@number_format($order->discount):0}}</td>
                            <td><input name="discount" value="{{isset($order)?@$order->discount:0}}" type="hidden"
                                       id="discount">
                                <input value="{{isset($order)?@$order->voucher_id:0}}" name="voucher_id" id="voucher_id"
                                       type="hidden">
                            </td>
                        </tr>
                        <tr class="bold">
                            <td class="text-center"><b>Chiết khấu tổng đơn (VNĐ)</b></td>
                            <td class="text-center">
                                @if(empty($order))
                                    <input type="number" max="100" min="0" value="0" id="discount_percent" >(%)
                                @endif
                            </td>
                            <td class="text-center"
                                id="all_discount_order">{{isset($order)?@number_format($order->discount_order):0}}
                            </td>
                            <input type="hidden" name="discount_order" id="discount_order" value="0">

                        </tr>
                        <tr class="bold">
                            <td colspan="5"></td>
                            <td class="text-center bold">Tổng thanh toán (VNĐ)</td>
                            <td style="color: red !important;" class="text-center bold" id="sum_total">{{isset($order)?@number_format($order->all_total):0}}</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="col bot" style="margin-top: 10px;">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{route('order.list')}}" class="btn btn-danger">Về danh sách</a>
            </div>
            {{ Form::close() }}

        </div>
    </div>
    @include('order.modalVoucher')
@endsection
@section('_script')
    <script src="{{ asset('js/format-number.js') }}"></script>
    <script>
        var searchParams = new URLSearchParams(window.location.search)
        var param = searchParams.get('type');
        $(document).ready(function () {
            $('#role_type').val({{\App\Constants\StatusCode::PRODUCT}}).change();
        })
        $(document).on('click', '#add_row', function () {

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
            {!! Form::text('quantity[]', 1, array('class' => 'form-control quantity', 'required' => true)) !!}
                </td>
                <td class="text-center">
            {!! Form::text('price[]', null, array('class' => 'form-control price', 'required' => true)) !!}
                </td>
                {{--<td class="text-center">--}}
            {{--{!! Form::text('vat[]', 0, array('class' => 'form-control VAT')) !!}--}}
                {{--</td>--}}
                <td class="text-center">
                    <input type="text" class="form-control CK1" value="0">
                </td>
                <td class="text-center">
            {!! Form::text('number_discount[]', 0, array('class' => 'form-control CK2')) !!}
                </td>
                <td class="text-center" colspan="2">
            {!! Form::text('total_price[]', null, array('class' => 'form-control total','readonly'=>true)) !!}
                </td>
                <td class="tc vertical-middle remove_row"><button class='btn btn-secondary'><i class="fa-trash fa"></i></button></td>
            </tr>
`);

            $('.select3').select2({ //apply select2 to my element
                allowClear: true
            });
        });
        var value_total = 0;

        $(document).on('change', '.service', function (e) {
            let target = $(e.target).closest('tr');
            let id = $(this).val();
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
            let quantity = $(target).find('.quantity').val();
            // let VAT = $(target).find('.VAT').val();
            let price = $(target).find('.price').val();
            let CK2 = $(target).find('.CK2').val();
            let CK1 = $(target).find('.CK1').val();
            price = replaceNumber(price);
            if (CK1 > 0) {
                CK2 = CK1 * price * quantity / 100;
            }

            let total_service = price * quantity - replaceNumber(CK2);
            $(target).find('.price').val(formatNumber(price));
            $(target).find('.CK2').val(formatNumber(CK2));
            $(target).find('.total').val(formatNumber(total_service));
            value_total = 0;
            $(".total").each(function () {
                value_total += parseInt(replaceNumber($(this).val()));
            });
            $('#sum_total').html(formatNumber(value_total));
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
                        if (item.type =={{\App\Constants\PromotionConstant::MONEY}}) {
                            html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
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

                        } else {
                            html += `<div class="header m-t-5">
                            <ul class="promotionRules col">
                                <li>
                                    <span class="ruleName">Giảm giá: </span><span class="ruleValue">` + item.percent_promotion + `%</span>
                                </li>
                                <li>
                                    <span class="ruleName">Tối đa: </span><span class="ruleValue">` + formatNumber(item.max_discount) + `</span>
                                </li>
                                <li>
                                    <span class="ruleName">Đơn hàng từ: </span><span class="ruleValue">` + formatNumber(item.min_price) + `</span>
                                </li>
                            </ul>
                            <div class="div">
                                <a href="#" data-id="` + item.id + `" class="btn btn-warning chooseVoucher">Áp dụng</a>
                            </div>
                        </div>`;
                        }
                    });
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
                if (response.ok == 200) {
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
            let money = $(this).val()?$(this).val():0;
            let old_money = $('#discount_order').val();
            value_total = parseInt(old_money) + parseInt(replaceNumber(value_total));
            money = parseInt(money) * parseInt(value_total) / 100;
            $('#discount_order').val(money);
            $('#all_discount_order').html(formatNumber(money));
            value_total = replaceNumber(value_total) - money;

            console.log(old_money, value_total, 'old');
            $('#sum_total').html(formatNumber(value_total));
            console.log(money, 'money-discount');
        });
    </script>
@endsection
