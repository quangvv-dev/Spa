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
                            <li><a href="#tab1" class="pages active" id="click1" data-id="'.click1'" data-toggle="tab">Cài
                                    đặt chung
                                    CRM</a></li>
                            <li><a href="#tab2" class="pages" id="click2" data-id="'.click2'" data-toggle="tab">QL chi
                                    nhánh</a></li>
                            <li><a href="#tab3" class="pages" id="click3" data-id="'.click3'" data-toggle="tab">QL
                                    cụm</a></li>
                            <li><a href="#tab4" class="pages" id="click4" data-toggle="tab">QR thanh toán</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            @include('settings.default')
                        </div>
                        <div class="tab-pane " id="tab2">
                            @include('settings.branch')
                        </div>
                        <div class="tab-pane" id="tab3">
                            @include('settings.location')
                        </div>
                        <div class="tab-pane" id="tab4">
                            @include('settings.qr')
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

        $(document).on('click', '#add_new_status', function () {
            $.ajax({
                url: '{{route('settings.storeBranch')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })
        $(document).on('click', '#add_new_bank', function () {
            $.ajax({
                url: '{{route('settings.storeBank')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                }
            })
        })

        $(document).on('click', '#add_new_location', function () {
            $.ajax({
                url: '{{route('settings.storeLocation')}}',
                method: 'POST',
                success: function (data) {
                    location.reload();
                    console.log(data);
                }
            })
        })

        $(document).on('click', '.save-status', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
                phone: $(this).closest('tr').find('.phone').val(),
                address: $(this).closest('tr').find('.address').val(),
                location_id: $(this).closest('tr').find('.location').val(),
                lat: $(this).closest('tr').find('.lat').val(),
                long: $(this).closest('tr').find('.long').val(),
            }
            $.ajax({
                url: 'branch/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
        $(document).on('click', '.save-bank', function () {
            let id = $(this).data('id');
            let data = {
                bank_code: $(this).closest('tr').find('.bank_code').val(),
                account_number: $(this).closest('tr').find('.account_number').val(),
                account_name: $(this).closest('tr').find('.account_name').val(),
                branch_id: $(this).closest('tr').find('.branch_id').val(),
            }
            $.ajax({
                url: 'bank/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
        $(document).on('click', '.save-location', function () {
            let id = $(this).data('id');
            let data = {
                name: $(this).closest('tr').find('.name').val(),
            }
            $.ajax({
                url: 'location/' + id,
                data: data,
                method: 'PUT',
                success: function (data) {
                    if (data) {
                        swal({
                            title: 'Cập nhật thành công !!!',
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            })
        })
    </script>
@endsection
