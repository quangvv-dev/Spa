@extends('layout.app')
@section('_style')
    <link href="{{ asset(('css/order.css')) }}" rel="stylesheet"/>
    <style>
        a.white {
            color: #fff;
        }
        .table{
            border: 1px solid #e0e8f5;
        }
        p{
            color: #fff;
            background: linear-gradient(107.54deg, #FFFFFF 4.13%, #999999 48.62%, #FFFFFF 93.12%);
            -webkit-background-clip: text;
        }

    </style>
@endsection
@section('content')
    <div class="row" style="">
        <div class="col-lg-8 col-lg-offset-1">
            <div class="invoice">
                <div class="text-center"><strong class="font-sopher fs-20 bold">ĐƠN HÀNG BÁN</strong></div>
                <div class="row">
                    <table class="table">
                        <tbody>
                        <tr class="trfirst">
                            <td style="width:50%">
                                <b>Tên khách hàng:</b>&nbsp; <a class="blue"
                                                                href="{{url('customers/'.$order->customer->id)}}">{{ @$order->customer->full_name }}</a>
                            </td>
                            <td style="width:50%">
                                <b>Người lên đơn:</b>&nbsp;{{ @$order->owner->full_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Địa chỉ:</b>&nbsp;{{ @$order->customer->address }}
                            </td>
                            <td style="width:50%">
                                <b>Phòng ban:</b>&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Điện thoại:</b>&nbsp;{{ @str_limit($order->customer->phone,7,'xxx') }} -
                            </td>
                            <td style="width:50%">
                                <b>Ngày tạo đơn:</b>&nbsp; {{ date('d-m-Y', strtotime($order->created_at)) }}&emsp;
                                @if($order->hsd)
                                    <b>Ngày hết hạn:</b>&nbsp; {{ date('d-m-Y', strtotime($order->hsd)) }}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%">
                                <b>Người nhận:</b>&nbsp;{{ @$order->customer->full_name }} - Điện thoại:
                                <a class="__clickToCall blue" data-phone="0932148915" data-type="crm"
                                   data-call="order_222" data-contact-id="896">{{ @str_limit($order->customer->phone,7,'xxx') }}</a>
                            </td>
                            <td style="width:50%">
                                <b>Phương thức thanh toán:</b>&nbsp;{{@$order->name_payment_type}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table mt10">
                        <tbody>
                        <tr class="bold b-gray">
                            <td class="padding5">STT</td>
                            <td class="padding5">Mã</td>
                            <td class="padding5">Sản phẩm|Dịch vụ</td>
                            {{--                            <td class="padding5">Đơn vị tính</td>--}}
                            <td class="padding5">Số lượng|Số buổi</td>
                            <td class="padding5">Đơn giá</td>
                            <td class="padding5">VAT (%)</td>
                            <td class="padding5">CK (%)</td>
                            <td class="padding5">CK (đ)</td>
                            <td class="padding5">Thành tiền</td>
                        </tr>
                        @foreach($order->orderDetails as $key => $orderDetail)
                            <tr><input type="hidden" class="product_id" value="16">
                                <td class="tc">{{ $key + 1 }}</td>
                                <td class="tc"></td>
                                <td class="tl position"><a class="blue" href="#">{{ @$orderDetail->service->name }}</a></td>
                                <td class="tc">{{@$orderDetail->quantity>0 ? $orderDetail->quantity: $orderDetail->days}}</td>
                                <td class="tc">{{ number_format(@$orderDetail->price) }}</td>
                                <td class="tc">{{ $orderDetail->vat }}</td>
                                <td class="tc">{{ $orderDetail->percent_discount }}</td>
                                <td class="tc">{{ number_format($orderDetail->number_discount) }}</td>
                                <td class="tr">{{ number_format($orderDetail->total_price) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="font-bold" colspan="8">Khuyến mại (voucher)</td>
                            <td class="tr bold">{{ number_format($order->discount) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold" colspan="8">Tổng cộng</td>
                            <td class="tr bold"> {{ number_format($order->all_total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 no-padd bor-r" id="right_panel">
            <div>
                <div class="col-md-12 no-padd box-cont">
                    <div id="attachments" class="files padding">
                        <div>
                            <div id="progress" class="progress" style="display:none">
                                <div class="progress-bar progress-bar-success" role="progressbar"></div>
                            </div>
                            <div id="files" class="files"></div>
                        </div>
                    </div>
                </div>
                <div class="box-cont col-md-12 no-padd content-pay"><h3
                        class="bor-bot uppercase font12 mg0 bold padding5">Thanh toán</h3>
                    <div class="padding col-md-12">
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th width="56%"></th>
                                <th width="44%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="mb5">Doanh số:</td>
                                <td class="tr mb5" id="all_total">{{ number_format($order->all_total) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Đã thanh toán:</td>
                                <td class="tr mb5" id="gross_revenue">{{ number_format($order->gross_revenue) }}</td>
                            </tr>
                            {{--<tr>--}}
                            {{--<td class="mb5">Thực tế phải thanh toán:</td>--}}
                            {{--<td class="tr mb5" id="all_total1">{{ number_format($order->all_total) }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <td class="mb5">Khuyến mại (voucher):</td>
                                <td class="tr mb5" id="all_total1">{{ number_format($order->discount) }}</td>
                            </tr>
                            <tr>
                                <td class="mb5">Chiết khấu :</td>
                                <td class="tr mb5" id="all_total1">{{ number_format($order->discount_order) }}</td>
                            </tr>
                            {{--<tr>--}}
                            {{--<td class="mb5">Đã thanh toán:</td>--}}
                            {{--<td class="tr mb5" id="gross_revenue1">{{ number_format($order->gross_revenue) }}</td>--}}
                            {{--</tr>--}}
                            <tr>
                                <td class="mb5">Còn lại:</td>
                                <td class="tr mb5" id="the_rest">{{ number_format($order->the_rest) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="detail-pay-dvh position col-md-12 no-padd">
                    @include('order.payment-history')
                </div>
            </div>
        </div>

        <div class="fixed-bottom">
            <div class="list_task_footer col-md-12 padding menu-footer">
                <div class="fl task_footer_box">
                    <button class="btn btn-info ml5 fr paymentOrder" data-toggle="modal" data-target="#paymentModal"><a
                            class="white">Thanh toán</a></button>
                </div>
                <div class="btn-group dropup fl task_footer_box">
                    <button class="btn btn-primary ml5 printOrder" data-number="2"><a class="white"
                                                                                      href="/order-pdf/{{$order->id}}"><i
                                class="fa fa-print"></i>&nbsp;In</a>
                    </button>
                </div>
                <div class="btn-group dropup fl task_footer_box">
                    <button class="btn btn-warning ml5" data-number="2"><a class="white"
                                                                           href="/commission/{{$order->id}}"><i
                                class="fas fa-dollar-sign"></i>&nbsp;Hoa hồng</a>
                    </button>
                </div>
                <div class="btn-group dropup fl task_footer_box">
                    <button class="btn btn-pink ml5" data-toggle="modal" data-target="#addGifts">
                        <a><i class="fa fa-gift"></i>&nbsp;Quà tặng</a>
                    </button>
                </div>
                <div class="btn-group dropup fl task_footer_box">
                    <button class="btn btn-danger ml5 edit-order" data-order-id="{{$order->id}}">
                        <a><i class="fa fa-balance-scale"></i>&nbsp;Trừ L.trình</a>
                    </button>
                </div>
                <div class="fl task_footer_box cancel_order">
                    <button class="btn btn-default fr ml5">
                        <a href="{{route('order.list')}}">Trở lại</a>
                    </button>
                </div>
            </div>
        </div>
        @include('order.modal')
        @include('gifts._form')
        @include('customers.modal_update_history_order')
        @endsection
        @section('_script')
            <script src="{{ asset('js/format-number.js') }}"></script>
            <script>

                var orderCurrentId = '';
                $(document).on('click', '.edit-order', function () {
                    // let id = $(this).data('order-id');
                    orderCurrentId = $(this).data('order-id');
                    let html = "";
                    //
                    $.ajax({
                        type: 'get',
                        url: "{{ Url('ajax/services-with-order/') }}" + "/" + orderCurrentId,
                        success: function (res) {
                            res.forEach(element => {
                                html += `<option value="` + element.id + `">` + element.name + `</option>`;
                            });
                            $('#service_modal').html(html);
                            $('#updateHistoryOrderModal').modal('show');
                        }
                    })
                })
                $('.save-update-history-order').click(function () {
                    swal({
                        title: 'Bạn có muốn xử  liệu trình ?',
                        showCancelButton: true,
                        cancelButtonClass: 'btn-secondary waves-effect',
                        confirmButtonClass: 'btn-danger waves-effect waves-light',
                        confirmButtonText: 'OK'
                    }, function () {
                        $.ajax({
                            type: 'PUT',
                            url: "{{ Url('ajax/orders/') }}" + "/" + orderCurrentId,
                            data: $('#historyUpdateOrrder').serialize(),
                            success: function (res) {
                                if (res == 'Success')
                                    alert("Cập nhật liệu trình thành công");
                                else if (res == "Failed")
                                    alert("Số liệu trình đã hết");
                                window.location.reload();
                            }
                        })
                    })
                });

                $(document).on('keyup', '.number', function () {
                    let earn = $(this).val();
                    $(this).val(formatNumber(earn));
                })
                $(document).ready(function () {
                    $('[data-toggle="datepicker"]').datepicker({
                        format: 'dd-mm-yyyy',
                        autoHide: true,
                        zIndex: 2048,
                    });

                    $('#product_id').change(function () {
                        let id = $(this).val();
                        if (!id) return false;
                        var text = $(this).find(":selected").text();
                        var html = `<tr>
                <input type="hidden" name="product[]" value="` + id + `">
                <td><span id="">` + text + `</span></td>
                <td style="width: 30%;">
                    <input type="text" maxlength="5" class="form-control txt-dotted number"style="height: 23px !important;" name="quantity[]">
                </td>
                <td> <a class="delGift"><i class="fa fa-trash-alt"></i></a> </td>
                </tr>`;
                        $('.list-product').append(html);
                    })
                });

                $(document).on('click', '.delGift', function (e) {
                    $(this).closest('tr').remove();
                });

                $(document).on('click', '#finish', function () {
                    $('#wallet-error').hide();
                    let paymentDate = $('.payment-date').val();
                    let paymentType = $('.payment-type').val();
                    let grossRevenue = $('.gross-revenue').val();
                    let description = $('.description').val();
                    let customer_id = '{{@$order->customer->id}}';
                    let maxWallet = $('#maxWallet').val();
                    let check = replaceNumber(grossRevenue);
                    if (paymentType == 3 && (parseInt(check) > parseInt(maxWallet))) {

                        $('#wallet-error').show();
                        return false;
                    }

                    $.ajax({
                        url: "{{ Url('order/'.$order->id. '/show') }}",
                        method: "put",
                        data: {
                            payment_date: paymentDate,
                            payment_type: paymentType,
                            gross_revenue: grossRevenue,
                            description: description,
                            customer_id: customer_id,
                        }
                    }).done(function () {
                        // window.location.reload();
                    });
                });

                $(document).on('focusout', '.gross-revenue', function () {
                    let grossRevenue = $('.gross-revenue').val();

                    $.ajax({
                        url: "{{ Url('ajax/info-order-payment/'.$order->id) }}",
                        method: "get",
                        data: {
                            gross_revenue: grossRevenue
                        }
                    }).done(function (data) {
                        $(".cash").text(formatNumber(data.cash));
                        $('.remain_cash').text(formatNumber(data.remain_cash));
                        $('.return_cash').text(formatNumber(data.return_cash));
                    });
                });
            </script>
@endsection
