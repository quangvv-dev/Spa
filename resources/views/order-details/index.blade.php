@extends('layout.app')
@section('_style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3></br>
                <div class="col"><a class="right btn btn-primary btn-flat" href="{{ route('orders.create') }}"><i
                                class="fa fa-plus-circle"></i>Thêm mới</a></div>
            </div>
            <div class="card-header col-md-6">
                @include('order-details.search')
            </div>
            <div id="registration-form">
                @include('order-details.ajax')
            </div>
        </div>
    </div>
@endsection
@section('_script')
    <script type="text/javascript">
        $(document).on('change keyup', '.group, .telesale, .marketing, .customer, .service', function () {
            var group = $('.group').val();
            var telesale = $('.telesale').val();
            var marketing = $('.marketing').val();
            var customer = $('.customer').val();
            var service = $('.service').val();
            console.log(telesale, marketing, customer);
            $.ajax({
                url: "{{ Url('list-orders/') }}",
                method: "get",
                data: {
                    group: group,
                    telesale: telesale,
                    marketing: marketing,
                    customer: customer,
                    service: service
                }
            }).done(function (data) {
                $('#registration-form').html(data);
            });
        });
    </script>
@endsection
